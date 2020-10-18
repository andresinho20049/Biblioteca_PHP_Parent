<?php

// timezone
date_default_timezone_set('America/Sao_Paulo');

require_once 'vendor/autoload.php';

?>
<!DOCTYPE html>
 
 <html lang="pt-br">
 
 <head>
     <link rel="stylesheet" href="./css/bootstrap.min.css">
     <link rel="stylesheet" href="./css/bootstrap-grid.min.css">
     <link rel="stylesheet" href="./css/bootstrap-reboot.min.css">
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Imagens Fakeess</title>
 </head>
 <body>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/slick.min.js"></script>
    <script src="./js/slim.min.js"></script>
    <script src="./js/jquery.js"></script>
    <script src="./js/personalize.js"></script>
    <script src="./js/slick.min.js"></script>
 </body>

<?php
    
    //Carregar Pagina
    include_once "cabecalho.php";

    $pagina = isset($_GET['page'])?$_GET['page']:'home';
    $incluir = "pages/".$paginas[$pagina];
    if (isset($_GET['subpage'])) {
        $subPagina = $_GET['subpage'];
        $incluir = "pages/".$pagina."/".$paginas[$pagina][$subPagina];
    }
    echo $incluir;

    include $incluir;
    
    include "rodape.html";
?>