i_moduloIni = 'plantilla/home.php';
$(document).ready(function () {
	cargarModulo(i_moduloIni);

    $("body").tooltip({
        selector: '[data-toggle=tooltip]'
    });

    $("#logout").on("click", function(){
      $('#modalSalir').modal('show');
    });
});

loadAllWindows();

function actionsMenuActive(item, title)
{
    if($("ul#side-menu .active#sub_"+item).length > 0)
        return false;

    $("ul#side-menu li").removeClass('active')
    $("ul#side-menu #sub_"+item).addClass('active')
    $(".page_title_modulo").html(title); //temporal

    return true;
}

function loadAllWindows() {

    $("#modalLoader").modal("show");
    $("#loadAllWindow").fadeIn(10);
}
function close_loadAllWindows() {
    $("#loadAllWindow").fadeOut(1000, function() {
      $("#modalLoader").modal('hide');
      $(".modal-backdrop.fade.show").remove();
      $('body').removeClass('modal-open');
      return null;
    });
    return null;
}

var logout = function(){
  $.ajax({
    url: "../clases/logout.php",
    method: "post",
  }).done(function (data) {
    window.location.href = '../index.html';
  });
}