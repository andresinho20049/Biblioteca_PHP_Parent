$(document).ready(function(){
  sessionStorage.removeItem("jwt");
  
  $('#authForm').on('submit', function (e) {

    var password = document.getElementById('password').value
    var encrypt = btoa(password);
    //console.log(encrypt);

    var dadosForm = {
      user: document.getElementById('user').value,
      password: encrypt
    };
    var body = JSON.stringify(dadosForm);
    var request_url = "http://localhost:90/auth";
    
    jQuery.support.cors = true;
    $.ajax({
        type: 'POST',
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        crossDomain: true,
        url: request_url,
        contentType: false,
        data: body,
        timeout: 5000
    }).done(function(data){
      verify(data["jwt"]);

    }).fail(function(){
      $('#error-area').text('Authentication failed').addClass("alert alert-danger").show();
    });

    e.preventDefault();
    e.stopPropagation();

  });
});

function verify(jwt) {
  console.log("Verificando login")
  if (jwt === null) {
    debug.warn('Usuario nao autenticado');
  }else{
    console.log("Autenticando token")
    $.ajax({
      type: 'GET',
      crossDomain: true,
      headers: {
        "Authorization": "Bearer " + jwt,        
        "Access-Control-Allow-Origin": "*"
      },
      url: "http://localhost:90/verify",
      contentType: false,
      timeout: 5000
    }).done(function(data){
      console.log("Verificando o nivel de acesso")
      switch (data['nivel']){
        case "2":
          console.log("Usuario Administrador")
          break;
        default:
          console.log("Usuario comum")
      }
      
      sessionStorage.setItem("jwt", jwt);
      window.location.replace("/");


    }).fail(function(e){
      $('#error-area').text('Authentication failed').addClass("alert alert-danger").show();
      console.log(e)
    });
  }
}