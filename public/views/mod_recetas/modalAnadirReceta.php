<div class="modal fade" id="modalAñadirReceta" tabindex="" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"><strong>Añadir una Receta</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="formUpReceta" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control input-solid" id="inputNameRece" name="inputNameRece" placeholder="Nombre de la receta" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control input-solid" id="inputUrlVideo" name="inputUrlVideo" placeholder="Ingrese la Url del video" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">    
                            <div class="form-group">
                                <textarea class="form-control" name="inputPreparacion" id="inputPreparacion" placeholder="Digite los pasos de la preparación" required></textarea>
                            </div>           
                        </div>
                    </div><br>  
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label"><i class="fas fa-images"></i> Cargar Foto</label>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="input-file-up"  id="input_subirFoto" name="input_subirFoto" type="file" accept=".jpg, .png, .jpeg, .bmp" required>
                            </div>        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>