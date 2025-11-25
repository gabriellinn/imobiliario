<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use App\Models\ImovelModel;
use App\Models\LogsModel;
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
    public function update($id): ResponseInterface
    {
        // Verifica se o corretor existe
        $corretor = $this->model->find($id);
        if (empty($corretor) || $corretor['tipo'] !== 'corretor') {
            return redirect()->to(site_url('admin/listar'))->with('erro', 'Usuário não é um corretor válido.');
        }

        // 1. Validação
        $novaSenha = $this->request->getPost('senha');
        $regras = [
            'nome'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[usuarios.email,id,$id]",
        ];

        // Só valida senha se foi informada
        if (!empty($novaSenha)) {
            $regras['senha'] = 'required|min_length[6]';
            $regras['confirmar_senha'] = 'required|matches[senha]';
        }

        if (!$this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Prepara os dados
        $dados = [
            'nome'  => $this->request->getPost('nome'),
            'email' => $this->request->getPost('email'),
        ];

        // 3. Lógica da Senha - só atualiza se foi informada
        if (!empty($novaSenha)) {
            $dados['senha'] = $novaSenha;
        }

        // 4. Salva no banco
        try {
            // Desabilita a validação do modelo (já validamos no controller)
            $this->model->skipValidation(true);
            $resultado = $this->model->update($id, $dados);
            $this->model->skipValidation(false);
            
            if ($resultado) {
                // --- INÍCIO DA INTEGRAÇÃO DO LOG ---
                $adminID = $this->session->get('usuario_id');
                registrar_log(
                    $adminID,
                    'Atualizou dados do corretor ID: ' . $id
                );
                // --- FIM DA INTEGRAÇÃO DO LOG ---

                // 5. Redireciona
                return redirect()->to(site_url('admin/listar'))->with('sucesso', 'Corretor atualizado com sucesso!');
            } else {
                return redirect()->back()->withInput()->with('erro', 'Nenhuma alteração foi realizada.');
            }
        } catch (\Exception $e) {
            $this->model->skipValidation(false);
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

            // Verifica se há imóveis associados ao corretor
            $imovelModel = new ImovelModel();
            $imoveis = $imovelModel->where('usuario_id', $id)->findAll();
            
            if (!empty($imoveis)) {
                // Busca um admin para transferir os imóveis
                $admin = $this->model->where('tipo', 'admin')->first();
                
                if (empty($admin)) {
                    return redirect()->to(site_url('admin/listar'))->with('erro', 'Não é possível excluir o corretor: ele possui imóveis cadastrados e não há um administrador disponível para transferência.');
                }
                
                // Transfere os imóveis para o admin
                $imovelModel->builder()->where('usuario_id', $id)->update(['usuario_id' => $admin['id']]);
            }

            // Agora pode excluir o corretor
            if ($this->model->delete($id)) {
                
                // --- INÍCIO DA INTEGRAÇÃO DO LOG ---
                $adminID = $this->session->get('usuario_id');
                $mensagemLog = 'Excluiu corretor ID: ' . $id;
                if (!empty($imoveis)) {
                    $mensagemLog .= ' (transferiu ' . count($imoveis) . ' imóvel(is) para admin ID: ' . $admin['id'] . ')';
                }
                registrar_log(
                    $adminID,
                    $mensagemLog
                );
                // --- FIM DA INTEGRAÇÃO DO LOG ---

                // Redireciona
                $mensagem = 'Corretor excluído com sucesso!';
                if (!empty($imoveis)) {
                    $mensagem .= ' Os imóveis foram transferidos para o administrador.';
                }
                return redirect()->to(site_url('admin/listar'))->with('sucesso', $mensagem);
            }

        } catch (\Exception $e) {
            // Captura erro de chave estrangeira (ex: se o corretor tiver imóveis ligados a ele)
            return redirect()->to(site_url('admin/listar'))->with('erro', 'Erro ao excluir: ' . $e->getMessage());
        }
    }

    public function logs()
{
    // 1. Instancia o Model
    $logsModel = new \App\Models\LogsModel();

    // 2. PEGA O usuario_id DA SESSÃO E ATRIBUI À VARIÁVEL
    // Certifique-se de que a Session está carregada no seu Controller.
    // O CI4 injeta a sessão automaticamente, então podemos acessar via $this->session.
    $usuarioId = session()->get('usuario_id');
    
    // Verifica se o ID do usuário foi encontrado na sessão
    if (empty($usuarioId)) {
        // Trate o caso em que o usuário não está logado (ex: redirecione ou mostre uma mensagem)
        // Por exemplo: return redirect()->to('login');
        // Vou definir $usuarioId como null para mostrar todos os logs se não houver ID (opcional)
        // ou você pode retornar uma view de erro.
        $logs = []; 
        log_message('error', 'Tentativa de acesso à logs sem usuario_id na sessão.');
    } else {
        // 3. FILTRA OS LOGS USANDO O ID DO USUÁRIO
        $logs = $logsModel
                ->where('id_usuario', $usuarioId) // Filtra apenas os logs deste usuário
                ->orderBy('created_at', 'DESC')
                ->findAll();
    }
    
    $data = [
        'logs' => $logs,
        'title' => 'Meus Logs de Atividade',
        'usuarioId' => $usuarioId // Opcional: passa o ID para a view
    ];

    // Carrega a View, que deve estar em app/Views/admin/logs.php
    return view('admin/logs', $data);
}
}