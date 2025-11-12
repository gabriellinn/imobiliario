<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TipoImovelModel;
use CodeIgniter\HTTP\ResponseInterface;

class TipoImovelController extends BaseController
{
    protected $tipoImovelModel;
    protected $session;

    public function __construct()
    {
        $this->tipoImovelModel = new TipoImovelModel();
        $this->session = session();
    }

    /**
     * READ (List)
     * Lista todos os tipos de imóveis.
     */
    public function index(): string|ResponseInterface
    {
        // A verificação de Admin é feita pelo Filtro de Rota
        $dados['tipos'] = $this->tipoImovelModel->findAll();
        return view('admin/tipoimoveis/listar', $dados);
    }

    /**
     * CREATE (Show Form)
     * Exibe o formulário de cadastro (vazio).
     */
    public function create(): string|ResponseInterface
    {
        $dados['tipo'] = null; // Indica que é um novo cadastro
        return view('admin/tipoimoveis/formulario', $dados);
    }

    /**
     * STORE (Save New)
     * Salva o novo tipo de imóvel no banco.
     */
    public function store(): ResponseInterface
    {
        // Regras de validação
        $regras = [
            'nome' => 'required|min_length[3]|is_unique[tipos_imoveis.nome]',
            'descricao' => 'permit_empty|min_length[5]'
        ];

        if (!$this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dados = [
            'nome' => $this->request->getPost('nome'),
            'descricao' => $this->request->getPost('descricao'),
        ];

        $this->tipoImovelModel->insert($dados);
        
        registrar_log(
            $this->session->get('usuario_id'),
            'Tipo de Imóvel Criado: ' . $dados['nome']
        );

        return redirect()->to('admin/tipoimoveis/listar')->with('sucesso', 'Tipo de imóvel criado com sucesso!');
    }

    /**
     * EDIT (Show Form)
     * Exibe o formulário preenchido para edição.
     */
    public function edit($id = null): string|ResponseInterface
    {
        $tipo = $this->tipoImovelModel->find($id);

        if (!$tipo) {
            return redirect()->to('admin/tipoimoveis/listar')->with('erro', 'Tipo de imóvel não encontrado.');
        }

        $dados['tipo'] = $tipo;
        return view('admin/tipoimoveis/formulario', $dados);
    }

    /**
     * UPDATE (Save Edit)
     * Salva as alterações do tipo de imóvel.
     */
    public function update($id = null): ResponseInterface
    {
        // Regras de validação (ignora o ID atual na verificação de 'is_unique')
        $regras = [
            'nome' => "required|min_length[3]|is_unique[tipos_imoveis.nome,id,$id]",
            'descricao' => 'permit_empty|min_length[5]'
        ];

        if (!$this->validate($regras)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dados = [
            'nome' => $this->request->getPost('nome'),
            'descricao' => $this->request->getPost('descricao'),
        ];

        $this->tipoImovelModel->update($id, $dados);
        
        registrar_log(
            $this->session->get('usuario_id'),
            'Tipo de Imóvel Editado: ' . $dados['nome']
        );

        return redirect()->to('admin/tipoimoveis/listar')->with('sucesso', 'Tipo de imóvel atualizado com sucesso!');
    }

    /**
     * DELETE (Action)
     * Exclui o tipo de imóvel.
     */
    public function delete($id = null): ResponseInterface
    {
        $tipo = $this->tipoImovelModel->find($id);

        if (!$tipo) {
            return redirect()->to('admin/tipoimoveis/listar')->with('erro', 'Tipo de imóvel não encontrado.');
        }

        try {
            $this->tipoImovelModel->delete($id);
            
            registrar_log(
                $this->session->get('usuario_id'),
                'Tipo de Imóvel Excluído: ' . ($tipo['nome'] ?? 'ID ' . $id)
            );
            
            return redirect()->to('admin/tipoimoveis/listar')->with('sucesso', 'Tipo de imóvel excluído com sucesso!');
        } catch (\Exception $e) {
            // Captura erro (ex: chave estrangeira em uso)
            return redirect()->to('admin/tipoimoveis/listar')->with('erro', 'Erro ao excluir: Este tipo está sendo usado por um imóvel.');
        }
    }
}

