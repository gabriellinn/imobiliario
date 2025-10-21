<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class CorretorController extends BaseController
{

    public function CadastrarCorretorFormulario()
    {
        return view('cadastrarcorretor');
    }
    public function cadastrarCorretor()
    {
      // 1. Define as regras de validação
    $regras = [
        'email' => [
            'rules' => 'required|valid_email|is_unique[usuarios.email]', // 'usuarios' é o nome da tabela
            'errors' => [
                'required' => 'O campo email é obrigatório.',
                'valid_email' => 'Por favor, insira um email válido.',
                'is_unique' => 'Este email já está cadastrado.'
            ]
        ],
        'senha' => [
            'rules' => 'required|min_length[6]', // Ex: mínimo de 6 caracteres
            'errors' => [
                'required' => 'O campo senha é obrigatório.',
                'min_length' => 'A senha deve ter pelo menos 6 caracteres.'
            ]
        ],
        'confirmar_senha' => [
            'rules' => 'required|matches[senha]', // <-- A MÁGICA ACONTECE AQUI
            'errors' => [
                'required' => 'Por favor, confirme sua senha.',
                'matches' => 'As senhas não conferem.'
            ]
        ]
    ];

    // 2. Tenta rodar a validação
    if (!$this->validate($regras)) {
        // Se a validação falhar, redireciona de volta para o formulário
        // O CI automaticamente envia os erros de volta
        // E também envia os dados antigos (função 'old()')
        return redirect()->back()->withInput()->with('erro', $this->validator->listErrors());
    }
        $usuarioModel = new UsuarioModel();
          $usuario = $this->request->getPost('nome');
          $email = $this->request->getPost('email');
          $senhaPlana = $this->request->getPost('senha');

          if (empty($email) || empty($senhaPlana)) {
            return redirect()->back()->with('erro', 'Email e senha são obrigatórios');
          }

          
         

          //Prepara os arrays de dados para colocar no banco de dado
          $dadosParaInserir = [
            'nome' => $usuario,
            'email' => $email,
            'senha' => $senhaPlana, // Salva o hash, nunca a senha plana
            'tipo' => 'corretor' 
          ];
         try {
            $usuarioModel->insert($dadosParaInserir);

            // ----- LINHA ADICIONADA -----
            // Destrói a sessão atual (fazendo o logout do admin)
            session()->destroy();
            // -----------------------------

            return redirect()->to('/login')->with('sucesso', 'Corretor cadastrado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()->with('erro', $e->getMessage());
        }




    }
}
