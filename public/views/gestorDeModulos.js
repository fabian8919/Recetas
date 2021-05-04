$(document).ready(function () {

 
   $(document).on('click', '#side-menu a[href="#panelCategorias"]', function (e) {
        e.preventDefault();
        var status = actionsMenuActive('panelCategorias', 'Panel Categorias');
        if (status) {

          cargarModulo('mod_categorias/panelCategorias.php', function () {});
        }
    });

   $(document).on('click', '#side-menu a[href="#panelIngredientes"]', function (e) {
        e.preventDefault();
        var status = actionsMenuActive('panelIngredientes', 'Panel Ingredientes');
        if (status) {

          cargarModulo('mod_ingredientes/panelIngredientes.php', function () {});
        }
    });

    $(document).on('click', '#side-menu a[href="#panelRecetas"]', function (e) {
        e.preventDefault();
        var status = actionsMenuActive('panelRecetas', 'Panel Recetas');
        if (status) {

          cargarModulo('mod_recetas/panelRecetas.php', function () {});
        }
    });

    $(document).on('click', '#side-menu a[href="#panelRecetasIngredientes"]', function (e) {
        e.preventDefault();
        var status = actionsMenuActive('panelRecetasIngredientes', 'Panel Recetas Ingredientes');
        if (status) {

          cargarModulo('mod_recetasIngredientes/panelRecetasIngredientes.php', function () {});
        }
    });
    
});


function cargarModulo(modulo, fn, contenedor) {


    fn = (fn) ? fn : false;
    contenedor = (contenedor) ? contenedor : 'mD_principal';
    $("#" + contenedor).html('<div id="preloader"><div id="loader"></div></div>');
    $("#" + contenedor).load(modulo, function () {
        if (fn) {
            fn();
        }
        var div = modulo.split("/");
        var div = div[div.length - 1].split(".");
        if ($('#side-menu a[href="#' + div[0] + '"]').length > 0) {
            $('#side-menu a').each(function () {
                $(this).removeClass("active");
            });
            $('.manuLarPadre').each(function () {
                $(this).removeClass("active");
            });
            $('#side-menu a[href="#' + div[0] + '"]').addClass("active");
            if ($('#side-menu a[href="#' + div[0] + '"]').data("menupadre")) {
                $("#" + $('#side-menu a[href="#' + div[0] + '"]').data("menupadre")).addClass("active");
            }

        }
        i_moduloCargado = modulo;
        $("#fileInput").remove();
    });
    // cargarNotificacionesProceso();
}