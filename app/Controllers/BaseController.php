<?php

namespace App\Controllers;

// Estas são classes do CodeIgniter 4 que estamos importando
use CodeIgniter\Controller; // Classe base para todos os controllers
use CodeIgniter\HTTP\CLIRequest; // Para requisições via linha de comando
use CodeIgniter\HTTP\IncomingRequest; // Para requisições HTTP normais (GET, POST, etc)
use CodeIgniter\HTTP\RequestInterface; // Interface para requisições
use CodeIgniter\HTTP\ResponseInterface; // Interface para respostas
use Psr\Log\LoggerInterface; // Interface para logging (padrão PSR-3)

/**
 * BaseController - Controlador Base
 * 
 * Esta classe é a base para todos os outros controllers da aplicação.
 * Qualquer funcionalidade comum a todos os controllers deve ser colocada aqui.
 * 
 * POR QUE USAR?
 * - Evita repetir código em vários controllers
 * - Centraliza configurações comuns
 * - Facilita manutenção
 * 
 * COMO FUNCIONA?
 * Todos os outros controllers herdam desta classe usando: 
 * class MeuController extends BaseController
 * 
 * Assim, eles automaticamente têm acesso a tudo que está aqui.
 */
abstract class BaseController extends Controller
{
    /**
     * Propriedade para armazenar o objeto Request
     * 
     * O Request contém todas as informações sobre a requisição HTTP:
     * - Dados do formulário ($_POST)
     * - Parâmetros da URL ($_GET)
     * - Cabeçalhos HTTP
     * - IP do usuário, etc.
     * 
     * @var CLIRequest|IncomingRequest
     * Pode ser uma requisição via CLI (linha de comando) ou HTTP normal
     */
    protected $request;

    /**
     * Array de helpers que serão carregados automaticamente
     * 
     * HELPERS são funções auxiliares que facilitam tarefas comuns.
     * Exemplos:
     * - 'log' = helper para registrar logs (que criamos)
     * - 'form' = helper para criar formulários
     * - 'url' = helper para criar URLs
     * - 'date' = helper para trabalhar com datas
     * 
     * Como este helper está aqui, TODOS os controllers que herdam desta classe
     * terão acesso à função registrar_log() automaticamente.
     * 
     * @var list<string>
     * Lista de strings com os nomes dos helpers
     */
    protected $helpers = ['log'];

    /**
     * Método chamado automaticamente pelo CodeIgniter quando o controller é criado
     * 
     * Este é o método de inicialização do controller.
     * É executado ANTES de qualquer método público (index, store, etc).
     * 
     * @param RequestInterface $request Objeto com dados da requisição
     * @param ResponseInterface $response Objeto para criar a resposta
     * @param LoggerInterface $logger Objeto para registrar logs
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // NÃO EDITE ESTA LINHA!
        // Chama o método initController da classe pai (Controller)
        // Isso garante que todas as inicializações básicas do CodeIgniter sejam feitas
        parent::initController($request, $response, $logger);

        // AQUI você pode adicionar código que será executado em TODOS os controllers
        // Exemplo: inicializar sessão, carregar modelos comuns, etc.
        
        // Exemplo comentado: carregar a sessão
        // $this->session = service('session');
        // 
        // service() é uma função do CodeIgniter que retorna uma instância de um serviço
        // Exemplos: service('session'), service('validation'), service('database'), etc.
    }
}
