<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AdminController
 * Gerencia o dashboard, a listagem de todos os usuários
 * e o CRUD específico de Corretores.
 */
class AdminController extends BaseController
{
    protected $model;
    protected $session; // Adicionado

    // Usamos o construtor para carregar o model e a session
    public function __construct()
    {
        $this->model = new UsuarioModel();
        $this->session = session(); // Adicionado
    }

    /**
     * O Index agora exibe o Dashboard com os dados do usuário
     */
    public function index()
    {
        // --- INÍCIO DA CORREÇÃO ---
        // Lógica que estava faltando: buscar o usuário logado
        $usuarioID = $this->session->get('usuario_id');
        
        if (!$usuarioID) {
            // Isso não deve acontecer por causa do filtro de rota, mas é uma boa defesa
             return redirect()->to('/login')->with('erro', 'Acesso negado.');
        }

        $usuario = $this->model->find($usuarioID);

        // Assumindo que sua view de dashboard está em admin/dashboard.php
        return view('admin/dashboard', [
            'usuario' => $usuario
        ]);
        // --- FIM DA CORREÇÃO ---
    }

    /**
     * NOVA FUNÇÃO: Listar TODOS os usuários
     */
    public function listarUsuarios()
    {
        // Busca TODOS os usuários, sem filtro de 'tipo'
        $dados['usuarios'] = $this->model->findAll();
        
        // Aponta para a nova view que criamos
        return view('admin/listar', $dados);
    }

    /**
     * CREATE (C do CRUD) - Parte 1: Mostrar o formulário
     * (Nome revertido de 'createCorretor' para 'create')
     */
    public function create()
    {
        // Passa dados nulos para a view saber que é um NOVO cadastro
        $dados = [
            'corretor' => null,
            'page_title' => 'Novo Corretor'
        ];
        // Aponta para a view dentro da pasta 'admin/'
        return view('admin/formulariocorretor', $dados);
    }

    /**
     * STORE (C do CRUD) - Parte 2: Salvar os dados
     * (Nome revertido de 'storeCorretor' para 'store')
     */
    public function store()
    {
        // 1. Regras de validação
        $regras = [
            'nome'  => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'senha' => 'required|min_length[6]',
            'confirmar_senha' => 'required|matches[senha]'
        ];

        // 2. Tenta rodar a validação
        if (!$this->validate($regras)) {
            // Se falhar, volta ao formulário com os erros
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Prepara os dados (SEM HASH, como solicitado)
        $dados = [
            'nome'  => $this->request->getPost('nome'),
            'email' => $this->request->getPost('email'),
            // password_hash() removido. O Model cuidará disso.
            'senha' => $this->request->getPost('senha'),
            'tipo'  => 'corretor' // Esta função especificamente cria um corretor
        ];

        // 4. Salva no banco
        try {
            $this->model->insert($dados);
            // 5. Redireciona para a NOVA lista de usuários
            return redirect()->to(site_url('admin/listar'))->with('sucesso', 'Corretor cadastrado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('erro', 'Erro ao salvar: ' . $e->getMessage());
        }
    }

    /**
     * EDIT (U do CRUD) - Parte 1: Mostrar o formulário
     * (Nome revertido de 'editCorretor' para 'edit')
     */
    public function edit($id)
    {
        $corretor = $this->model->find($id);

        // Validação extra: só edita se for do tipo 'corretor'
        if (empty($corretor) || $corretor['tipo'] !== 'corretor') {
            return redirect()->to(site_url('admin/listar'))->with('erro', 'Usuário não é um corretor válido.');
        }
        
        $dados = [
            'corretor' => $corretor,
            'page_title' => 'Editar Corretor'
        ];

        // Reutiliza a mesma view do 'create', mas agora com dados
        return view('admin/cadastrarcorretor', $dados);
    }

    /**
     * UPDATE (U do CRUD) - Parte 2: Salvar as alterações
     * (Nome revertido de 'updateCorretor' para 'update')
     */
    public function update($id)
    {
        // 1. Validação (Email deve ser único, mas ignorando o ID atual)
        $regras = [
            'nome'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[usuarios.email,id,$id]",
            'senha' => 'permit_empty|min_length[6]', // Senha é opcional no update
            'confirmar_senha' => 'matches[senha]'    // Só valida se 'senha' for preenchida
        ];

        if (!$this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Prepara os dados
        $dados = [
            'nome'  => $this->request->getPost('nome'),
            'email' => $this->request->getPost('email'),
            // O tipo não pode ser alterado aqui
        ];

        // 3. Lógica da Senha (Só atualiza se uma nova for digitada)
        $novaSenha = $this->request->getPost('senha');
        if (!empty($novaSenha)) {
            // password_hash() removido.
            $dados['senha'] = $novaSenha;
        }

        // 4. Salva no banco
        try {
            $this->model->update($id, $dados);
            // 5. Redireciona para a NOVA lista de usuários
            return redirect()->to(site_url('admin/listar'))->with('sucesso', 'Corretor atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('erro', 'Erro ao atualizar: ' . $e->getMessage());
        }
    }


    /**
     * DELETE (D do CRUD)
     * (Nome revertido de 'deleteCorretor' para 'delete')
     */
    public function delete($id)
    {
        try {
            $corretor = $this->model->find($id);

            // Validação extra: só deleta se for 'corretor'
            if (empty($corretor) || $corretor['tipo'] !== 'corretor') {
                return redirect()->to(site_url('admin/listar'))->with('erro', 'Usuário não é um corretor válido.');
            }

            $this->model->delete($id);
            // Redireciona para a NOVA lista de usuários
            return redirect()->to(site_url('admin/listar'))->with('sucesso', 'Corretor excluído com sucesso!');
        } catch (\Exception $e) {
            // Captura erro de chave estrangeira, etc.
            return redirect()->to(site_url('admin/listar'))->with('erro', 'Erro ao excluir: ' . $e->getMessage());
        }
    }
}

