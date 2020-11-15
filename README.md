# Livraria Digital (Imagens Fakeess)

## Projeto academico
### "Desenvolvimento De Software Para Web"
**Topicos**
- Desenvolver aplicação utilizando PHP
- Seguir os critétios de avaliação:
1. Versão escrita 
    - Presença de informações solicitadas pelo professor; 
    - Correção gramatical; 
    - Adequação às normas da ABNT (capa, folha de rosto, sumário, introdução, desenvolvimento, conclusão, referências e anexos); 
2. Apresentação gravada 
    - Estrutura linear, coerente e organizada; 
    - Participação significativa de todos integrantes da equipe; 
    - Fala espontânea, com clareza e tom de voz adequados; 
    - Uso adequado do tempo disponível (10 min. para cada equipe).
	- [Apresentação - Livraria Digital(Dev Web)](https://www.youtube.com/watch?v=ce--H0d-b6M)

## Pré-requisito:
Para executar essa aplicação é nescessário que você tenha o *docker* instalado na sua maquina.
[Link para download](https://docs.docker.com/get-docker/)

> **Obs:**  
 É recomendavel utilizar o docker, pela facilidade de implantação, execução e desenvolvimento, porem caso queira jogar o repositório dentro da sua pasta htdocs se você utilizar o xampp ou algo do tipo, fique a disposição, mas o projeto foi desenvolvido utilizando docker.


## Como executar:
1. Baixe o projeto, executando um git clone:
```git
git clone https://github.com/andresinho20049/Biblioteca_PHP_Parent.git
```

2. com o projeto em sua maquina, entre no diretório raiz do projeto e execute:
```powershell
docker-compose up -d
```

> **Obs:**   
Ná primeira execução pode demorar um pouco, pois estara baixando as dependencias.

3. No navegador acesse [localhost](http://localhost/)


*PRONTO!*


Docker é *PERFEITO!*  
Executando apenas um comando `docker-compose up -d` e a aplicação estara pronta para ser executado.

## Estrutura do Projeto
### Linguagens:
- (Back-end) PHP
 - (Front-end) PHP, HTML, CSS E JS
### Frameworks:
- (Back-end) Silex E Jwtwrapper
- (Front-end) Jquery E Bootstrap 
### Banco de dados:
- MySql 5.6

## Segurança
- Sessão JWT
- Recursos liberados somente após login
    ```HTML
    <body style="visibility:hidden">
    ```
    ```Javascript
    //Após Login efetuado com sucesso
    $(document.body).css('visibility', '');
    ```
- Controle de acesso atraves de middleware before 
- Requisições com Header obrigatório (Authorization: Bearer \<JWT>)
- Controle de acesso por niveis de usuario
    ```PHP
    try {
        $app['jwt'] = JWTWrapper::decode($jwt);
        if ($route != 'GET_verify' && $route != 'GET_livro') {
            if($app['jwt']->data->nivel != "2"){
                return new Response('Usuario nao tem permissao', 403);
            }
        }
    } catch(Exception $ex) {
        // nao foi possivel decodificar o token jwt
        return new Response('Acesso nao autorizado', 403);
    }
    ```
- Somente Server tem acesso a infla de database
- Restrições de requisição
    ```PHP
    header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
    header("Content-Type: application/json; charset=utf-8");
    ```

## RECURSOS
- **Pagina de compras totalmente dinâmica**
    - Alterações efetuadas nos livros surgem efeitos após o primeiro acesso
    - Formulários de preenchimento com marks e requerimento de preenchimento
    - Numero de itens por pagina, pode ser ajustado pelo usuário
- **Facil publicação de novos artigos**
    - Conversor de Markdown em HTML 
    - Arquivos .md inseridos no diretório apontado são carregados automaticamente na pagina
    ```PHP
        echo '<div class="list-group">';
        $types = array( 'md' );
        $path = './pages/artigos/markdown';
        $dir = new DirectoryIterator($path);
        foreach ($dir as $fileInfo) {
            $ext = strtolower( $fileInfo->getExtension() );
            if( in_array( $ext, $types ) ) {
                echo '
                <a href="?page=artigos&subpage=consulta&md='.basename($fileInfo->getFilename(), ".md").'" class="list-group-item list-group-item-action">'
                    .basename($fileInfo->getFilename(), ".md").
                '</a>';
            }
        }
        echo '</div>';
    ```
    - Markdown é carregado dentro de DIV, não alterando a estrutura da pagina
    ```PHP
        $markdown = file_get_contents('./pages/artigos/markdown/'.$file.'.md');

        $converter = new CommonMarkConverter();
        $cMarkdown = $converter->convertToHtml($markdown);
        $html = preg_replace('/\[([^\]]+)\]\(([^\)]+)\)/', '<a href="\2">\1</a>', $cMarkdown);
        echo '<div class="container">';
        echo $html;
        echo '</div>';
    ```
- **Cabeçalho dinâmico**
    - Links do cabeçalho carregados apartir de lista  
    (Facil inclusão, alteração e remoção de paginas)
    ```PHP
    #Inserido dentro de foreach
    echo '
    <li class="nav-item">
        <a class="nav-link" href="?page='.$key.'">
            '.ucfirst($key).'
        </a>
    </li>
    ';
    ```
> **PROJETO ACADÊMICO**:  
Aluno: *André Carlos*  
Curso: Ciências da Computação.  
Disciplina: Desenvolvimento De Software Para Web - 5º Semestre.  
Apresentação: [Livraria Digital(Dev Web)](https://www.youtube.com/watch?v=ce--H0d-b6M)