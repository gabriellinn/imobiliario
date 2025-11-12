<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AdminController
 * Gerencia o dashboard, a listagem de todos os usuários
 * e o CRUD específico de Corretores.
 *
 * @versao 2.0 (Com logs integrados)
 */
class AdminController extends BaseController
{
    protected $model;
    protected $session;

    public function __construct()
    {
        // Carrega o helper de log que criamos
         
        
        $this->model = new UsuarioModel();
        $this->session = session();
    }

    /**
     * O Index agora exibe o Dashboard com os dados do usuário
     */
    public function index()
    {
        $usuarioID = $this->session->get('usuario_id');
        
        if (!$usuarioID) {
            return redirect()->to('/login')->with('erro', 'Acesso negado.');
        }

        $usuario = $this->model->find($usuarioID);

        // Assumindo que sua view de dashboard está em admin/dashboard.php
        return view('admin/dashboard', [
            'usuario' => $usuario
        ]);
    }

    /**
     * NOVA FUNÇÃO: Listar TODOS os usuários
     */
    public function listarUsuarios()
    {
        $dados['usuarios'] = $this->model->findAll();
        
        // Aponta para a nova view que criamos
        return view('admin/listar', $dados);
    }

    /**
     * CREATE (C do CRUD) - Parte 1: Mostrar o formulário
     */
    public function create()
    {
        $dados = [
            'corretor' => null,
            'page_title' => 'Novo Corretor'
        ];
        // Aponta para a view dentro da pasta 'admin/'
        return view('admin/formulariocorretor', $dados);
    }

    /**
     * STORE (C do CRUD) - Parte 2: Salvar os dados
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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Prepara os dados
        $dados = [
            'nome'  => $this->request->getPost('nome'),
            'email' => $this->request->getPost('email'),
            'senha' => $this->request->getPost('senha'),
            'tipo'  => 'corretor'
        ];

        // 4. Salva no banco
        try {
            if ($this->model->insert($dados)) {
                
                // --- INÍCIO DA INTEGRAÇÃO DO LOG ---
                $adminID = $this->session->get('usuario_id');
                $novoCorretorID = $this->model->getInsertID(); // Pega o ID do usuário recém-criado
                registrar_log(
                    $adminID, 
                    'Cadastrou novo corretor ID: ' . $novoCorretorID
                );
                // --- FIM DA INTEGRAÇÃO DO LOG ---

                // 5. Redireciona
                return redirect()->to(site_url('admin/listar'))->with('sucesso', 'Corretor cadastrado com sucesso!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('erro', 'Erro ao salvar: ' . $e->getMessage());
        }
    }

    /**
     * EDIT (U do CRUD) - Parte 1: Mostrar o formulário
     */
    public function edit($id)
    {
        $corretor = $this->model->find($id);

        if (empty($corretor) || $corretor['tipo'] !== 'corretor') {
            return redirect()->to(site_url('admin/listar'))->with('erro', 'Usuário não é um corretor válido.');
        }
        
        $dados = [
            'corretor' => $corretor,
            'page_title' => 'Editar Corretor'
        ];

        // Reutiliza a mesma view do 'create'
        // (Corrigido de 'admin/cadastrarcorretor' para 'admin/formulariocorretor')
        return view('admin/formulariocorretor', $dados);
    }

    /**
     * UPDATE (U do CRUD) - Parte 2: Salvar as alterações
     */
    public function update($id)
    {
        // 1. Validação
        $regras = [
            'nome'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[usuarios.email,id,$id]",
            'senha' => 'permit_empty|min_length[6]',
            'confirmar_senha' => 'matches[senha]'
        ];

        if (!$this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Prepara os dados
        $dados = [
            'nome'  => $this->request->getPost('nome'),
            'email' => $this->request->getPost('email'),
        ];

        // 3. Lógica da Senha
        $novaSenha = $this->request->getPost('senha');
        if (!empty($novaSenha)) {
            $dados['senha'] = $novaSenha;
        }

        // 4. Salva no banco
        try {
            if ($this->model->update($id, $dados)) {
                
                // --- INÍCIO DA INTEGRAÇÃO DO LOG ---
                $adminID = $this->session->get('usuario_id');
                registrar_log(
                    $adminID,
                    'Atualizou dados do corretor ID: ' . $id
                );
                // --- FIM DA INTEGRAÇÃO DO LOG ---

                // 5. Redireciona
                return redirect()->to(site_url('admin/listar'))->with('sucesso', 'Corretor atualizado com sucesso!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('erro', 'Erro ao atualizar: ' . $e->getMessage());
        }
    }


    /**
     * DELETE (D do CRUD)
     */
    public function delete($id)
    {
        try {
            $corretor = $this->model->find($id);

            if (empty($corretor) || $corretor['tipo'] !== 'corretor') {
                return redirect()->to(site_url('admin/listar'))->with('erro', 'Usuário não é um corretor válido.');
            }

            if ($this->model->delete($id)) {
                
                // --- INÍCIO DA INTEGRAÇÃO DO LOG ---
                $adminID = $this->session->get('usuario_id');
                registrar_log(
                    $adminID,
                    'Excluiu corretor ID: ' . $id
                );
                // --- FIM DA INTEGRAÇÃO DO LOG ---

                // Redireciona
                return redirect()->to(site_url('admin/listar'))->with('sucesso', 'Corretor excluído com sucesso!');
            }

        } catch (\Exception $e) {
            // Captura erro de chave estrangeira (ex: se o corretor tiver imóveis ligados a ele)
            return redirect()->to(site_url('admin/listar'))->with('erro', 'Erro ao excluir: ' . $e->getMessage());
        }
    }
}