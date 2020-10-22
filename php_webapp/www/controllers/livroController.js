$(document).ready(function(){
    $('#cadLivro').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        createLivro();
    });
});

function createLivro(){
    console.log("Criando novo registro")
    var dadosForm = {
        nome: document.getElementById('nome').value,
        valor: document.getElementById('valor').value,
        quant: document.getElementById('quant').value,
        isqn: document.getElementById('isqn').value,
        genero: document.getElementById('genero').value,
        editora: document.getElementById('editora').value,
        author: document.getElementById('author').value
    };
    var body = JSON.stringify(dadosForm);
    var request_url = "http://localhost:90/livro";
    var jwt = sessionStorage.getItem("jwt");
    
    jQuery.support.cors = true;
    $.ajax({
        type: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + jwt
        },
        crossDomain: true,
        url: request_url,
        contentType: false,
        data: body,
        timeout: 5000
    }).done(function(){
        $('#msg').text('Cadastrado com sucesso').addClass("alert alert-success").show();
        setTimeout(function(){ location.reload(); }, 3000);
    }).fail(function(e){
        $('#msg').text('Falha no cadastro').addClass("alert alert-danger").show();
        console.log(e)
    });
}

function findAllLivro() {
    $("#content").load("./acervo.html");
    
    $.ajax({
        type: 'GET',
        crossDomain: true,
        headers: {
            "Authorization": "Bearer " + jwt,        
            "Access-Control-Allow-Origin": "*"
        },
        url: "http://localhost:90/livro",
        contentType: false,
        timeout: 5000
    }).done(function(data){
        carregaacervo(data);
    }).fail(function(e) {
        $('#msg').text('Nao foi possivel carregar a pagina').addClass("alert alert-danger").show();
        console.log(e)
    });
}

function deletaLivro(params) {
    alert("Function Delete");
}

function editeLivro(id) {
    alert("Function Edit id: " + id );
    

    document.getElementById(id).innerHTML = "Oshi";

    $(this).parents("tr").find("td:not(:last-child)").each(function(){
        $(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
    });		
    
}
