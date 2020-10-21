function loadpage(action){
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
            $(document.body).css('visibility', '');
            checkAction(action, data["nivel"]);
        }).fail(function() {
            alert("Token expirado, favor realizar novo login")
            window.location.replace("/auth/login.html");
        });
    }
  }

  function checkAction(action, nivel) {
    switch (action) {
        case "auth":
            if(nivel != "2"){
                window.location.replace("/");
            }else{
                console.log("Acesso autorizado")
                $("#topbar").load("./topbar.html");
                $("#footer").load("/rodape.html");
            }
            break;
        case "config":
            if (nivel === "2") {

                //**************Criando novo item de Menu para adicionar ao Navbar*************
                var menuItem = document.createTextNode("Config");

                var link = document.createElement("A");
                link.className = 'nav-link';
                link.setAttribute("href", "/pages/config/home.html");
                link.appendChild(menuItem);

                var navitem = document.createElement("li");
                navitem.className = 'nav-item';
                navitem.appendChild(link);

                document.getElementById("navbar1").appendChild(navitem);
            }
            break;
        default:
            break;
    }
      
  }