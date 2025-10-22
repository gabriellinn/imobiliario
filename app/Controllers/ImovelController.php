<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ImovelController extends BaseController
{
    public function index()
    {
        return view('cadastrarimovel');
    }

    public function registrarImovel(): ResponseInterface
    {
      $imovelModel = new \App\Models\ImovelModel();


       $dados = $this->request->getPost();

    // Monte os dados para salvar
    $imovel = [
        'titulo'         => $dados['titulo'] ?? null,
        'descricao'      => $dados['descricao'] ?? null,
        'preco_venda'    => $dados['preco_venda'] ?? null,
        'preco_aluguel'  => $dados['preco_aluguel'] ?? null,
        'finalidade'     => $dados['dados']['finalidade'] ?? null,
        'status'         => $dados['dados']['status'] ?? null,
        'dormitorios'    => $dados['dormitorios'] ?? null,
        'banheiros'      => $dados['banheiros'] ?? null,
        'garagem'        => $dados['garagem'] ?? null,
        'area_total'     => $dados['area_total'] ?? null,
        'area_construida'=> $dados['area_construida'] ?? null,
        'endereco'       => $dados['endereco'] ?? null,
        'numero'         => $dados['numero'] ?? null,
        'complemento'    => $dados['complemento'] ?? null,
        'caracteristicas'=> $dados['caracteristicas'] ?? null,
        'destaque'       => $dados['destaque'] ?? null,
        'usuario_id'     => session()->get('usuario_id') ?? null,
        'tipo_imovel_id' => '1',
        'bairro_id'    => '1',
    ];

    // Salve no banco usando seu Model
    $imovelModel = new \App\Models\ImovelModel();
    $imovelModel->insert($imovel);

    // Redirecione ou mostre mensagem de sucesso
    
        return redirect()->to(base_url('/paginainicial'));
    }
}
