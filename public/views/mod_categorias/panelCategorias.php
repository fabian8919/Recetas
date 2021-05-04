<?php
session_start();
if (!isset($_SESSION["authExito"]) && $_SESSION["authExito"] !== true){
    header("Location: ../index.html");
}
include "modalAnadirCategoria.php";
include "modalEditarCategoria.php";
?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-2 col-sm-3 col-xs-3">
                            <div class="form-group ">
                                <a href="#" data-toggle="tooltip" data-placement="bottom" data-original-title="Añadir Categoría" id="btnModalAñadirCateg" style="color: green;">
                                    <i class="fas fa-plus-circle fa-3x"></i></a>
                            </div>
                        </div>                                           
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover dataTable table-bordered table-condensed compact nowrap" id="tableCategorias" width="100%">
                        <thead class="bg-easycook2">
                            <tr>
                                <th >Id</th>
                                <th >Descripción</th>
                                <th >Icono</th>
                                <th >Options</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/mod_categorias/categorias.js?v=<?=TIME;?>"></script>