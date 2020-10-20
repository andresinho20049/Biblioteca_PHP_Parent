function load(action){
    console.log("Verificando login")
    jwt = sessionStorage.getItem("jwt");
    if (jwt === null) {
        console.log('Usuario nao autenticado');
        window.location.replace("/auth/login.html");
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
            checkAction(action, data["nivel"]);
        }).fail(function() {
            window.location.replace("/auth/login.html");
        });
    }
  }

  function checkAction(action, nivel) {
    switch (action) {
        case "home":
            if(nivel != "2"){
                window.location.replace("/");
            }
            console.log("Acesso autorizado")
            break;
        case "config":
            if (nivel === "2") {
                
            }
            break;
        default:
            break;
    }
      
  }