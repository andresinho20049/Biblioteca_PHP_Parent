<?php
    require_once 'vendor/autoload.php';
    use League\CommonMark\CommonMarkConverter;
?>
<!DOCTYPE html>
<html lang="pt-br">

<body>
    <div class="container">
        <div class="jumbotron" style="text-align:center">
            <h1>Artigos</h1>
            <p>Imagens Fakeess Livraria digital integrando cada vez mais o leitor!</p>
            <p>Leia, escreva e estude, aqui você tem a comodidade de escrever otimos artigos, com o design 
                HTML, mas como a praticidade de escrever no Word, escrevendo otimos artigos com markdown <br>
                Então venha fazer parte do grupo, leiâ o doc <a href="https://www.markdownguide.org/cheat-sheet/" target="_blank">"Folha de referências do Markdown"</a> e junte ao time!
            </p>
        </div>
        <div class="row">
        <div class="col-8" id="guiaMd">
        <div class="text-justify">
        <h3>O que é Markdown?</h3>
        <p>Markdown é uma forma de estilizar texto na web. Você controla a exibição do documento; formatar palavras como negrito ou itálico, adicionar imagens e criar listas são apenas algumas das coisas que podemos fazer com o Markdown. Em geral, Markdown é apenas um texto normal com alguns caracteres não alfabéticos inseridos, como #ou *.</p>

        <p>Você pode usar o Markdown na maioria dos lugares no GitHub:</p>

        <h6>Gists</h6>
        <p>Comentários em problemas e solicitações pull
        Arquivos com a extensão .md ou .markdown
        Para obter mais informações, consulte “ Escrevendo no GitHub ” na Ajuda do GitHub.</p>
        <h4>Guia de sintaxe</h4>
        <h6>Esta é uma visão geral da sintaxe do Markdown que você pode usar em qualquer lugar no GitHub.com ou em seus próprios arquivos de texto.</h6>

        <h6>Cabeçalhos</h6>
        <p># Um hashtag é equivalente ao < h1 > </p>
        <p>## Dois hashtag é equivalente ao < h2 > </p>
        <p>###### Seis hashtag é equivalente ao < h6 > </p>

        <h6>Ênfase</h6>
        *Este texto em italico*<br>
        _Este texto em italico_<br><br>

        **Este texto em negrito**<br>
        __Este texto em negrito__<br>

        <h6>Você pode combinar listas:</h6>
        <p>Não ordenado<br>
        * Item 1<br>
        * Item 2<br>
        * Item 2a<br>
        * Item 2b</p>
        <p>Ordenado<br>
        1. Item 1<br>
        1. Item 2<br>
        1. Item 3<br>
        1. Item 3a<br>
        1. Item 3b</p>

        <h6>Imagens</h6>
        ![Imagens fakeess Logo](/img/Logo.png)<br>
        Format: ![Alt Text](url)<br>

        <h6>Links:</h6>
        https://github.com/andresinho20049/ - automatic!<br>
        [GitHub](https://github.com/andresinho20049/)<br>

        <h6>Citações em bloco</h6>

        > Use (>) para fazer citações<br>
        </p >
        <h6>Realce de sintaxe</h6>
        Aqui está um exemplo de como você pode usar o realce de sintaxe com GitHub Flavored Markdown :<br>
        <blockquote class="blockquote">
        <pre><code>
            ```javascript<br>
                function minhaFuncao(arg) {<br>
                if(arg) {<br>
                    $.facebox({div:'#foo'})<br>
                }<br>
                }<br>
            ```
        </code></pre>
        </blockquote>
        </div></div>

        <?php
            if(!$_GET['md']){
                echo '<div class="col-4">';
                echo '<div class="alert alert-primary">
                        <strong>Click</strong> em uma das opções na lista abaixo
                      </div>';
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
                echo '</div></div></div>';
            }else{
                $file = $_GET['md'];
                if(!file_exists('./pages/artigos/markdown/'.$file.'.md')){
                    echo '<script>
                            window.location.href = "404.php";
                        </script>';
                }
                $markdown = file_get_contents('./pages/artigos/markdown/'.$file.'.md');

                $converter = new CommonMarkConverter();
                $cMarkdown = $converter->convertToHtml($markdown);
                $html = preg_replace('/\[([^\]]+)\]\(([^\)]+)\)/', '<a href="\2">\1</a>', $cMarkdown);
                echo '<div class="container">';
                echo $html;
                echo '</div>';
                echo '<script>
                        var md = document.getElementById("guiaMd");
                        $(md).remove();
                    </script>';
            }
        ?>
        
    </div>
</body>

</html>