<div class="modal fade" id="modalAñadirIngrediente" tabindex="" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"><strong>Añadir un ingrediente</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="formUpIngrediente" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-1">
                            <i class="fas fa-plus-circle fa-2x" style="color: green;"></i>
                        </div>
                        <div class="col-md-11 text-justify">
                            <h3><b>Digite los datos para añadir un ingrediente</b></h3>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-4">
                            <h4><strong>Categoría</strong></h4>
                        </div>
                        <div class="col-md-6">
                            <div class="select2-input">
                                <select id="selectCategoria" name="selectCategoria" class="form-control" style="width: 100%;"></select>
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="inputIngrediente" name="inputIngrediente" placeholder="Digite el ingrediente" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label"><i class="fas fa-images"></i> Cargar Icono</label>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="input-file-up"  id="input_subirIconoIngrediente" name="input_subirIconoIngrediente" type="file" accept=".png" required>
                            </div>        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm pull-right">
                                <button type="submit" class="btn btn-success btn-sm">Registrar</button>
                            </div>
                        </div>
                    </div>                
                </div>
            </form>
        </div>
    </div>
</div>