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
        return view('imovel/formularioimovel', $dados);
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

        // Valida e processa tipo_imovel_id
        $tipoImovelId = !empty($dados['tipo_imovel_id']) ? (int)$dados['tipo_imovel_id'] : null;
        
        // Se tipo_imovel_id foi fornecido, valida se existe
        if ($tipoImovelId !== null) {
            $tipoImovelModel = new \App\Models\TipoImovelModel();
            $tipoImovel = $tipoImovelModel->find($tipoImovelId);
            if (!$tipoImovel) {
                return redirect()->back()->withInput()->with('erro', 'Tipo de imóvel inválido. Por favor, execute o seeder primeiro.');
            }
        }

        // Corrigi o bug de 'dados' aninhado ('finalidade' e 'status')
        $imovel = [
            'titulo' => $dados['titulo'] ?? null,
            'descricao' => $dados['descricao'] ?? null,
            'preco_venda' => !empty($dados['preco_venda']) ? $dados['preco_venda'] : null,
            'preco_aluguel' => !empty($dados['preco_aluguel']) ? $dados['preco_aluguel'] : null,
            'finalidade' => $dados['finalidade'] ?? null, // Corrigido
            'status' => $dados['status'] ?? null,     // Corrigido
            'dormitorios' => !empty($dados['dormitorios']) ? (int)$dados['dormitorios'] : 0,
            'banheiros' => !empty($dados['banheiros']) ? (int)$dados['banheiros'] : 0,
            'garagem' => !empty($dados['garagem']) ? (int)$dados['garagem'] : 0,
            'area_total' => !empty($dados['area_total']) ? $dados['area_total'] : null,
            'area_construida' => !empty($dados['area_construida']) ? $dados['area_construida'] : null,
            'endereco' => $dados['endereco'] ?? null,
            'numero' => $dados['numero'] ?? null,
            'complemento' => $dados['complemento'] ?? null,
            'caracteristicas' => $dados['caracteristicas'] ?? null,
            'destaque' => !empty($dados['destaque']) ? 1 : 0,
            'usuario_id' => $this->session->get('usuario_id'), // Garante que é do usuário logado
            'tipo_imovel_id' => $tipoImovelId,
            'bairro_id' => !empty($dados['bairro_id']) ? (int)$dados['bairro_id'] : null,
        ];

        try {
            $this->imovelModel->insert($imovel);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('erro', 'Erro ao cadastrar imóvel: ' . $e->getMessage());
        }
        registrar_log(
            $this->session->get('usuario_id'),
            'Imóvel Criado: ' . ($dados['titulo'] ?? 'Sem título')
        );


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

        // Valida e processa tipo_imovel_id
        $tipoImovelId = !empty($dados['tipo_imovel_id']) ? (int)$dados['tipo_imovel_id'] : null;
        
        // Se tipo_imovel_id foi fornecido, valida se existe
        if ($tipoImovelId !== null) {
            $tipoImovelModel = new \App\Models\TipoImovelModel();
            $tipoImovel = $tipoImovelModel->find($tipoImovelId);
            if (!$tipoImovel) {
                return redirect()->back()->withInput()->with('erro', 'Tipo de imóvel inválido.');
            }
        }

        $dadosParaAtualizar = [
            'titulo' => $dados['titulo'] ?? null,
            'descricao' => $dados['descricao'] ?? null,
            'preco_venda' => !empty($dados['preco_venda']) ? $dados['preco_venda'] : null,
            'preco_aluguel' => !empty($dados['preco_aluguel']) ? $dados['preco_aluguel'] : null,
            'finalidade' => $dados['finalidade'] ?? null,
            'status' => $dados['status'] ?? null,
            'dormitorios' => !empty($dados['dormitorios']) ? (int)$dados['dormitorios'] : 0,
            'banheiros' => !empty($dados['banheiros']) ? (int)$dados['banheiros'] : 0,
            'garagem' => !empty($dados['garagem']) ? (int)$dados['garagem'] : 0,
            'area_total' => !empty($dados['area_total']) ? $dados['area_total'] : null,
            'area_construida' => !empty($dados['area_construida']) ? $dados['area_construida'] : null,
            'endereco' => $dados['endereco'] ?? null,
            'numero' => $dados['numero'] ?? null,
            'complemento' => $dados['complemento'] ?? null,
            'caracteristicas' => $dados['caracteristicas'] ?? null,
            'destaque' => !empty($dados['destaque']) ? 1 : 0,
            'tipo_imovel_id' => $tipoImovelId,
            // Não atualiza usuario_id ou bairro_id
        ];

        try {
            $this->imovelModel->update($id, $dadosParaAtualizar);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('erro', 'Erro ao atualizar imóvel: ' . $e->getMessage());
        }
        registrar_log(
            $this->session->get('usuario_id'),
            'Imóvel Atualizado: ' . ($dadosParaAtualizar['titulo'] ?? 'Sem título')
        );


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

        registrar_log(
            $this->session->get('usuario_id'),
            'Imóvel Excluído: ' . ($imovel['titulo'] ?? 'ID ' . $id)
        );
        
        $this->imovelModel->delete($id);
        // CORREÇÃO: Redireciona para '/imovel/listar' (singular, da nova rota)
        return redirect()->to('/imovel/listar')->with('sucesso', 'Imóvel excluído com sucesso!');
    }
}

