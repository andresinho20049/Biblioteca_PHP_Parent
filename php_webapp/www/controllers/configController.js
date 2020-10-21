$(document).ready(function(){
    loadpage("auth");
});

function carregacadastro(data) {
    $("#content").load("./cadastro.html");
}

function carregaacervo() {
    $("#content").load("./acervo.html");
    var json = findAllLivro();
    var myArray = JSON.parse(json);
    populaTable(myArray);

}

function populaTable(result) {
    var dataSet = [];
    $.each(result, function(index, data){
       dataSet.push([
              data.id,
              data.nome,
              data.valor,
              data.isqn, 
              data.quant,
              data.genero,
              data.editora,
              data.author
       ]);
    });
    var table = $("#acervo").DataTable({
          data: dataSet,
          columns: [
                 { title: 'ID' },
                 { title: 'Nome' },
                 { title: 'Valor' },
                 { title: 'ISQN' },
                 { title: 'Quantidade' },
                 { title: 'Genero' },
                 { title: 'Editora' },
                 { title: 'Author' }
          ]
    });
}