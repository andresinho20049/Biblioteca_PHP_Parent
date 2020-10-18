var prevScrollpos = window.pageYOffset;
$(window).scroll(function () {
    if ($(this).scrollTop() > 290) {
        $('#navbar_top').addClass("fixed-top");
        // add padding top to show content behind navbar
        $('body').css('padding-top', $('.navbar').outerHeight() + 'px');
        var currentScrollPos = window.pageYOffset;
        if ($(this).scrollTop() > 350) {
            if (prevScrollpos > currentScrollPos) {
                document.getElementById("navbar_top").style.top = "0";
            } else {
                document.getElementById("navbar_top").style.top = "-50px";
            }
            prevScrollpos = currentScrollPos;
        }
    } else {
        $('#navbar_top').removeClass("fixed-top");
        // remove padding top from body
        $('body').css('padding-top', '0');
    }
});

$(document).ready(function () {
    var pathname = window.location.href.split('#')[0];
    $('a[href^="#"]').each(function () {
        var $this = $(this),
            link = $this.attr('href');
        $this.attr('href', pathname + link);
    });
});

// Adicione o seguinte código se quiser que o nome do arquivo apareça na seleção
$(".custom-file-input").on("change", function () {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});