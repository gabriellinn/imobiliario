<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class SiteController extends BaseController
{
    /**
     * @var UsuarioModel
     */
    protected $usuarioModel;

    /**
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->session = session();
    }

    public function header(): string|ResponseInterface
    {
        $usuario = $this->session->get('usuario_logado');
        return view('header');
    }
    /**
     * Exibe o dashboard principal.
     * Esta rota deve ser protegida por um filtro (ex: 'admin' ou 'auth').
     */
    public function dashboard(): string|ResponseInterface
    {
        // Verifica se o usuário está logado
        if (!$this->session->get('usuario_logado')) {
            return redirect()->to('/login');
        }

        // Busca os dados do usuário logado
        $usuario = $this->usuarioModel->find($this->session->get('usuario_id'));

        // Se o usuário não for encontrado no banco (ex: deletado), desloga
        if (!$usuario) {
            $this->session->destroy();
            return redirect()->to('/login')->with('erro', 'Sua sessão expirou.');
        }

        // Retorna a view correta
        return view('/admin/dashboard', [
            'usuario' => $usuario
        ]);
    }

    /**
     * Exibe a página inicial pública do site.
     */
   

    /**
     * Exibe a página de perfil do usuário logado.
     */
    public function meuPerfil(): string|ResponseInterface
    {
        // Verifica se o usuário está logado
        if (!$this->session->get('usuario_logado')) {
            return redirect()->to('/login');
        }

        // Busca os dados do usuário logado
        $usuario = $this->usuarioModel->find($this->session->get('usuario_id'));

        if (!$usuario) {
            $this->session->destroy();
            return redirect()->to('/login')->with('erro', 'Sua sessão expirou.');
        }

        // Retorna a view de perfil com os dados do usuário
        // Não é necessário passar 'nome' e 'email' separados,
        // pois eles já estão dentro do array $usuario.
        return view('perfil', [
            'usuario' => $usuario
        ]);
    }
   
    
    
}


