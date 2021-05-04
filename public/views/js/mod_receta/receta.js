jQuery(function(){

	listarRecetas();

	$("#btnModalAñadirReceta").on("click", function(){
		$("#inputNameRece").val("");
		$("#inputUrlVideo").val("");
		$("#inputPreparacion").val("");
		$("#input_subirFoto").val("");
		$('#modalAñadirReceta').modal('show');
	});

	$("#input_subirFoto").on('change', function(){
    	let archivo = $(this).val();

    	let extension = ['jpg', 'png', 'jpeg', 'gif', 'bmp'];
    	if ($.inArray(archivo.split('.').pop().toLowerCase(), extension) == -1) {
    		Swal.fire({
		      	icon: 'warning',
		      	title: 'Advertencia!!',
			   	text:  "El archivo " + archivo.split('\\').pop() + " no contiene los formatos establecidos para una foto",
		    })
    		$(this).val('');
    		return false;
     	}   
  	});

  	$("#input_EditarFoto").on('change', function(){
    	let archivo = $(this).val();

    	let extension = ['jpg', 'png', 'jpeg', 'gif', 'bmp'];
    	if ($.inArray(archivo.split('.').pop().toLowerCase(), extension) == -1) {
    		Swal.fire({
		      	icon: 'warning',
		      	title: 'Advertencia!!',
			   	text:  "El archivo " + archivo.split('\\').pop() + " no contiene los formatos establecidos para una foto",
		    })
    		$(this).val('');
    		return false;
     	}   
  	});

  	$("#formUpReceta").submit(function(event){
	    event.preventDefault(); //prevent default action 

		var form_data = new FormData(this); //Creates new FormData object
		form_data.append('Metodo', btoa('insertar'))
	    
	    $.ajax({
	        url : "../clases/receta.php",
	        type: "POST",
	        data : form_data,
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function () {
				Swal.fire({
			      	icon: 'info',
			      	title: 'Insertando!',
			      	text: 'Por favor espere...',
			      	showConfirmButton: false
			    })
			},
	    }).done(function(response){ 
	    	Swal.fire({
		      	icon: 'success',
		      	title: 'Exito!',
			   	text:  "La receta fue registrada...",
		    })
			listarRecetas();
			$("#modalAñadirReceta").modal("hide");
	    });
	});

	$("#formEditReceta").submit(function(event){
	    event.preventDefault(); //prevent default action 

		var form_data = new FormData(this); //Creates new FormData object
		form_data.append('Metodo', btoa('edit'));
		form_data.append('idReceta', $("#idEditReceta").val());
		form_data.append('nombre', $("#inputEditNameReceta").val());
		form_data.append('video', $("#inputEditUrlVideoReceta").val());
		form_data.append('preparacion', $("#inputEditPrepaReceta").val());
    
	    $.ajax({
	        url : "../clases/receta.php",
	        type: "POST",
	        data : form_data,
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function () {
				Swal.fire({
			      	icon: 'info',
			      	title: 'Actualizando!',
			      	text: 'Por favor espere...',
			      	showConfirmButton: false
			    })
			},
	    }).done(function(response){ 
	    	Swal.fire({
		      	icon: 'success',
		      	title: 'Exito!',
			   	text:  "La receta fue actualizada...",
			}).then(() => {
				listarRecetas();
				$("#modalEditarReceta").modal("hide");
			});
		
	    });
	});
});

/////////////////////////////////////////////////
var listarRecetas = function(){
	
	$("#input_EditarFoto").val("");

	$.ajax({
		url: "../clases/receta.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('listar'),
			Parametros: '',
		},
		beforeSend: function () {
			loadAllWindows();
		},
	}).done(function (data) {
		close_loadAllWindows();
		var table = $("#tableRecetas").DataTable({
			data: data,
			processing: true,
			language: { "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json" },
			searching: true,
			lengthChange: false,
			pageLength: 10,

			"columnDefs": [
				{ "targets": 0, "data": "idReceta"},
				{ "targets": 1, "data": "nombre"},
				{ "targets": 2, "data": "video"},
				{ "targets": 3, "className": "text-center", "render": function (data, type, full) {
				  	var img = '<img width="195px" src="'+full.foto+'"</img>';
				  	
				  	return img;
				}
				},
				{ "targets": 4, "data": "preparacion"},
				{ "targets": 5, "className": "text-center", "render": function (data, type, full) {
				  	var edit = '<a href="#" onclick="mostrarModalEditarReceta('+full.idReceta+')" id="editarReceta'+full.idReceta+'" data-toggle="tooltip" data-placement="left" data-original-title="Editar Registro"><span class="btn btn-warning btn-sm"><i class="far fa-edit fa-lg"></i></span></a>  ';
				  	edit += '<a href="#" onclick="mostrarModalDeleteReceta('+full.idReceta+')" id="deleteReceta'+full.idReceta+'" data-toggle="tooltip" data-placement="right" data-original-title="Eliminar Registro"><span class="btn btn-danger btn-sm"><i class="far fa-times-circle fa-lg"></i></span></a>';

				  	return edit;
				}
				},
			],
			'bDestroy' : true
		});	
	});
}

var mostrarModalEditarReceta = function(id){

	$.ajax({
		url: "../clases/receta.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('listarId'),
			id: id,
		},
	}).done(function (data) {
		
		$("#idEditReceta").val(id);
		$("#inputEditNameReceta").val(data.nombre);
		$("#inputEditUrlVideoReceta").val(data.video);
		$("#inputEditPrepaReceta").val(data.preparacion);

		$("#modalEditarReceta").modal("show");

	});
}

/////////////////////////////////////////////////////
var mostrarModalDeleteReceta = function(id){

	Swal.fire({
		title: 'Estás Seguro?',
		text: "Se eliminará la receta!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Eliminar!'
	}).then((result) => {
	  	if (result.value) {
	  		$.ajax({
				url  : '../clases/receta.php',
				type:"POST",
				dataType: 'json',
				data: {
					Metodo: btoa("delete"),
					id: id,
			 	},
				beforeSend: function (){
					Swal.fire({
				      	icon: 'info',
				      	title: 'Eliminando!',
				      	text: 'Por favor espere...',
				      	showConfirmButton: false
				    })
				},
			 	success: function(data){
			 		Swal.fire(
				      	'Exito!',
				      	"La receta con el id: "+id+" fue eliminada...",
				      	'success'
				    ).then(() => {
						listarRecetas();
					});
			 	},
				error: function (request, status, error) {
					console.log("error delete receta:"+request.responseText)
				}
			})
		}
	})
}