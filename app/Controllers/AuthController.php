<?php

namespace App\Controllers;

// Importa o BaseController para herdar funcionalidades comuns
use App\Controllers\BaseController;
// Importa o modelo de usuário para trabalhar com o banco de dados
use App\Models\UsuarioModel;
// Importa a interface ResponseInterface para tipagem de retorno
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AuthController - Controlador de Autenticação
 * 
 * Responsável por gerenciar:
 * - Login de usuários
 * - Logout de usuários
 * - Validação de credenciais
 * 
 * FLUXO DE LOGIN:
 * 1. Usuário preenche formulário de login
 * 2. processarLogin() valida email e senha
 * 3. Se válido, cria sessão com dados do usuário
 * 4. Registra log da ação
 * 5. Redireciona para dashboard
 */
class AuthController extends BaseController
{
    /**
     * Propriedade para armazenar o modelo de usuário
     * 
     * MODELO = Camada que comunica com o banco de dados
     * Permite fazer SELECT, INSERT, UPDATE, DELETE na tabela 'usuarios'
     * 
     * @var UsuarioModel
     */
    protected $usuarioModel;

    /**
     * Propriedade para armazenar a sessão
     * 
     * SESSÃO = Dados temporários que ficam guardados enquanto o usuário navega
     * Exemplo: usuário logado, carrinho de compras, preferências
     * 
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    /**
     * Método construtor - executado automaticamente quando o controller é criado
     * 
     * DE ONDE VEM?
     * - new UsuarioModel() = Cria uma nova instância do modelo
     * - session() = Função helper do CodeIgniter que retorna o objeto de sessão
     * 
     * O QUE FAZ?
     * Inicializa as propriedades que serão usadas em todos os métodos deste controller
     */
    public function __construct()
    {
        // Cria uma instância do modelo para acessar o banco de dados
        $this->usuarioModel = new UsuarioModel();
        
        // session() é uma função helper do CodeIgniter
        // Retorna um objeto que permite:
        // - set('chave', 'valor') = guardar dados
        // - get('chave') = recuperar dados
        // - destroy() = limpar sessão
        $this->session = session();
    }

    /**
     * Exibe a página de login
     * 
     * @return string|ResponseInterface
     * Retorna a view de login OU um redirecionamento
     * 
     * DE ONDE VEM?
     * - view() = Função helper do CodeIgniter que carrega uma view (arquivo PHP)
     * - redirect() = Função helper do CodeIgniter que cria um redirecionamento HTTP
     * - $this->session->get() = Método do objeto Session para recuperar dados
     */
    public function mostrarTelaLogin()
    {
        // Verifica se o usuário já está logado
        // Se 'usuario_logado' existe na sessão, significa que já fez login
        if ($this->session->get('usuario_logado')) {
            // Se já está logado, redireciona para a página inicial
            // redirect() cria um objeto de redirecionamento
            // to() define para onde redirecionar
            return redirect()->to('paginainicial');
        }

        // Se não está logado, mostra a página de login
        // view() procura o arquivo em app/Views/auth/login.php
        // e retorna o HTML renderizado
        return view('auth/login');
    }

