<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ImovelModel;
use App\Models\FotosModel;
use CodeIgniter\HTTP\ResponseInterface;

class FotosImoveisController extends BaseController
{
    protected $photoModel;
    protected $imovelModel;
    protected $session;

    public function __construct()
    {
        $this->photoModel = new FotosModel();
        $this->imovelModel = new ImovelModel();
        $this->session = session();
        helper(['form', 'url']);
    }

    /**
     * READ
     * Exibe a página de gestão de fotos para um imóvel específico.
     * CORREÇÃO: Renomeado de 'read' para 'listar' para bater com as Rotas.
     */
    public function read($imovel_id = null): string|ResponseInterface
    {
        // A validação de acesso foi removida (feita via Rota)
        // Apenas buscamos o imóvel para exibir o título
        $imovel = $this->imovelModel->find($imovel_id);
        if (!$imovel) {
            return redirect()->to('/imovel/listar')->with('erro', 'Imóvel não encontrado.');
        }

        // 2. Buscar fotos
        $dados = [
            'imovel' => $imovel,
            'fotos' => $this->photoModel->where('imovel_id', $imovel_id)->findAll(),
            'header' => view('partials/header') // Corrigido para usar view()
        ];

        return view('imovel/fotos', $dados);
    }

    /**
     * CREATE
     * Processa o upload de uma nova foto.
     */
    public function create($imovel_id = null): ResponseInterface
    {
        // A validação de acesso foi removida (feita via Rota)

        // 2. Validar o Ficheiro
        $file = $this->request->getFile('foto');

        if (!$file->isValid() || $file->hasMoved()) {
            return redirect()->back()->with('erro', 'Erro no upload: ' . $file->getErrorString());
        }

        // 3. Mover o Ficheiro
        // (Certifique-se que a pasta 'public/uploads/imoveis' existe e tem permissão de escrita)
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/imoveis', $newName);
        $path = 'uploads/imoveis/' . $newName;

        // 4. Salvar no Banco
        $this->photoModel->save([
            'imovel_id' => $imovel_id,
            'nome_arquivo' => $file->getClientName(),
            'caminho' => $path,
            'capa' => false // Novas fotos nunca são capa por defeito
        ]);

        return redirect()->back()->with('sucesso', 'Foto enviada com sucesso!');
    }

    /**
     * UPDATE (Usado para definir a foto de capa)
     * Define uma foto como a capa do imóvel.
     */
    public function update($id = null): ResponseInterface
    {
        $foto = $this->photoModel->find($id);
        if (!$foto) {
            return redirect()->back()->with('erro', 'Foto não encontrada.');
        }

        // A validação de acesso foi removida (feita via Rota)
        $imovel_id = $foto['imovel_id'];

        // 2. Lógica da Capa (Transação)
        $this->photoModel->db->transStart();
        // Remove a capa de todas as fotos deste imóvel
        $this->photoModel->where('imovel_id', $imovel_id)->set(['capa' => 0])->update();
        // Define a nova capa
        $this->photoModel->update($id, ['capa' => 1]);
        $this->photoModel->db->transComplete();

        return redirect()->back()->with('sucesso', 'Foto de capa atualizada!');
    }

    /**
     * DELETE
     * Exclui uma foto do banco e do servidor.
     */
    public function delete($id = null): ResponseInterface
    {
        $foto = $this->photoModel->find($id);
        if (!$foto) {
            return redirect()->back()->with('erro', 'Foto não encontrada.');
        }

        // A validação de acesso foi removida (feita via Rota)

        // 2. Apagar o Ficheiro do Servidor
        // (Verifica se o ficheiro existe antes de tentar apagar)
        $filePath = FCPATH . $foto['caminho'];
        if (file_exists($filePath)) {
            @unlink($filePath); // O '@' suprime erros se o ficheiro não puder ser apagado
        }

        // 3. Apagar do Banco
        $this->photoModel->delete($id);

        return redirect()->back()->with('sucesso', 'Foto excluída com sucesso!');
    }

    // A função private function checkAccess() foi removida
}

