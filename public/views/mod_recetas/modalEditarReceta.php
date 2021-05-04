<div class="modal fade" id="modalEditarReceta" tabindex="" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"><strong>Editar una Receta</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="formEditReceta" enctype="multipart/form-data">           
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-1">
                            <i class="fas fa-edit fa-2x" style="color: orange;"></i>
                        </div>
                        <div class="col-md-11 text-justify">
                            <p><b>Actualiza la receta</b></p>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="inputEditNameReceta">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="inputEditUrlVideoReceta">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">    
                            <div class="form-group">
                                <textarea class="form-control" id="inputEditPrepaReceta"></textarea>
                            </div>           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label"><i class="fas fa-images"></i> Editar Foto</label>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="input-file-up"  id="input_EditarFoto" name="input_EditarFoto" type="file" accept=".jpg, .png, .jpeg, .bmp">
                            </div>        
                        </div>
                    </div>
                </div>
                <input type="hidden" id="idEditReceta">
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm pull-right">
                                <button type="submit" class="btn btn-success btn-sm">Actualizar</button>
                            </div>
                        </div>
                    </div>                
                </div>
            </form>
        </div>
    </div>
</div>