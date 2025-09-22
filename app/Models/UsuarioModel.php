<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nome', 'email', 'senha','tipo'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // // Validation
     protected $validationRules      = [  
        'nome'  => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|is_unique[usuarios.email,id,{id}]',
        'senha' => 'required|min_length[6]',
        'tipo'  => 'required|in_list[admin,corretor]'
    ];
     protected $validationMessages   = [  
        'nome' => [
            'required'    => 'O nome é obrigatório',
            'min_length'  => 'O nome deve ter pelo menos 3 caracteres',
            'max_length'  => 'O nome não pode ter mais de 100 caracteres'
        ],
        'email' => [
            'required'    => 'O email é obrigatório',
            'valid_email' => 'Digite um email válido',
            'is_unique'   => 'Este email já está cadastrado'
        ],
        'senha' => [
            'required'    => 'A senha é obrigatória',
            'min_length'  => 'A senha deve ter pelo menos 6 caracteres'
        ],
        'tipo' => [
            'required' => 'O tipo de usuário é obrigatório',
            'in_list'  => 'Tipo deve ser admin ou corretor'
        ]
    ];
     protected $skipValidation       = false;
     protected $cleanValidationRules = true;

    // // Callbacks
    // protected $allowCallbacks = true;
   protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
public function hashPassword(array $data)   
    {
        if (isset($data['data']['senha'])) {
            $data['data']['senha'] = password_hash($data['data']['senha'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    // verificar a senha ao logar
    public function verificarSenha(string $senha, string $hash): bool
    {
        return password_verify($senha, $hash);
    }

     public function buscarPorEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }



}