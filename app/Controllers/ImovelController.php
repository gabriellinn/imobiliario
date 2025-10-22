<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ImovelModel;
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
     * Exibe uma lista de imóveis pertencentes ao usuário logado.
     */
    public function index(): string|ResponseInterface
    {
        if (!$this->session->get('usuario_logado')) {
            return redirect()->to('/login');
            
            // return view('imovel/listar', $dados); // BUG: Código inacessível, removido.
        }

        $usuario_id = $this->session->get('usuario_id');

        $dados['imoveis'] = $this->imovelModel
            ->where('usuario_id', $usuario_id)
            ->findAll();

        // Caminho já estava correto
        return view('imovel/listar', $dados);
    }

    /**
     * CREATE (Show Form)
     * Exibe o formulário de cadastro de imóvel (vazio).
     */
    public function create(): string|ResponseInterface
    {
        if (!$this->session->get('usuario_logado')) {
            return redirect()->to('/login');
        }

        // Passa um array vazio para a view não dar erro na verificação
        $dados['imovel'] = null;
        
        // CORREÇÃO: Aponta para a subpasta 'imovel'
        return view('imovel/cadastrarimovel', $dados);
    }

    /**
     * STORE (Save New)
     * Salva os dados do novo imóvel no banco.
     */
    public function store(): ResponseInterface
    {
        if (!$this->session->get('usuario_logado')) {
            return redirect()->to('/login');
        }

        $dados = $this->request->getPost();

        // Corrigi o bug de 'dados' aninhado ('finalidade' e 'status')
        $imovel = [
            'titulo' => $dados['titulo'] ?? null,
            'descricao' => $dados['descricao'] ?? null,
            'preco_venda' => $dados['preco_venda'] ?? null,
            'preco_aluguel' => $dados['preco_aluguel'] ?? null,
            'finalidade' => $dados['finalidade'] ?? null, // Corrigido
            'status' => $dados['status'] ?? null,     // Corrigido
            'dormitorios' => $dados['dormitorios'] ?? null,
            'banheiros' => $dados['banheiros'] ?? null,
            'garagem' => $dados['garagem'] ?? null,
            'area_total' => $dados['area_total'] ?? null,
            'area_construida' => $dados['area_construida'] ?? null,
            'endereco' => $dados['endereco'] ?? null,
            'numero' => $dados['numero'] ?? null,
            'complemento' => $dados['complemento'] ?? null,
            'caracteristicas' => $dados['caracteristicas'] ?? null,
            'destaque' => $dados['destaque'] ?? null,
            'usuario_id' => $this->session->get('usuario_id'), // Garante que é do usuário logado
            'tipo_imovel_id' => $dados['tipo_imovel_id'] ?? null,
            'bairro_id' => '1', // Mantendo sua lógica
        ];

        $this->imovelModel->insert($imovel);

        // CORREÇÃO: Redireciona para '/imovel/listar' (singular, da nova rota)
        return redirect()->to('/imovel/listar')->with('sucesso', 'Imóvel cadastrado com sucesso!');
    }

    /**
     * EDIT (Show Form)
     * Exibe o formulário preenchido com os dados do imóvel para edição.
     */
    public function edit($id = null): string|ResponseInterface
    {
        if (!$this->session->get('usuario_logado')) {
            return redirect()->to('/login');
        }
        $usuario_id = $this->session->get('usuario_id');

        $imovel = $this->imovelModel->find($id);

        // Validação: Verifica se o imóvel existe E pertence ao usuário logado
        if (!$imovel || $imovel['usuario_id'] != $usuario_id) {
            // CORREÇÃO: Redireciona para '/imovel/listar' (singular, da nova rota)
            return redirect()->to('/imovel/listar')->with('erro', 'Imóvel não encontrado ou acesso negado.');
        }

        $dados['imovel'] = $imovel;

        // CORREÇÃO: Aponta para a subpasta 'imovel'
        return view('imovel/cadastrarimovel', $dados);
    }

    /**
     * UPDATE (Save Edit)
     * Salva as alterações do imóvel no banco.
     */
    public function update($id = null): ResponseInterface
    {
        if (!$this->session->get('usuario_logado')) {
            return redirect()->to('/login');
        }
        $usuario_id = $this->session->get('usuario_id');

        $imovel = $this->imovelModel->find($id);

        // Validação: Verifica se o imóvel existe E pertence ao usuário logado
        if (!$imovel || $imovel['usuario_id'] != $usuario_id) {
            // CORREÇÃO: Redireciona para '/imovel/listar' (singular, da nova rota)
            return redirect()->to('/imovel/listar')->with('erro', 'Imóvel não encontrado ou acesso negado.');
        }

        $dados = $this->request->getPost();

        $dadosParaAtualizar = [
            'titulo' => $dados['titulo'] ?? null,
            'descricao' => $dados['descricao'] ?? null,
            'preco_venda' => $dados['preco_venda'] ?? null,
            'preco_aluguel' => $dados['preco_aluguel'] ?? null,
            'finalidade' => $dados['finalidade'] ?? null,
            'status' => $dados['status'] ?? null,
            'dormitorios' => $dados['dormitorios'] ?? null,
            'banheiros' => $dados['banheiros'] ?? null,
            'garagem' => $dados['garagem'] ?? null,
            'area_total' => $dados['area_total'] ?? null,
            'area_construida' => $dados['area_construida'] ?? null,
            'endereco' => $dados['endereco'] ?? null,
            'numero' => $dados['numero'] ?? null,
            'complemento' => $dados['complemento'] ?? null,
            'caracteristicas' => $dados['caracteristicas'] ?? null,
            'destaque' => $dados['destaque'] ?? null,
            'tipo_imovel_id' => $dados['tipo_imovel_id'] ?? null,
            // Não atualiza usuario_id ou bairro_id
        ];

        $this->imovelModel->update($id, $dadosParaAtualizar);

        // CORREÇÃO: Redireciona para '/imovel/listar' (singular, da nova rota)
        return redirect()->to('/imovel/listar')->with('sucesso', 'Imóvel atualizado com sucesso!');
    }

    /**
     * DELETE (Action)
     * Exclui o imóvel do banco de dados.
     */
    public function delete($id = null): ResponseInterface
    {
        if (!$this->session->get('usuario_logado')) {
            return redirect()->to('/login');
        }
        $usuario_id = $this->session->get('usuario_id');

        $imovel = $this->imovelModel->find($id);

        // Validação: Verifica se o imóvel existe E pertence ao usuário logado
        if (!$imovel || $imovel['usuario_id'] != $usuario_id) {
            // CORREÇÃO: Redireciona para '/imovel/listar' (singular, da nova rota)
            return redirect()->to('/imovel/listar')->with('erro', 'Imóvel não encontrado ou acesso negado.');
        }

        $this->imovelModel->delete($id);
         // CORREÇÃO: Redireciona para '/imovel/listar' (singular, da nova rota)
        return redirect()->to('/imovel/listar')->with('sucesso', 'Imóvel excluído com sucesso!');
    }
}

