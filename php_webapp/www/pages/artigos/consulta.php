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
            <p>O Nome é imagens fakeess, "fakeess" por não ser original, porem não diz que não seje bom!</p>
            <p>Venha aprender com nossos artigos maneiras de implementar a tecnologia para facilitar ou agilizar
                sua vida, dicas de photoshop, adobe premiere, after effects, dentre outras tecnologias que 
                levaram a criação deste canal, aprendar a editar suas imagens e videos, realizando boas montagens
                muitas vezes utilizando a pespectiva ou manipulação de tempo, gosta de logica? <br>
                Então venha fazer parte do grupo de dev, leiâ mais sobre docker, git dentre outras tecnologias obrigatórias para um bom desenvolvedor.
            </p>
        </div>
        
        <?php
            if(!$_GET['md']){
                echo '<div class="list-group">';
                $types = array( 'md' );
                $path = './markdown';
                $dir = new DirectoryIterator($path);
                foreach ($dir as $fileInfo) {
                    $ext = strtolower( $fileInfo->getExtension() );
                    if( in_array( $ext, $types ) ) {
                        echo '
                        <a href="artigos/consulta/'.basename($fileInfo->getFilename(), ".md").'" class="list-group-item list-group-item-action">'
                            .basename($fileInfo->getFilename(), ".md").
                        '</a>';
                    }
                }
                echo '</div>';
            }else{
                $file = $_GET['md'];
                if(!file_exists('../markdown/'.$file.'.md')){
                    echo '<script>
                            window.location.href = "404.php";
                        </script>';
                }
                $markdown = file_get_contents('../markdown/'.$file.'.md');

                $converter = new CommonMarkConverter();
                $cMarkdown = $converter->convertToHtml($markdown);
                $html = preg_replace('/\[([^\]]+)\]\(([^\)]+)\)/', '<a href="\2">\1</a>', $cMarkdown);
                echo $html;
            }
        ?>
    </div>
</body>

</html>