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
    }).fail(function(){
        $('#msg').text('Falha no cadastro').addClass("alert alert-danger").show();
    });
}

function atualizaLivro(){
    console.log("Atualizando registro: " + id)
    var dadosForm = {
        id: id,
        nome: document.getElementById('nome' + id).value,
        valor: document.getElementById('valor' + id).value,
        quant: document.getElementById('quant' + id).value,
        isqn: document.getElementById('isqn' + id).value,
        genero: document.getElementById('genero' + id).value,
        editora: document.getElementById('editora' + id).value,
        author: document.getElementById('author' + id).value
    };
    var body = JSON.stringify(dadosForm);
    var request_url = "http://localhost:90/livro";
    var jwt = sessionStorage.getItem("jwt");
    
    jQuery.support.cors = true;
    $.ajax({
        type: 'PUT',
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + jwt
        },
        crossDomain: true,
        url: request_url,
        contentType: false,
        data: body,
        timeout: 5000
    }).done(function(e){
        console.log(e);
        setTimeout(function(){ location.reload(); }, 3000);
    }).fail(function(){
        alert("Falha");
    });
}

function deleteLivro(){
    console.log("Deletando registro: " + id)
    var dadosForm = {
        id: id
    };
    var body = JSON.stringify(dadosForm);
    var request_url = "http://localhost:90/livro";
    var jwt = sessionStorage.getItem("jwt");
    
    jQuery.support.cors = true;
    $.ajax({
        type: 'DELETE',
        headers: {
            "Content-Type": "application/json",
            "Authorization": "Bearer " + jwt
        },
        crossDomain: true,
        url: request_url,
        contentType: false,
        data: body,
        timeout: 5000
    }).done(function(e){
        console.log(e);
        setTimeout(function(){ location.reload(); }, 3000);
    }).fail(function(){
        alert("Falha");
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
    }).fail(function() {
        $('#msg').text('Nao foi possivel carregar a pagina').addClass("alert alert-danger").show();
    });
}