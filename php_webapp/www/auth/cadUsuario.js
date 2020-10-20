$(document).ready(function(){
  
  $('#authForm').on('submit', function (e) {

    var dadosForm = {
      user: document.getElementById('user').value,
      password: document.getElementById('password').value,
      nome: document.getElementById('nome').value,
      email: document.getElementById('email').value,
      nivel: "1"
    };
    var body = JSON.stringify(dadosForm);
    var request_url = "http://localhost:90/novousers";
    
    jQuery.support.cors = true;
    $.ajax({
        type: 'POST',
        headers: {
          "Content-Type": "application/json"
        },
        crossDomain: true,
        url: request_url,
        contentType: false,
        data: body,
        timeout: 5000
    }).done(function(){
      window.location.replace("/auth/login.html");
    }).fail(function(){
      $('#error-area').text('Cadastro nao efetuado').addClass("alert alert-danger").show();
    });

    e.preventDefault();
    e.stopPropagation();

  });
});