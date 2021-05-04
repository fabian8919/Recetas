<?php
session_start();
if (!isset($_SESSION["authExito"]) && $_SESSION["authExito"] !== true){
    header("Location: ../index.html");
}
include "modalAnadirRecetaIngrediente.php";
include "modalEditarRelacion.php";
?>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-2 col-sm-3 col-xs-3">
                            <div class="form-group ">
                                <a href="#" data-toggle="tooltip" data-placement="bottom" data-original-title="Añadir Receta" id="btnModalAñadirRecetaIngrediente" style="color: green;">
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
                        <select id="recIngre_recetasHome" name="recIngre_recetasHome" class="form-control" style="width: 100%;"></select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover dataTable table-bordered table-condensed compact nowrap" id="tableRecetasIngredientes" width="100%">
                        <thead class="bg-easycook2">
                            <tr>
                                <th style="display: none;">IdRecetaIngrediente</th>
                                <th style="display: none;">IdReceta</th>
                                <th >Receta</th>
                                <th style="display: none;">idIngrediente</th>
                                <th >Ingrediente</th>
                                <th >Porción</th>
                                <th >Ingrediente Opcional</th>
                                <th >Opciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/mod_recetasIngredientes/recetaIngrediente.js?v=<?=TIME;?>"></script>