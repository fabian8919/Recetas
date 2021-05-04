<div class="modal fade" id="modalAñadirRecetaIngrediente" tabindex="" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"><strong>Añadir ingredientes a una receta</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    
                </div>
                <div class="row">
                    <div class="col-md-5 text-left">
                        <h6><strong>Seleccione la receta a la que va a añadir ingredientes</strong></h6>
                    </div>
                    <div class="col-md-4">
                        <div class="select2-input">
                            <select id="recIngre_receta" name="recIngre_receta" class="form-control" style="width: 100%;"></select>
                        </div>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-5 text-left">
                        <h6><strong>Seleccione la categoría del ingrediente</strong></h6>
                    </div>
                    <div class="col-md-4">
                        <div class="select2-input">
                            <select id="recIngre_categoria" name="recIngre_categoria" class="form-control" style="width: 100%;"></select>
                        </div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-12 text-left">
                        <p>Nota: Sólo se mostrarán los ingredientes no utilizados para la receta seleccionada</p>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <!-- Datatable ingredientes -->
                    <div class="col-md-5">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover dataTable table-bordered table-condensed compact nowrap" id="tableReceIngre_ingredientes" width="100%">
                                <thead class="bg-easycook2">
                                    <tr>
                                        <th style="display: none;">idIngrediente</th>
                                        <th >Ingrediente</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" data-original-title="Insertar" id="recIngre_insert"><i class="fas fa-caret-right fa-2x"></i></button>  
                        <hr class="hr_custom">
                        <button class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar" id="recIngre_delete"><i class="fas fa-caret-left fa-2x"></i></button>
                    </div>
                    <!-- Datatable Relacion receta ingrediente -->
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover dataTable table-bordered table-condensed compact nowrap" id="tableReceIngre_relation" width="100%">
                                <thead class="bg-easycook2">
                                    <tr>
                                        <th style="display: none;">idReceta</th>
                                        <th >Receta</th>
                                        <th style="display: none;">idIngrediente</th>
                                        <th >Ingrediente</th>
                                        <th >Porcion</th>
                                        <th style="display: none;">PorcionBD</th>
                                        <th >Opcional</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
                
            <div class="modal-footer">
                <button onclick="addRelation()" class="btn btn-success btn-sm"><i class="fas fa-plus-circle fa-1x"></i> Registrar</button>
            </div>
        </div>
    </div>
</div>