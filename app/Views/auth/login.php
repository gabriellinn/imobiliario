<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Imobiliário</title>
    
    <!-- 
        DE ONDE VEM?
        $this->include() = Método do CodeIgniter para incluir outra view dentro desta
        'partials/header' = Caminho relativo da view a incluir
        Procura o arquivo em: app/Views/partials/header.php
        
        O QUE FAZ?
        Inclui o arquivo header.php que geralmente contém:
        - CSS global
        - Links para arquivos de estilo
        - Meta tags comuns
        - Scripts comuns
        
        Por que usar?
        Evita repetir código HTML em várias views
        Facilita manutenção (mudança em um lugar afeta todas as views)
    -->
    <?= $this->include('partials/header') ?>
</head>
<body>
    <div class="container container-sm">
        <div class="card" style="max-width: 400px; margin: var(--spacing-xl) auto;">
            <div class="page-header">
                <h1>Login</h1>
            </div>

            <!-- 
                FLASH DATA - Mensagens Temporárias
                
                DE ONDE VEM?
                session() = Função helper do CodeIgniter que retorna o objeto de sessão
                getFlashdata() = Método que retorna dados temporários da sessão
                
                O QUE FAZ?
                Flash data são dados que ficam disponíveis apenas na próxima requisição HTTP
                e depois são automaticamente removidos.
                
                COMO FUNCIONA?
                1. Controller usa: redirect()->with('erro', 'Mensagem')
                2. A mensagem é guardada na sessão como flash data
                3. Na próxima página, pode ser recuperada com: session()->getFlashdata('erro')
                4. Após ser exibida, é automaticamente removida da sessão
                
                POR QUE USAR?
                - Ideal para mensagens de sucesso/erro após redirecionamentos
                - Não precisa passar como parâmetro na URL
                - Não persiste entre várias páginas (segurança)
            -->
            <?php if (session()->getFlashdata('erro')): ?>
                <!-- 
                    esc() = Função helper do CodeIgniter para escapamento de dados
                    
                    O QUE FAZ?
                    Converte caracteres especiais em entidades HTML para prevenir XSS
                    Exemplo: <script> vira &lt;script&gt;
                    
                    POR QUE USAR?
                    Segurança! Previne ataques Cross-Site Scripting (XSS)
                    Sempre use esc() ao exibir dados que vêm do banco ou do usuário
                    
                    ATENÇÃO:
                    getFlashdata() retorna null se não existir, por isso verificamos com if antes
                -->
                <div class="alert alert-error"><?= esc(session()->getFlashdata('erro')) ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('sucesso')): ?>
                <div class="alert alert-success"><?= esc(session()->getFlashdata('sucesso')) ?></div>
            <?php endif; ?>

            <!-- 
                FORMULÁRIO DE LOGIN
                
                action = Define para onde os dados do formulário serão enviados
                method = 'post' significa que os dados serão enviados via POST (não aparecem na URL)
            -->
            <form action="<?= base_url('processarLogin') ?>" method="post">
                <!-- 
                    CSRF TOKEN - Proteção contra Cross-Site Request Forgery
                    
                    DE ONDE VEM?
                    csrf_field() = Função helper do CodeIgniter que gera um campo hidden com token CSRF
                    
                    O QUE FAZ?
                    Cria um campo hidden com um token único e aleatório
                    O CodeIgniter verifica este token quando o formulário é enviado
                    
                    POR QUE É IMPORTANTE?
                    Protege contra ataques CSRF onde um site malicioso envia requisições
                    em nome do usuário sem seu conhecimento
                    
                    COMO FUNCIONA?
                    1. Gera um token único ao carregar a página
                    2. Token é guardado na sessão do usuário
                    3. Quando formulário é enviado, verifica se o token confere
                    4. Se não conferir, rejeita a requisição
                    
                    SEMPRE USE em formulários que modificam dados!
                -->
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="email">Email</label>
                    <!-- 
                        old() = Função helper do CodeIgniter
                        
                        O QUE FAZ?
                        Retorna o valor anterior de um campo do formulário após validação falhar
                        
                        POR QUE USAR?
                        Se o formulário for rejeitado por validação, os dados digitados
                        não são perdidos - aparecem novamente no campo
                        
                        COMO FUNCIONA?
                        Controller usa: redirect()->back()->withInput()
                        Os valores ficam disponíveis via old('nome_do_campo')
                        
                        EXEMPLO:
                        Usuário digita "teste@email.com"
                        Validação falha
                        Campo aparece novamente com "teste@email.com" preenchido
                    -->
                    <input type="email" id="email" name="email" value="<?= old('email') ?>" required>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <!-- 
                        type="password" = Campo de senha (caracteres são ocultados)
                        required = Atributo HTML5 que torna o campo obrigatório
                    -->
                    <input type="password" id="senha" name="senha" required>
                </div>

                <div class="form-group">
                    <!-- 
                        type="submit" = Botão que envia o formulário
                        Quando clicado, envia os dados via POST para a URL do action
                    -->
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Entrar</button>
                </div>
            </form>

            <!-- 
                CARD COM DADOS DE TESTE
                Útil durante desenvolvimento para facilitar testes
            -->
            <div class="card" style="margin-top: var(--spacing-md); background-color: var(--bg-secondary);">
                <h3 style="font-size: 1rem; margin-bottom: var(--spacing-sm);">Dados de Teste:</h3>
                <p style="font-size: 0.875rem; margin: var(--spacing-xs) 0;"><strong>Email:</strong> admin@sistema.com</p>
                <p style="font-size: 0.875rem; margin: var(--spacing-xs) 0;"><strong>Senha:</strong> 123456</p>
            </div>

            <div class="text-center" style="margin-top: var(--spacing-md);">
                <!-- 
                    base_url() = Função helper do CodeIgniter para criar URLs
                    
                    O QUE FAZ?
                    Cria uma URL absoluta baseada na URL base configurada do site
                    
                    COMO FUNCIONA?
                    Se a URL base for: http://localhost/imobiliario
                    base_url('/') retorna: http://localhost/imobiliario/
                    
                    DIFERENÇA ENTRE base_url() E site_url():
                    - base_url() = URL base do site (geralmente até a raiz do projeto)
                    - site_url() = URL incluindo index.php se necessário
                    
                    EXEMPLO:
                    base_url('css/style.css') = http://localhost/imobiliario/css/style.css
                    site_url('imovel/listar') = http://localhost/imobiliario/index.php/imovel/listar
                -->
                <a href="<?= base_url('/') ?>" class="btn btn-secondary">Voltar para o site</a>
            </div>
        </div>
    </div>
</body>
</html>

<!-- 
    RESUMO DOS HELPERS USADOS NESTA VIEW:
    
    1. $this->include('partials/header')
       - Inclui outra view dentro desta
       - Vem do CodeIgniter
       
    2. session()->getFlashdata('chave')
       - Recupera dados temporários da sessão
       - Vem do CodeIgniter
       
    3. esc($dados)
       - Escapa caracteres especiais para prevenir XSS
       - Vem do CodeIgniter (helper 'html')
       
    4. csrf_field()
       - Gera campo hidden com token CSRF
       - Vem do CodeIgniter (helper 'security')
       
    5. old('campo')
       - Retorna valor anterior de campo após validação falhar
       - Vem do CodeIgniter (helper 'form')
       
    6. base_url('caminho')
       - Cria URL absoluta baseada na URL base configurada
       - Vem do CodeIgniter (helper 'url')
       
    ATENÇÃO:
    - Sempre use esc() ao exibir dados do usuário ou banco
    - Sempre use csrf_field() em formulários
    - Use flash data para mensagens após redirecionamentos
    - Use old() para manter dados do formulário após validação falhar
-->
