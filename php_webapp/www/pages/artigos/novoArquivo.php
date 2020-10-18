<?php
    require_once 'vendor/autoload.php';
    use League\CommonMark\CommonMarkConverter;
?>
<!DOCTYPE html>
    <div class="container">
        <div class="jumbotron" style="text-align:center">
            <h1>Artigos</h1>
            <p>O Nome é imagens fakeess, "fakeess" por não ser original, porem não diz que não seje bom!</p>
            <p>Faça parte da comunidade, dê dicas, implemente novas ideias, escrevendo um artigo, muito simples
                e facil utilizando a sintaxe markdown.
            </p>
        </div>
        <div class="containe">
            <div class="flex">Importe um markdown: </div>
            <div class="flex">
                <form action="novoArquivo.php" method="POST" enctype="multipart/form-data">
                    <div class="custom-file">
                        <input type="file" accept=".md" class="custom-file-input" name="fileUpload">
                        <label class="custom-file-label" for="customFile">Selecionar Arquivo</label>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-dark">Enviar</button>
                    </div>
                </form>
                <script src="./js/personalize.js"></script>
            </div>
        </div>
    </div>
</body>

</html>

<?php
$target_dir = "markdown/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}
?>