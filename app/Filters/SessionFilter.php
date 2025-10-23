<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SessionFilter implements FilterInterface
{
    /**
     * Este método é executado ANTES do controller ser chamado.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Pega a instância da sessão
        $session = session();

        // Verifica se a chave 'usuario_logado' NÃO existe ou é falsa
        if (!$session->get('usuario_logado')) {
            // Se não estiver logado, redireciona para a página de login
            return redirect()->to(site_url('/login'))->with('erro', 'Por favor, faça o login para aceder a esta página.');
        }

        // Se estiver logado, continua normalmente
        return $request;
    }

    /**
     * Este método é executado DEPOIS do controller.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nada a fazer aqui
    }
}
