function createLivro(){
    var dadosForm = {
        user: document.getElementById('user').value,
        password: document.getElementById('password').value
    };
    var body = JSON.stringify(dadosForm);
    var request_url = "http://localhost:90/auth";
    
    
    jQuery.support.cors = true;
    $.ajax({
        type: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Access-Control-Allow-Origin": request_url
        },
        crossDomain: true,
        url: request_url,
        contentType: false,
        data: body,
        timeout: 5000
    }).done(function(data){
        sessionStorage.setItem("jwt", "data.jwt");
        console.log("Acho que foi" + data) 
    }).fail(function(e){
        $('#error-area').text('Authentication failed').addClass("alert alert-danger").show();
        console.log(e)
    });
}

function findAllLivro() {
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
        return data;
    }).fail(function() {
        window.location.replace("/auth/login.html");
    });
}
