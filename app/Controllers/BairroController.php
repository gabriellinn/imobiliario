<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BairroModel;
use CodeIgniter\HTTP\ResponseInterface;

class BairroController extends BaseController
{
    protected $bairroModel;
    protected $session;

    public function __construct()
    {
        $this->bairroModel = new BairroModel();
        $this->session = session();
    }

    /**
     * READ (List)
     * Lista todos os bairros.
     */
    public function index(): string|ResponseInterface
    {
        // A verificação de Admin é feita pelo Filtro de Rota
        $dados['bairros'] = $this->bairroModel->findAll();
        return view('admin/bairro/listar', $dados);
    }

    /**
     * CREATE (Show Form)
     * Exibe o formulário de cadastro (vazio).
     */
    public function create(): string|ResponseInterface
    {
        $dados['bairro'] = null; // Indica que é um novo cadastro
        return view('admin/bairro/formulario', $dados);
    }

    /**
     * STORE (Save New)
     * Salva o novo bairro no banco.
     */
    public function store(): ResponseInterface
    {
        // Regras de validação
        $regras = [
            'nome'    => 'required|min_length[3]|is_unique[bairros.nome]',
            'cidade'  => 'required|min_length[3]',
            'estado'  => 'required|exact_length[2]',
            'cep_inicial'     => 'required|min_length[8]', // Ex: 12345-678
            'cep_final'     => 'required|min_length[8]' // Ex: 12345-678
        ];

        if (!$this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dados = [
            'nome'    => $this->request->getPost('nome'),
            'cidade'  => $this->request->getPost('cidade'),
            'estado'  => $this->request->getPost('estado'),
            'cep_inicial'     => $this->request->getPost('cep_inicial'),
            'cep_final'     => $this->request->getPost('cep_final'),
        ];

        $this->bairroModel->insert($dados);
        $this->session->get('usuario_id');
        registrar_log(
            $this->session->get('usuario_id'),
            'Bairro Criado: ' . $dados['nome']
        );

        return redirect()->to('admin/bairro/listar')->with('sucesso', 'Bairro criado com sucesso!');
    }

    /**
     * EDIT (Show Form)
     * Exibe o formulário preenchido para edição.
     */
    public function edit($id = null): string|ResponseInterface
    {
        $bairro = $this->bairroModel->find($id);

        if (!$bairro) {
            return redirect()->to('admin/bairro/listar')->with('erro', 'Bairro não encontrado.');
        }

        $dados['bairro'] = $bairro;
        
        return view('admin/bairro/formulario', $dados);
    }

    /**
     * UPDATE (Save Edit)
     * Salva as alterações do bairro.
     */
    public function update($id = null): ResponseInterface
    {
        // Regras de validação
        $regras = [
            'nome'    => "required|min_length[3]|is_unique[bairros.nome,id,$id]",
            'cidade'  => 'required|min_length[3]',
            'estado'  => 'required|exact_length[2]',
            'cep_inicial'     => 'required|min_length[8]', // Ex: 12345-678
            'cep_final'     => 'required|min_length[8]' // Ex: 12345-678
        ];

        if (!$this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dados = [
            'nome'    => $this->request->getPost('nome'),
            'cidade'  => $this->request->getPost('cidade'),
            'estado'  => $this->request->getPost('estado'),
           'cep_inicial'     => $this->request->getPost('cep_inicial'),
            'cep_final'     => $this->request->getPost('cep_final'),
        ];

        $this->bairroModel->update($id, $dados);
        $this->session->get('usuario_id');
        registrar_log(
            $this->session->get('usuario_id'),
            'Bairro Editado: ' . $dados['nome']
        );


        return redirect()->to('admin/bairro/listar')->with('sucesso', 'Bairro atualizado com sucesso!');
    }

    /**
     * DELETE (Action)
     * Exclui o bairro.
     */
    public function delete($id = null): ResponseInterface
    {
        try {
            $this->bairroModel->delete($id);
            return redirect()->to('admin/bairro/listar')->with('sucesso', 'Bairro excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->to('admin/bairro/listar')->with('erro', 'Erro ao excluir: Este bairro pode estar em uso.');
        }
    }
}
