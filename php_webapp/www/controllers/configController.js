$(document).ready(function(){
    loadpage("auth");
    //document.addEventListener("DOMContentLoaded", populaTable);
});

function pageCadastro() {
    $("#content").load("./cadastro.html");
}

function pageAcervo() {
    $("#content").load("./acervo.html");
    
    findAllLivro();
}