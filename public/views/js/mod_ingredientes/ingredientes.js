jQuery(function(){

	//Llenar el select categoria panel principal
	$.ajax({
		url: "../clases/categorias.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('listar'),
			Parametros: '',
		},beforeSend: function () {
			$('#ingredientes_selectCate').html('');
			loadAllWindows();
		},	
	}).done(function (data) {
		close_loadAllWindows();
		$('#ingredientes_selectCate').append('<option value="9999999" selected>Seleccione una categoria</option>')
		
		$.each(data, function(key, val){
			$('#ingredientes_selectCate').append('<option value="'+ val.id+ '">'+val.descripcion+'</option>')
		});

		$('#ingredientes_selectCate').select2({
			theme: "bootstrap"
		});

	});


	//Change del select categoria panel principal
	$("#ingredientes_selectCate").change(function(event) {
		event.preventDefault();
		let categoria = $(this).val();

		if(categoria == '9999999')
			return false;
		
		listarIngredientes(categoria);
	});

	$("#btnModalAñadirIngrediente").on("click", function(){
		$("#inputIngrediente").val("");
		$("#input_subirIconoIngrediente").val("");
		llenarCategorias();
		$('#modalAñadirIngrediente').modal('show');
	});

	$("#input_subirIconoIngrediente").on('change', function(){
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

  	$("#formUpIngrediente").submit(function(event){
	    event.preventDefault(); //prevent default action 
	    let ingredient = $("#inputIngrediente").val();
		// let idCat = $("#selectCategoria").val();
		let idHomeCate = $("#ingredientes_selectCate").val();

		var form_data = new FormData(this); //Creates new FormData object
		form_data.append('Metodo', btoa('insertar'))
	    
	    $.ajax({
	        url : "../clases/ingredientes.php",
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
				   	text:  "El ingrediente: "+ingredient+" fue registrado...",
			    })
			    
			    if (idHomeCate != '9999999'){
					listarIngredientes(idHomeCate);
			    }

			}else{

				Swal.fire({
			      	icon: 'warning',
			      	title: 'Advertencia!',
				   	text:  "El ingrediente: "+ingredient+" ya existe...",
			    })
				return false;
			}
	    });
	});

  	$("#formEditIngrediente").submit(function(event){
	    event.preventDefault(); //prevent default action 

		var form_data = new FormData(this); //Creates new FormData object
		form_data.append('Metodo', btoa('edit'));
    
	    $.ajax({
	        url : "../clases/ingredientes.php",
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
				   	text:  "Se actualizó el Ingrediente",
			    })

			    let idHomeCate = $("#ingredientes_selectCate").val();
			    
			    if (idHomeCate != '9999999'){
					listarIngredientes(idHomeCate);
			    }

				$("#modalEditarIngrediente").modal("hide");
				return false;
			}else{
				Swal.fire({
			      	icon: 'warning',
			      	title: 'Advertencia!',
				   	text:  "El ingrediente ya existe...",
			    })
				return false;
			}
		
	    });
	});
	
});

/////////////////////////////////////////////////////
var listarIngredientes = function(idCat){
	
	$.ajax({
		url: "../clases/ingredientes.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('listar'),
			idCat: idCat,
		},
	}).done(function (data) {
		var table = $("#tableIngredientes").DataTable({
			data: data,
			processing: true,
			language: { "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json" },
			searching: true,
			lengthChange: false,
			pageLength: 10,

			"columnDefs": [
				{ "targets": 0, "data": "idIngrediente"},
				{ "targets": 1, "data": "ingrediente"},
				{ "targets": 2, "data": "categoria"},
				{ "targets": 3, "className": "text-center", "render": function (data, type, full) {
				  	
				  	var img = '<img width="195px" src="'+full.icono+'"</img>';
				  	
				  	return img;
				}
				},
				{ "targets": 4, "className": "text-center", "render": function (data, type, full) {
				  	var edit = '<a href="#" onclick="mostrarModalEditarIngrediente('+full.idIngrediente+')" id="editarIngrediente'+full.idIngrediente+'" data-toggle="tooltip" data-placement="left" data-original-title="Editar Registro"><span class="btn btn-warning btn-sm"><i class="far fa-edit fa-lg"></i></span></a>  ';
				  	edit += '<a href="#" onclick="mostrarModalDeleteIngrediente('+full.idIngrediente+')" id="deleteIngrediente'+full.idIngrediente+'" data-toggle="tooltip" data-placement="right" data-original-title="Eliminar Registro"><span class="btn btn-danger btn-sm"><i class="far fa-times-circle fa-lg"></i></span></a>';

				  	return edit;
				}
				},
			],
			'bDestroy' : true
		});	
	});
}

/////////////////////////////////////////////////
var llenarCategorias = function(){
	$.ajax({
		url: "../clases/categorias.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('listar'),
			Parametros: '',
		},
	}).done(function (data) {
		$.each(data, function(key, val){
			$('#selectCategoria').append('<option value="'+ val.id+ '">'+val.descripcion+'</option>')
		});

		$('#selectCategoria').select2({
			theme: "bootstrap"
		});
	});
}


////////////////////////////////////////////////////////////
var mostrarModalEditarIngrediente = function(id){

	$.ajax({
		url: "../clases/ingredientes.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('listarId'),
			id: id,
		},
	}).done(function (data) {
		$.each(data.cate, function(key, val){
			$('#selectEditCategoria').append('<option value="'+ val.id+ '">'+val.descripcion+'</option>')
		});

		$('#selectEditCategoria option[value="'+data.ing["idCategoria"]+'"]').prop('selected', 'selected');
		$('#selectEditCategoria').select2({
			theme: "bootstrap"
		});

		$("#idEditIngrediente").val(id);
		$("#inputEditIngrediente").val(data.ing["descripcion"]);
		$("#modalEditarIngrediente").modal("show");
	});
}


////////////////////////////////////////////////////////////
var mostrarModalDeleteIngrediente = function(id){

  	Swal.fire({
		title: 'Estás Seguro?',
		text: "Se eliminará el ingrediente!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Eliminar!'
	}).then((result) => {
	  	if (result.value) {
	  		$.ajax({
				url  : '../clases/ingredientes.php',
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
				      	"El ingrediente con el id: "+id+" fue eliminado...",
				      	'success'
				    ).then(() => {
				    	let idHomeCate = $("#ingredientes_selectCate").val();
				
						if (idHomeCate != '9999999'){
							listarIngredientes(idHomeCate);

					    }
					});
			 	},
				error: function (request, status, error) {
					console.log("error delete ingrediente:"+request.responseText)
				}
			})
		}
	})
}