<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ImovelModel;
use App\Models\TipoImovelModel;
use CodeIgniter\HTTP\ResponseInterface;

class ImovelController extends BaseController
{
    protected $imovelModel;
    protected $session;

    public function __construct()
    {
        $this->imovelModel = new ImovelModel();
        $this->session = session();
    }

    /**
     * READ (List)
     * Exibe uma lista de imóveis. O Admin vê tudo, o utilizador vê os seus.
     */
    public function index(): string|ResponseInterface
    {
        if (!$this->verificarAutenticacao()) {
            return redirect()->to('/login');
        }

        $usuarioId = $this->session->get('usuario_id');
        $usuarioTipo = $this->session->get('tipo');

        if ($usuarioTipo === 'admin') {
            $dados['imoveis'] = $this->imovelModel->findAll();
        } else {
            $dados['imoveis'] = $this->imovelModel
                ->where('usuario_id', $usuarioId)
                ->findAll();
        }

        return view('imovel/listar', $dados);
    }

    /**
     * CREATE (Show Form)
     * Exibe o formulário de cadastro de imóvel (vazio).
     */
    public function create(): string|ResponseInterface
    {
        if (!$this->verificarAutenticacao()) {
            return redirect()->to('/login');
        }

        $dados['imovel'] = null;
        return view('imovel/formularioimovel', $dados);
    }

    /**
     * STORE (Save New)
     * Salva os dados do novo imóvel no banco.
     */
    public function store(): ResponseInterface
    {
        if (!$this->verificarAutenticacao()) {
            return redirect()->to('/login');
        }

        $dados = $this->request->getPost();

        $tipoImovelId = $this->validarTipoImovel($dados['tipo_imovel_id'] ?? null);
        if ($tipoImovelId === false) {
            return redirect()->back()->withInput()->with('erro', 'Tipo de imóvel inválido.');
        }

        $imovel = $this->prepararDadosImovel($dados, $tipoImovelId);
        $imovel['usuario_id'] = $this->session->get('usuario_id');

        try {
            $this->imovelModel->insert($imovel);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('erro', 'Erro ao cadastrar imóvel: ' . $e->getMessage());
        }

        registrar_log(
            $this->session->get('usuario_id'),
            'Imóvel Criado: ' . ($dados['titulo'] ?? 'Sem título')
        );

        return redirect()->to('/imovel/listar')->with('sucesso', 'Imóvel cadastrado com sucesso!');
    }

    /**
     * EDIT (Show Form)
     * Exibe o formulário preenchido com os dados do imóvel para edição.
     */
    public function edit($id = null): string|ResponseInterface
    {
        if (!$this->verificarAutenticacao()) {
            return redirect()->to('/login');
        }

        $imovel = $this->imovelModel->find($id);
        if (!$imovel) {
            return redirect()->to('/imovel/listar')->with('erro', 'Imóvel não encontrado.');
        }

        if (!$this->verificarPermissao($imovel)) {
            return redirect()->to('/imovel/listar')->with('erro', 'Acesso negado: Não tem permissão para editar este imóvel.');
        }

        $dados['imovel'] = $imovel;
        return view('imovel/formularioimovel', $dados);
    }

    /**
     * UPDATE (Save Edit)
     * Salva as alterações do imóvel no banco.
     */
    public function update($id = null): ResponseInterface
    {
        if (!$this->verificarAutenticacao()) {
            return redirect()->to('/login');
        }

        $imovel = $this->imovelModel->find($id);
        if (!$imovel) {
            return redirect()->to('/imovel/listar')->with('erro', 'Imóvel não encontrado.');
        }

        if (!$this->verificarPermissao($imovel)) {
            return redirect()->to('/imovel/listar')->with('erro', 'Acesso negado: Não tem permissão para alterar este imóvel.');
        }

        $dados = $this->request->getPost();

        $tipoImovelId = $this->validarTipoImovel($dados['tipo_imovel_id'] ?? null);
        if ($tipoImovelId === false) {
            return redirect()->back()->withInput()->with('erro', 'Tipo de imóvel inválido.');
        }

        $dadosParaAtualizar = $this->prepararDadosImovel($dados, $tipoImovelId);

        try {
            $this->imovelModel->update($id, $dadosParaAtualizar);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('erro', 'Erro ao atualizar imóvel: ' . $e->getMessage());
        }

        registrar_log(
            $this->session->get('usuario_id'),
            'Imóvel Atualizado: ' . ($dadosParaAtualizar['titulo'] ?? 'Sem título')
        );

        return redirect()->to('/imovel/listar')->with('sucesso', 'Imóvel atualizado com sucesso!');
    }

