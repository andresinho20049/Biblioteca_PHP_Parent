$(document).ready(function(){
    loadpage("auth");
    document.addEventListener("DOMContentLoaded", populaTable);
});

function carregacadastro(data) {
    $("#content").load("./cadastro.html");
}

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

        id.innerHTML = element.id
        nome.innerHTML = element.nome
        valor.innerHTML = element.valor
        isqn.innerHTML = element.isqn
        quant.innerHTML = element.quant
        genero.innerHTML = element.genero
        editora.innerHTML = element.editora
        autor.innerHTML = element.author

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
        tr.appendChild(actions);

        document.getElementById("tbodyLivro").appendChild(tr);
        index += 1;
    });
}