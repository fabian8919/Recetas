jQuery(function(){
	
	listarCategorias();

	$("#btnModalAñadirCateg").on("click", function(){

		$("#inputCategoria").val("");
		$("#input_EditarFoto").val("");
		$('#modalAñadirCategoria').modal('show');
	});

	$("#input_subirIconoCate").on('change', function(){
    	let archivo = $(this).val();

    	let extension = ['png'];
    	if ($.inArray(archivo.split('.').pop().toLowerCase(), extension) == -1) {
    		Swal.fire({
		      	icon: 'warning',
		      	title: 'Advertencia!!',
			   	text:  "El archivo " + archivo.split('\\').pop() + " no contiene el formato png",
		    })
    		$(this).val('');
    		return false;
     	}   
  	});

  	$("#input_EditarIcono").on('change', function(){
    	let archivo = $(this).val();

    	let extension = ['png'];
    	if ($.inArray(archivo.split('.').pop().toLowerCase(), extension) == -1) {
    		Swal.fire({
		      	icon: 'warning',
		      	title: 'Advertencia!!',
			   	text:  "El archivo " + archivo.split('\\').pop() + " no contiene el formato png",
		    })
    		$(this).val('');
    		return false;
     	}   
  	});

	$("#formUpCategoria").submit(function(event){
	    event.preventDefault(); //prevent default action 

		var form_data = new FormData(this); //Creates new FormData object
		form_data.append('Metodo', btoa('insertar'))
	    
	    $.ajax({
	        url : "../clases/categorias.php",
	        type: "POST",
	        data : form_data,
			contentType: false,
			cache: false,
			processData:false,
			dataType: 'json',
			beforeSend: function () {
				Swal.fire({
			      	icon: 'info',
			      	title: 'Insertando!',
			      	text: 'Por favor espere...',
			      	showConfirmButton: false
			    })
			},
	    }).done(function(response){ 

	    	if (response == "insertado"){

				Swal.fire({
			      	icon: 'success',
			      	title: 'Exito!',
			      	text: "La categoría fue registrada...",
			    }).then(() => {
					listarCategorias();
					$("#modalAñadirCategoria").modal("hide");
					return false;
			    });

			}else{

				Swal.fire({
			      	icon: 'warning',
			      	title: 'Advertencia!',
			      	text: "La categoría ya existe...",
			    });
				return false;
			}
	    });
	});


	$("#formEditCategoria").submit(function(event){
	    event.preventDefault(); //prevent default action 

		var form_data = new FormData(this); //Creates new FormData object
		form_data.append('Metodo', btoa('edit'));
    
	    $.ajax({
	        url : "../clases/categorias.php",
	        type: "POST",
	        data : form_data,
			contentType: false,
			cache: false,
			processData:false,
			dataType: 'json',
			beforeSend: function () {
				Swal.fire({
			      	icon: 'info',
			      	title: 'Actualizando!',
			      	text: 'Por favor espere...',
			      	showConfirmButton: false
			    })
			},											
	    }).done(function(response){ 
	    	if (response == 'actualiza'){
				Swal.fire({
			      	icon: 'success',
			      	title: 'Exito!',
				   	text:  "Se actualizó la categoría",
			    }).then(() => {
					listarCategorias();
					$("#modalEditarCategoria").modal("hide");
					return false;
			    });
			}else{
				Swal.fire({
			      	icon: 'warning',
			      	title: 'Advertencia!',
			      	text: "La categoría ya existe...",
			    })
				return false;
			}
		
	    });
	});
});

/////////////////////////////////////////
var listarCategorias = function(){
	$.ajax({
		url: "../clases/categorias.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('listar'),
			Parametros: '',
		},
	}).done(function (data) {
		var table = $("#tableCategorias").DataTable({
			// select: true,
			data: data,
			processing: true,
			language: { "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json" },
			searching: true,
			lengthChange: false,
			pageLength: 5,

			"columnDefs": [
				{ "targets": 0, "data": "id"},
				{ "targets": 1, "data": "descripcion"},
				{ "targets": 2, "className": "text-center", "render": function (data, type, full) {
				  	
				  	var img = '<img width="195px" src="'+full.icono+'"</img>';
				  	
				  	return img;
				}
				},
				{ "targets": 3, "className": "text-center", "render": function (data, type, full) {
				  	var edit = '<a href="#" onclick="mostrarModalEditarCategoria('+full.id+')" id="editarCategoria'+full.id+'" data-toggle="tooltip" data-placement="left" data-original-title="Editar Registro"><span class="btn btn-warning btn-sm"><i class="far fa-edit fa-lg"></i></span></a>  ';
				  	edit += '<a href="#" onclick="mostrarModalDeleteCategoria('+full.id+')" id="deleteCategoria'+full.id+'" data-toggle="tooltip" data-placement="right" data-original-title="Eliminar Registro"><span class="btn btn-danger btn-sm"><i class="far fa-times-circle fa-lg"></i></span></a>';

				  	return edit;
				}
				},
			],
			"order": [[ 1, "asc" ]],
			'bDestroy' : true
		});	
	});
}

/////////////////////////////////////////////////////
var mostrarModalEditarCategoria = function(id){
	$("#input_EditarIcono").val("");

	$.ajax({
		url: "../clases/categorias.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('listarId'),
			id: id,
		},
	}).done(function (data) {
		$("#idEditCategoria").val(id);
		$("#inputEditCategoria").val(data.descripcion);
		$("#modalEditarCategoria").modal("show");
	});
}

/////////////////////////////////////////////////////
var mostrarModalDeleteCategoria = function(id){

  	Swal.fire({
		title: 'Estás Seguro?',
		text: "Se eliminará la categoría!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Eliminar!'
	}).then((result) => {
	  	if (result.value) {
	  		$.ajax({
				url  : '../clases/categorias.php',
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
				      	"La categoría con el id: "+id+" fue eliminada...",
				      	'success'
				    ).then(() => {
						listarCategorias();				
					});
			 	},
				error: function (request, status, error) {
					console.log("error delete categoria:"+request.responseText)
				}
			})
		}
	})
}