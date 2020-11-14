$(document).ready(function(){
    getLivro();
});

function example() {
    alert("Exemplo simulativo, SEM AÇÃO, apenas para conhecimentos de front-end");
}

function getLivro() {
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
    }).done(function(json){
        result = json['livro'];
        carregaLista();
    }).fail(function(e) {
        alert("Error: " + e.error);
    });
}

var tamanhoPagina = 10;
var pagina = 0;
var result;

function carregaLista() {
    var index = 0;

    var size = document.getElementById('totalItens');
    size.innerHTML = "Total: " + result.length + " livros";

    var divLista = document.getElementById("listaCar");
    const pag = divLista.querySelector("#divPag");

    if (pag !== null) {
        $(pag).remove();
    }

    var divPag = document.createElement("DIV");
    divPag.setAttribute("id", "divPag");

    for (var i = pagina * tamanhoPagina; i < result.length && i < (pagina + 1) * tamanhoPagina; i++) {
        var e = result[i];
        
        //Imagem no canto da tela
        var imgDiv = document.createElement("DIV");
        imgDiv.className = "view zoom overlay z-depth-1 rounded mb-3 mb-md-0";
        var imgA = document.createElement("IMG");
        imgA.className = "img-fluid w-100";
        imgA.setAttribute("src","/img/livros/" + e.img);
        
        imgDiv.appendChild(imgA);

        //Info float left
        var dInfo1 = document.createElement("DIV");
        var nome = document.createElement("H5");
        nome.setAttribute("id","nome_" + index);
        nome.innerHTML = e.nome;
        var autor = document.createElement("P");
        autor.className = "mb-3 text-muted text-uppercase small";
        autor.innerHTML = "Autor: " + e.author;
        var genero = document.createElement("P");
        genero.className = "mb-3 text-muted text-uppercase small";
        genero.innerHTML = "Genero: " + e.genero;

        dInfo1.appendChild(nome);
        dInfo1.appendChild(autor);
        dInfo1.appendChild(genero);

        //input float right
        var dInfo2 = document.createElement("DIV");
        var divInput = document.createElement("DIV");
        divInput.className = "def-number-input number-input safari_only mb-0 w-100";
        var input = document.createElement("INPUT");
        input.className = "quantity";
        input.setAttribute("id", "input_" + index);
        input.setAttribute("min","0");
        input.setAttribute("name", "quantity");
        input.setAttribute("value", "1");
        input.setAttribute("type", "number");

        divInput.appendChild(input);
        dInfo2.appendChild(divInput);

        //DIV infor superior
        var divFlexInfo = document.createElement("DIV");
        divFlexInfo.className = "d-flex justify-content-between";

        divFlexInfo.appendChild(dInfo1);
        divFlexInfo.appendChild(dInfo2);

        //Link Car
        var dLink = document.createElement("DIV");
        var linkCar = document.createElement("A");
        linkCar.className = "card-link-secondary small text-uppercase";
        linkCar.setAttribute("id","link_"+index);
        linkCar.setAttribute("href","javascript:void(0)");
        linkCar.setAttribute("type","button");
        linkCar.setAttribute("onclick", "addCar(this);");
        var iCar = document.createElement("I");
        iCar.innerHTML = "Adicionar no Carrinho";
        iCar.className = "fas fa-heart mr-1";

        linkCar.appendChild(iCar);
        dLink.appendChild(linkCar);

        //Valor
        var valor = document.createElement("P");
        valor.className = "mb-0";
        var vSpan = document.createElement("SPAN");
        var vStrong = document.createElement("STRONG");
        vStrong.setAttribute("ID", "valor_" + index);
        vStrong.innerHTML = "R$ " + e.valor;
        
        vSpan.appendChild(vStrong);
        valor.appendChild(vSpan);

        //DIV Infor Inferior
        var divFlexInfo2 = document.createElement("DIV");
        divFlexInfo2.className = "d-flex justify-content-between align-items-center";
        divFlexInfo2.appendChild(dLink);
        divFlexInfo2.appendChild(valor);

        //Coluna imagem do Livro
        var divColImg = document.createElement("DIV");
        divColImg.className = "col-md-5 col-lg-3 col-xl-3";
        divColImg.appendChild(imgDiv);

        //Coluna informações do Livro
        var divColInfo = document.createElement("DIV");
        divColInfo.className = "col-md-7 col-lg-9 col-xl-9";
        
        divColInfo.appendChild(divFlexInfo);
        divColInfo.appendChild(divFlexInfo2);

        //divRow e add divList
        var row = document.createElement("DIV");
        row.className = "row mb-4";
        row.appendChild(divColImg);
        row.appendChild(divColInfo);
        
        var hr = document.createElement("HR");
        hr.className = "mb-4";

        divPag.appendChild(row);
        divPag.appendChild(hr);
        index += 1;
    }
    divLista.appendChild(divPag);
    ajustarPaginacao();
}

function ajustarPaginacao() {
    window.scrollTo({top: 310, behavior: 'smooth'});
    $('#numeracao').text('Página ' + (pagina + 1) + ' de ' + Math.ceil(result.length / tamanhoPagina));
    $('#proximo').prop('disabled', result.length <= tamanhoPagina || pagina >= Math.ceil(result.length / tamanhoPagina) - 1);
    $('#anterior').prop('disabled', result.length <= tamanhoPagina || pagina == 0);
}

