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
            <p>B²RAFS Livraria digital integrando cada vez mais o leitor!</p>
            <p>Leia, escreva e estude, aqui você tem a comodidade de escrever otimos artigos, com o design 
                HTML, mas como a praticidade de escrever no Word, escrevendo otimos artigos com markdown <br>
                Então venha fazer parte do grupo, leiâ o artigo "como escrever em markdown" e junte ao time!
            </p>
        </div>
        <script>


        </script>

        <div class="float-right" id="bottom_up">
            <a href="#top">
            <div class="fixed-bottom">
                <button class="btn btn-success btn-lg float-right" style="margin:50px 63px">up</button>
            </div>
            </a>
        </div>

        <?php
            if(!$_GET['md']){
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
                echo $html;
            }
        ?>
        
    </div>
</body>

</html>