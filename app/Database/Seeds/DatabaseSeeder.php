<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Runs all seeders in the correct order
     */
    public function run()
    {
        $this->call('UsuarioSeeder');
        $this->call('TipoImovelSeeder');
        $this->call('BairroSeeder');
        $this->call('CorretorSeeder');
        $this->call('ImovelSeeder');
        
        echo "\nTodos os seeders foram executados com sucesso!\n";
    }
}

