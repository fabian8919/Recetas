<?php
session_start();
if (!isset($_SESSION["authExito"]) && $_SESSION["authExito"] !== true){
    header("Location: ../index.html");
}
include "modalAnadirIngrediente.php";
include "modalEditarIngrediente.php";
?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-2 col-sm-3 col-xs-3">
                            <div class="form-group ">
                                <a href="#" data-toggle="tooltip" data-placement="bottom" data-original-title="Añadir Ingrediente" id="btnModalAñadirIngrediente" style="color: green;">
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
            <div class="col-md-2">
                <div class="form-group form-group-sm">
                    <div class="select2-input">
                        <select id="ingredientes_selectCate" name="ingredientes_selectCate" class="form-control" style="width: 100%;"></select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover dataTable table-bordered table-condensed compact nowrap" id="tableIngredientes" width="100%">
                        <thead class="bg-easycook2">
                            <tr>
                                <th >Id</th>
                                <th >Descripción</th>
                                <th >Categoría</th>
                                <th >Icono</th>
                                <th >Opciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/mod_ingredientes/ingredientes.js?v=<?=TIME;?>"></script>