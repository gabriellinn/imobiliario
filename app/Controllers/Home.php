<?php

namespace App\Controllers;

use App\Models\ImovelModel;
use App\Models\TipoImovelModel;
use App\Models\BairroModel;
use App\Models\FotosModel;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    protected $imovelModel;
    protected $tipoImovelModel;
    protected $bairroModel;
    protected $fotosModel;

    public function __construct()
    {
        $this->imovelModel = new ImovelModel();
        $this->tipoImovelModel = new TipoImovelModel();
        $this->bairroModel = new BairroModel();
        $this->fotosModel = new FotosModel();
    }

    public function index(): string
    {
        // Busca todos os imóveis disponíveis
        $imoveis = $this->imovelModel
            ->where('status', 'disponivel')
            ->orderBy('destaque', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Enriquece os dados com informações relacionadas
        foreach ($imoveis as &$imovel) {
            // Busca tipo de imóvel
            if (!empty($imovel['tipo_imovel_id'])) {
                $tipoImovel = $this->tipoImovelModel->find($imovel['tipo_imovel_id']);
                $imovel['tipo_imovel'] = $tipoImovel ? $tipoImovel['nome'] : 'Não informado';
            } else {
                $imovel['tipo_imovel'] = 'Não informado';
            }

            // Busca bairro
            if (!empty($imovel['bairro_id'])) {
                $bairro = $this->bairroModel->find($imovel['bairro_id']);
                $imovel['bairro'] = $bairro ? $bairro['nome'] . ' - ' . $bairro['cidade'] . '/' . $bairro['estado'] : 'Não informado';
            } else {
                $imovel['bairro'] = 'Não informado';
            }

            // Busca foto de capa
            $fotoCapa = $this->fotosModel
                ->where('imovel_id', $imovel['id'])
                ->where('capa', 1)
                ->first();
            
            if (!$fotoCapa) {
                // Se não tem capa, pega a primeira foto
                $fotoCapa = $this->fotosModel
                    ->where('imovel_id', $imovel['id'])
                    ->first();
            }
            
            $imovel['foto_capa'] = $fotoCapa ? base_url($fotoCapa['caminho']) : null;
        }

        $dados = [
            'imoveis' => $imoveis
        ];

        return view('paginainicial', $dados);
    }

    /**
     * SHOW (Detail)
     * Exibe todos os detalhes de um imóvel específico.
     */
    public function show($id = null): string|ResponseInterface
    {
        if (!$id) {
            return redirect()->to('/')->with('erro', 'Imóvel não encontrado.');
        }

        // Busca o imóvel
        $imovel = $this->imovelModel->find($id);

        if (!$imovel) {
            return redirect()->to('/')->with('erro', 'Imóvel não encontrado.');
        }

        // Busca tipo de imóvel
        if (!empty($imovel['tipo_imovel_id'])) {
            $tipoImovel = $this->tipoImovelModel->find($imovel['tipo_imovel_id']);
            $imovel['tipo_imovel'] = $tipoImovel;
        } else {
            $imovel['tipo_imovel'] = null;
        }

        // Busca bairro
        if (!empty($imovel['bairro_id'])) {
            $bairro = $this->bairroModel->find($imovel['bairro_id']);
            $imovel['bairro'] = $bairro;
        } else {
            $imovel['bairro'] = null;
        }

        // Busca todas as fotos do imóvel
        $fotos = $this->fotosModel
            ->where('imovel_id', $imovel['id'])
            ->orderBy('capa', 'DESC')
            ->orderBy('id', 'ASC')
            ->findAll();

        // Adiciona o caminho completo para cada foto
        foreach ($fotos as &$foto) {
            $foto['caminho_completo'] = base_url($foto['caminho']);
        }

        $dados = [
            'imovel' => $imovel,
            'fotos' => $fotos
        ];

        return view('imovel/detalhes', $dados);
    }
}