$(function() {
    $('#proximo').click(function() {
        if (pagina < result.length / tamanhoPagina - 1) {
        pagina++;
        carregaLista();
        }
    });
    $('#anterior').click(function() {
        if (pagina > 0) {
        pagina--;
        carregaLista();
        }
    });
    $('#alter_tam_pagina').click(function() {
        var inputPage = document.getElementById("tam_pagina");
        tamanhoPagina = $(inputPage).val();
        if (tamanhoPagina < 5 || tamanhoPagina > 50) {
            tamanhoPagina = 10;
            inputPage.value = 10;
        }
        carregaLista();
    });
});

function addCar(livro) {
    var id = livro.id;
    id = id.split("_").pop();

    var h5Nome = document.getElementById("nome_" + id);
    var nome = $(h5Nome).text();

    var strongValor = document.getElementById("valor_" + id);
    var valor = $(strongValor).text().split(" ").pop();

    var inputQ = document.getElementById("input_" + id);
    var quant = $(inputQ).val();

    var strongQuant = document.getElementById("strongQuant");
    var quantItensCar = parseInt($(strongQuant).text());

    console.log("Quantidade itens: " + quantItensCar);

    if (quantItensCar === 0) {
        cabecalhoTable(1);
        console.log("Primeira execução");
    }
    
    addItens(nome, quant, valor);
    atualizaCar(1, quant, valor);
}

function cabecalhoTable(opt) {

    switch (opt) {
        case 1:
            var thNome = document.createElement("TH");
                thNome.innerHTML = "Nome";
            var thQuant = document.createElement("TH");
                thQuant.innerHTML = "Quant";
            var thValor = document.createElement("TH");
                thValor.innerHTML = "Valor";
            var thTotal = document.createElement("TH");
                thTotal.innerHTML = "Total";
            var thRemove = document.createElement("TH");
                thRemove.innerHTML = "RM";

            var trTable = document.getElementById("myCarTr");
                trTable.appendChild(thNome);
                trTable.appendChild(thQuant);
                trTable.appendChild(thValor);
                trTable.appendChild(thTotal);
                trTable.appendChild(thRemove);

            var table = document.getElementById("tableCar");
            $(table).css('visibility', '');
            
            break;
        
        case 2:

            var myCarTHead = document.getElementById("myCarTHead");
            myCarTHead.innerHTML = '<tr id="myCarTr"></tr>';
            $(table).css('visibility', 'hidden');

            break;
    
        default:
            break;
    }
  }

  function addItens(nome, quant, valor) {
    var tdNome = document.createElement("TD");
    var tdValor = document.createElement("TD");
    var tdQuant = document.createElement("TD");
    var tdTotal = document.createElement("TD");

    var deleta = document.createElement("A");
    deleta.setAttribute("href", "javascript:void(0)");
    deleta.setAttribute("onclick", "remove(this);");
    deleta.setAttribute("title", "Delete");
    deleta.setAttribute("data-toggle", "tooltip");
    var iDeleta = document.createElement("I");
    iDeleta.className = "fas fa-trash-alt";
    deleta.appendChild(iDeleta);

    var tdRemove = document.createElement("TD");
        tdRemove.appendChild(deleta);

    var valorTotal = Number((valor*quant).toFixed(2));
    valorTotal = Number((valorTotal).toFixed(2));

    tdNome.innerHTML = nome;
    tdValor.innerHTML = valor;
    tdQuant.innerHTML = quant;
    tdTotal.innerHTML = valorTotal;
    

    var tr = document.createElement("TR");
        tr.appendChild(tdNome);
        tr.appendChild(tdQuant);
        tr.appendChild(tdValor);
        tr.appendChild(tdTotal);
        tr.appendChild(tdRemove);

    document.getElementById("myCarBody").appendChild(tr);

  }

  function remove(r) {
    
    tr = $(r).parents("tr");
    var cols = tr.children("td");

    quant = $(cols[1]).text();
    valor = $(cols[2]).text();

    atualizaCar(2, quant, valor);

    var i = r.parentNode.parentNode.rowIndex - 1;
    document.getElementById("myCarBody").deleteRow(i);
  }

  function atualizaCar(opt, quant, valor) {
    var strongQuant = document.getElementById("strongQuant");
    var quantItensCar = parseInt($(strongQuant).text());

    var carrinho = document.getElementById("carrinho");
    var total = document.getElementById("total");

    var valorCarrinho = parseFloat($(carrinho).text());
    valorCarrinho = Number((valorCarrinho).toFixed(2));

    quant = parseInt(quant);
    valor = parseFloat(valor);
    valorTotal = Number( (valor * quant).toFixed(2));

    switch (opt) {
        case 1:
            quantItensCar += quant;
            valorCarrinho += valorTotal;
            break;

        case 2:
            quantItensCar -= quant;
            valorCarrinho -= valorTotal;

            if (quantItensCar === 0) {
                cabecalhoTable(2);
            }
            
            break;
    
        default:
            break;
    }
    
    strongQuant.innerHTML = quantItensCar;

    valorCarrinho = Number((valorCarrinho).toFixed(2));

    carrinho.innerHTML = valorCarrinho;
    total.innerHTML = valorCarrinho;
  }