    /**
     * DELETE (Action)
     * Exclui o imóvel do banco de dados.
     */
    public function delete($id = null): ResponseInterface
    {
        if (!$this->verificarAutenticacao()) {
            return redirect()->to('/login');
        }

        $imovel = $this->imovelModel->find($id);
        if (!$imovel) {
            return redirect()->to('/imovel/listar')->with('erro', 'Imóvel não encontrado.');
        }

        if (!$this->verificarPermissao($imovel)) {
            return redirect()->to('/imovel/listar')->with('erro', 'Acesso negado: Não tem permissão para excluir este imóvel.');
        }

        try {
            $this->imovelModel->delete($id);
        } catch (\Exception $e) {
            return redirect()->to('/imovel/listar')->with('erro', 'Erro ao excluir imóvel: ' . $e->getMessage());
        }

        registrar_log(
            $this->session->get('usuario_id'),
            'Imóvel Excluído: ' . ($imovel['titulo'] ?? 'ID ' . $id)
        );

        return redirect()->to('/imovel/listar')->with('sucesso', 'Imóvel excluído com sucesso!');
    }

    /**
     * Verifica se o usuário está autenticado
     */
    protected function verificarAutenticacao(): bool
    {
        return (bool) $this->session->get('usuario_logado');
    }

    /**
     * Verifica se o usuário tem permissão para acessar o imóvel
     */
    protected function verificarPermissao(array $imovel): bool
    {
        $usuarioTipo = $this->session->get('tipo');
        $usuarioId = $this->session->get('usuario_id');

        return $usuarioTipo === 'admin' || (int) $imovel['usuario_id'] === (int) $usuarioId;
    }

    /**
     * Valida e retorna o ID do tipo de imóvel, ou false se inválido
     */
    protected function validarTipoImovel($tipoImovelId): int|false|null
    {
        if (empty($tipoImovelId)) {
            return null;
        }

        $tipoImovelId = (int) $tipoImovelId;
        $tipoImovelModel = new TipoImovelModel();
        $tipoImovel = $tipoImovelModel->find($tipoImovelId);

        return $tipoImovel ? $tipoImovelId : false;
    }

    /**
     * Prepara os dados do imóvel para inserção/atualização
     */
    protected function prepararDadosImovel(array $dados, int|false|null $tipoImovelId): array
    {
        return [
            'titulo' => $dados['titulo'] ?? null,
            'descricao' => $dados['descricao'] ?? null,
            'preco_venda' => !empty($dados['preco_venda']) ? $dados['preco_venda'] : null,
            'preco_aluguel' => !empty($dados['preco_aluguel']) ? $dados['preco_aluguel'] : null,
            'finalidade' => $dados['finalidade'] ?? null,
            'status' => $dados['status'] ?? null,
            'dormitorios' => !empty($dados['dormitorios']) ? (int) $dados['dormitorios'] : 0,
            'banheiros' => !empty($dados['banheiros']) ? (int) $dados['banheiros'] : 0,
            'garagem' => !empty($dados['garagem']) ? (int) $dados['garagem'] : 0,
            'area_total' => !empty($dados['area_total']) ? $dados['area_total'] : null,
            'area_construida' => !empty($dados['area_construida']) ? $dados['area_construida'] : null,
            'endereco' => $dados['endereco'] ?? null,
            'numero' => $dados['numero'] ?? null,
            'complemento' => $dados['complemento'] ?? null,
            'caracteristicas' => $dados['caracteristicas'] ?? null,
            'destaque' => !empty($dados['destaque']) ? 1 : 0,
            'tipo_imovel_id' => $tipoImovelId !== false ? $tipoImovelId : null,
            'bairro_id' => !empty($dados['bairro_id']) ? (int) $dados['bairro_id'] : null,
        ];
    }
}
