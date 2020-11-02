$(document).ready(function(){
    $('#cadLivro').on('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        createLivro();
    });
});

function carregaacervo(json) {
    var index = 0;
    result = json['livro'];
    result.forEach(element => {

        var id = document.createElement("TH");
        id.setAttribute("scope", "row");
        var nome = document.createElement("TD");
        var valor = document.createElement("TD");
        var isqn = document.createElement("TD");
        var quant = document.createElement("TD");
        var genero = document.createElement("TD");
        var editora = document.createElement("TD");
        var autor = document.createElement("TD");
        var img = document.createElement("TD");

        id.innerHTML = element.id
        nome.innerHTML = element.nome
        valor.innerHTML = element.valor
        isqn.innerHTML = element.isqn
        quant.innerHTML = element.quant
        genero.innerHTML = element.genero
        editora.innerHTML = element.editora
        autor.innerHTML = element.author
        img.innerHTML = element.img

        //Buttons de Edit e Delete
        var edit = document.createElement("A");
        edit.setAttribute("id", "ed" + index);
        edit.setAttribute("href", "javascript:void(0)");
        edit.setAttribute("onclick", "editeLivro(this);");
        edit.setAttribute("title", "Edit");
        edit.setAttribute("data-toggle", "tooltip");
        edit.setAttribute("style", "padding-right: 10px;")
        var iEdit = document.createElement("I");
        iEdit.className = "far fa-edit";
        edit.appendChild(iEdit);

        var deleta = document.createElement("A");
        deleta.setAttribute("href", "javascript:void(0)");
        deleta.setAttribute("onclick", "deletaLivro(this);");
        deleta.setAttribute("title", "Delete");
        deleta.setAttribute("data-toggle", "tooltip");
        var iDeleta = document.createElement("I");
        iDeleta.className = "fas fa-trash-alt";
        deleta.appendChild(iDeleta);

        var actions = document.createElement("TD");
        actions.appendChild(edit);
        actions.appendChild(deleta);

        var tr = document.createElement("TR");
        tr.appendChild(id);
        tr.appendChild(nome);
        tr.appendChild(valor);
        tr.appendChild(isqn);
        tr.appendChild(quant);
        tr.appendChild(genero);
        tr.appendChild(editora);
        tr.appendChild(autor);
        tr.appendChild(img);
        tr.appendChild(actions);

        document.getElementById("tbodyLivro").appendChild(tr);
        index += 1;
    });
}

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
        img = $(cols[7]).text();

        $(cols[0]).html('<input id="nome' + id + '" type="text" class="form-control" value="' + nome + '">');
        $(cols[1]).html('<input id="valor' + id + '" type="number" class="form-control" value="' + valor + '">');
        $(cols[2]).html('<input id="isqn' + id + '" type="number" class="form-control" value="' + isqn + '">');
        $(cols[3]).html('<input id="quant' + id + '" type="number" class="form-control" value="' + quant + '">');
        $(cols[4]).html('<input id="genero' + id + '"type="text" class="form-control" value="' + genero + '">');
        $(cols[5]).html('<input id="editora' + id + '" type="text" class="form-control" value="' + editora + '">');
        $(cols[6]).html('<input id="author' + id + '" type="text" class="form-control" value="' + author + '">');
        $(cols[7]).html('<input id="img' + id + '" type="text" for="input-file" class="form-control" value="' + img + '">');
        
        var edit = document.getElementById(ctl.id);
        edit.setAttribute("title", "atualiza");
        var iEdit = document.createElement("I");
        iEdit.className = "far fa-check-circle";
        edit.replaceChild(iEdit, edit.firstChild);

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
