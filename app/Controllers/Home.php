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
    $request = service('request');

    // Receber filtros via GET
    $bairro = $request->getGet('bairro');
    $tipo   = $request->getGet('tipo');
    $finalidade = $request->getGet('finalidade');

    // Inicia busca
    $builder = $this->imovelModel
        ->where('status', 'disponivel');

    // Aplicar filtros
    if (!empty($bairro)) {
        $builder->where('bairro_id', $bairro);
    }

    if (!empty($tipo)) {
        $builder->where('tipo_imovel_id', $tipo);
    }

    if (!empty($finalidade)) {
        $builder->where('finalidade', $finalidade);
    }

    // Ordenação
    $imoveis = $builder
        ->orderBy('destaque', 'DESC')
        ->orderBy('created_at', 'DESC')
        ->findAll();

    // Enriquecer dados
    foreach ($imoveis as &$imovel) {

        // Tipo
        $tipoImovel = $this->tipoImovelModel->find($imovel['tipo_imovel_id']);
        $imovel['tipo_imovel'] = $tipoImovel['nome'] ?? 'Não informado';

        // Bairro
        $bairroData = $this->bairroModel->find($imovel['bairro_id']);
        $imovel['bairro'] = $bairroData 
            ? $bairroData['nome'] . ' - ' . $bairroData['cidade'] . '/' . $bairroData['estado'] 
            : 'Não informado';

        // Foto
        $fotoCapa = $this->fotosModel
            ->where('imovel_id', $imovel['id'])
            ->where('capa', 1)
            ->first();

        if (!$fotoCapa) {
            $fotoCapa = $this->fotosModel
                ->where('imovel_id', $imovel['id'])
                ->first();
        }

        $imovel['foto_capa'] = $fotoCapa ? base_url($fotoCapa['caminho']) : null;
    }

    // Buscar listas para os selects
    $listaTipos = $this->tipoImovelModel->findAll();
    $listaBairros = $this->bairroModel->findAll();

    $dados = [
        'imoveis'       => $imoveis,
        'listaTipos'    => $listaTipos,
        'listaBairros'  => $listaBairros,
        'filtros' => [
            'bairro'    => $bairro,
            'tipo'      => $tipo,
            'finalidade'=> $finalidade
        ]
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
