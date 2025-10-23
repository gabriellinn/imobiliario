<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    protected $usuarioModel;
    protected $session;
    
    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->session = session();
    }

    // função para mostrar a view de login
    public function mostrarTelaLogin()
    {
        // se já estiver logado, redireciona para o dashboard
        if ($this->session->get('usuario_logado')) {
            return redirect()->to('paginainicial');
        }
        return view('auth/login');
    }

    // função para processar o login
    public function processarLogin()
    {
        $emailFormulario = $this->request->getPost('email');
        $senhaFormulario = $this->request->getPost('senha');

        // buscar o usuário pelo email
        $usuario = $this->usuarioModel->where('email', $emailFormulario)->first();
        
        // se existe usuario
        if ($usuario) {
            // verificar a senha se existe e se bate com a do banco
            $senhaValida = $this->usuarioModel->verificarSenha($senhaFormulario, $usuario['senha']);
            
            // se a senha for valida
            if ($senhaValida) {
                // No seu AuthController.php, mude isto:
$dadosSessao = [
    'usuario_logado' => true,
    'usuario_id'     => $usuario['id'],
    'nome'           => $usuario['nome'], // Use 'nome', não 'usuario_nome'
    'email'          => $usuario['email'],// Use 'email', não 'usuario_email'
    'tipo'           => $usuario['tipo']  // Use 'tipo', não 'usuario_tipo'
]; 
$this->session->set($dadosSessao);

                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/login')->with('erro', 'Usuário não encontrado');
            }
        }
        return redirect()->to('/login');
    }

    // função para logout
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }

    // função para gerar hash de senha
    public function gerarSenha()
    {
        var_dump(password_hash("123456", PASSWORD_DEFAULT));
    }
}
