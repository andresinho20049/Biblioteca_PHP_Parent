$(document).ready(function(){
    data = findAllLivro();


    $.ajax({
        type: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        crossDomain: true,
        url: "/page/config/acervo.php",
        contentType: false,
        data: data,
        timeout: 5000
    });
});