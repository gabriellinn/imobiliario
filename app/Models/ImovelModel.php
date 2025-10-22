<?php

namespace App\Models;

use CodeIgniter\Model;

class ImovelModel extends Model
{
    protected $table = 'imoveis'; // Nome da tabela no banco
    protected $primaryKey = 'id'; // Nome da chave primária

    // Campos permitidos para inserção/atualização
    protected $allowedFields = [
        'titulo',
        'descricao',
        'preco_venda',
        'preco_aluguel',
        'finalidade',
        'status',
        'tipo_imovel_id',
        'dormitorios',
        'banheiros',
        'garagem',
        'area_total',
        'area_construida',
        'endereco',
        'numero',
        'complemento',
        'caracteristicas',
        'destaque',
        'usuario_id',
        'bairro_id',

    ];

    // Habilitar uso de timestamps automáticos (opcional)
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validação (opcional)
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}
