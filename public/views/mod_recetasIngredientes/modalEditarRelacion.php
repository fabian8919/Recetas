<div class="modal fade" id="modalEditarRelacion" tabindex="" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title"><strong>Editar datos del ingrediente</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-1">
                        <i class="fas fa-edit fa-2x" style="color: orange;"></i>
                    </div>
                    <div class="col-md-11 text-justify">
                        <p><b>Actualiza los datos</b></p>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-6">
                        <h4><strong>Porcion</strong></h4>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="number" class="form-control" id="inputEditPorcion1">
                        </div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-6">
                        <h4><strong>Medida de la porción</strong></h4>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputEditPorcion2">
                        </div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-6">
                        <h4><strong>El ingrediente es opcional?</strong></h4>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="form-control" id="inputEditOpcional">
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="idEditRelacion">
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm pull-right">
                            <button onclick="editRelacion()" class="btn btn-warning btn-sm"><i class="fas fa-edit fa-1x"></i> Actualizar</button>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>