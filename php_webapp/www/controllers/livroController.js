$(document).ready(function(){
    $('#cadLivro').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        createLivro();
    });
});

function deletaLivro(ctl) {

    _row = $(ctl).parents("tr");
    var rowid = _row.children("th");
    id = $(rowid[0]).text();
    var cols = _row.children("td");
    nome = $(cols[0]).text();


    if (confirm('Deseja realmente deletar ' + id + ' - ' + nome + '?')) {
        deleteLivro();
    }
}

function editeLivro(ctl) {
    _row = $(ctl).parents("tr");
    var rowid = _row.children("th");
    id = $(rowid[0]).text();
    var cols = _row.children("td");

    if (ctl.title === "atualiza") {
        atualizaLivro();
    } else {
        nome = $(cols[0]).text();
        valor = $(cols[1]).text();
        isqn = $(cols[2]).text();
        quant = $(cols[3]).text();
        genero = $(cols[4]).text();
        editora = $(cols[5]).text();
        author = $(cols[6]).text();

        $(cols[0]).html('<input id="nome' + id + '" type="text" class="form-control" value="' + nome + '">');
        $(cols[1]).html('<input id="valor' + id + '" type="text" class="form-control" value="' + valor + '">');
        $(cols[2]).html('<input id="isqn' + id + '" type="text" class="form-control" value="' + isqn + '">');
        $(cols[3]).html('<input id="quant' + id + '" type="text" class="form-control" value="' + quant + '">');
        $(cols[4]).html('<input id="genero' + id + '"type="text" class="form-control" value="' + genero + '">');
        $(cols[5]).html('<input id="editora' + id + '" type="text" class="form-control" value="' + editora + '">');
        $(cols[6]).html('<input id="author' + id + '" type="text" class="form-control" value="' + author + '">');
        document.getElementById(ctl.id).setAttribute("title", "atualiza");

        var index = 0;
        $('#tbodyLivro tr').each(function(){
            var col = document.getElementById("ed" + index) 
            if (col.title === "Edit") {
                col.setAttribute("onclick", "");
                col.removeAttribute("href");
            }
            index +=1;
        });
    }
    
}
