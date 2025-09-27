<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class SiteController extends BaseController
{
    protected $usuarioModel;
    protected $session;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->session = session();
    }

    public function dashboard()
    {
        // Verifica se o usuário está logado
        if (!$this->session->get('usuario_logado')) {
            return redirect()->to('/login');
        }

        // Busca os dados do usuário logado
        $usuario = $this->usuarioModel->find($this->session->get('usuario_id'));

        // Retorna a view correta
        return view('/dashboard', [
            'usuario' => $usuario
        ]);
    }
}