    /**
     * Processa o formulário de login
     * 
     * FLUXO:
     * 1. Pega email e senha do formulário
     * 2. Busca usuário no banco pelo email
     * 3. Verifica se a senha está correta
     * 4. Se correto, cria sessão e redireciona
     * 5. Se incorreto, retorna para login com erro
     * 
     * @return ResponseInterface
     * Sempre retorna um redirecionamento
     * 
     * DE ONDE VEM?
     * - $this->request = Propriedade herdada do BaseController
     *   Contém todos os dados da requisição HTTP
     * - getPost() = Método para pegar dados enviados via POST (formulários)
     * - where()->first() = Query Builder do CodeIgniter (busca no banco)
     * - password_verify() = Função nativa do PHP para verificar senha hash
     */
    public function processarLogin()
    {
        // Pega os dados do formulário enviado via POST
        // getPost('campo') retorna o valor do campo do formulário
        $emailFormulario = $this->request->getPost('email');
        $senhaFormulario = $this->request->getPost('senha');

        // Busca o usuário no banco de dados pelo email
        // where('email', $emailFormulario) = WHERE email = 'valor'
        // first() = Retorna o primeiro resultado ou null se não encontrar
        $usuario = $this->usuarioModel->where('email', $emailFormulario)->first();

        // Verifica se encontrou um usuário
        if ($usuario) {
            // Verifica se a senha digitada confere com a senha no banco
            // verificarSenha() é um método customizado do UsuarioModel
            // Ele usa password_verify() do PHP para comparar a senha com o hash
            $senhaValida = $this->usuarioModel->verificarSenha($senhaFormulario, $usuario['senha']);

            // Se a senha está correta
            if ($senhaValida) {
                // Prepara os dados para guardar na sessão
                // A sessão permite manter dados do usuário enquanto navega
                $dadosSessao = [
                    'usuario_logado' => true,        // Flag indicando que está logado
                    'usuario_id'     => $usuario['id'], // ID para identificar o usuário
                    'nome'           => $usuario['nome'], // Nome para exibir
                    'email'          => $usuario['email'], // Email do usuário
                    'tipo'           => $usuario['tipo']   // Tipo: 'admin' ou 'corretor'
                ];

                // Guarda os dados na sessão
                // set() aceita um array e guarda todos os valores
                $this->session->set($dadosSessao);

                // Pega o ID do usuário logado para o log
                $adminID = $this->session->get('usuario_id');

                // Registra no log que o usuário fez login
                // registrar_log() vem do helper 'log' que carregamos no BaseController
                registrar_log(
                    $adminID,                                    // Quem fez (ID do usuário)
                    'Usuario Logou ' . $usuario['id']           // O que fez (descrição)
                );

                // Redireciona para o dashboard do admin
                // ->to() define a URL de destino
                return redirect()->to('/admin/dashboard');
            } else {
                // Senha incorreta - redireciona de volta com mensagem de erro
                // ->with() adiciona dados temporários na sessão (flash data)
                // Esses dados ficam disponíveis apenas na próxima requisição
                return redirect()->to('/login')->with('erro', 'Usuário não encontrado');
            }
        }

        // Se chegou aqui, o usuário não foi encontrado
        return redirect()->to('/login');
    }

    /**
     * Faz logout do usuário
     * 
     * FLUXO:
     * 1. Pega ID do usuário logado
     * 2. Registra no log que fez logout
     * 3. Destrói a sessão (limpa todos os dados)
     * 4. Redireciona para login
     * 
     * @return ResponseInterface
     * Sempre retorna redirecionamento para login
     * 
     * DE ONDE VEM?
     * - destroy() = Método do objeto Session para limpar toda a sessão
     */
    public function logout()
    {
        // Pega o ID do usuário que está fazendo logout
        $idUsuarioLogado = $this->session->get('usuario_id');

        // Registra no log apenas se houver um ID (usuário logado)
        if ($idUsuarioLogado) {
            registrar_log($idUsuarioLogado, 'Logout efetuado.');
        }

        // Limpa toda a sessão do usuário
        // Isso remove todos os dados guardados (usuario_logado, usuario_id, etc)
        $this->session->destroy();

        // Redireciona para a página de login
        return redirect()->to('/login');
    }

    /**
     * Função auxiliar para gerar hash de senha
     * 
     * UTILIDADE:
     * Usado durante desenvolvimento para gerar o hash de uma senha
     * que será inserida manualmente no banco ou usado no seeder
     * 
     * DE ONDE VEM?
     * - password_hash() = Função nativa do PHP
     *   Cria um hash seguro da senha usando algoritmo bcrypt
     * - PASSWORD_DEFAULT = Usa o algoritmo mais seguro disponível
     * 
     * EXEMPLO DE USO:
     * password_hash('123456', PASSWORD_DEFAULT) retorna algo como:
     * '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
     */
    public function gerarSenha()
    {
        // var_dump() é uma função do PHP que mostra informações sobre uma variável
        // Útil para debug durante desenvolvimento
        var_dump(password_hash("123456", PASSWORD_DEFAULT));
    }
}
