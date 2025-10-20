<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class CorretorController extends BaseController
{
    public function cadastrarCorretor()
    {
        $UsuarioModel = new /app/Models/UsuarioModel();
          $usuario = $this->request->getPost('usuario');
          $email = $this->request->getPost('email');
          $senhaPlana = $this->request->getPost('senha');

          if (empty($email)) or (empty($senhaPlana)){
            return redirect()->back()->with('erro', 'Email e senha são obrigatórios');
          }

          // senha hash
          $senhaHash = password_hash ($senhaPlana, PASSWORD_DEFAULT);

          //Prepara os arrays de dados para colocar no banco de dado
          $dadosParaInserir = [
            'nome' => $usuario
            'email' => $email,
            'senha_hash' => $senhaHash, // Salva o hash, nunca a senha plana
            'role' => 'corretor' 




    }
}
