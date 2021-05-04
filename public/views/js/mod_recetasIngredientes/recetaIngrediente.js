var tableIngred, tableIngreSelecc, receta;
////////////////////////DOCUMENT///////////////////
jQuery(function(){
		
	//Llenar el select recetas panel principal
	$.ajax({
		url: "../clases/receta.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('listarOnlyRecetas'),
			Parametros: '',
		},beforeSend: function () {
			$('#recIngre_recetasHome').html('');
			loadAllWindows();
		},	
	}).done(function (data) {
		close_loadAllWindows();
		$('#recIngre_recetasHome').append('<option value="9999999" selected>Seleccione una receta</option>')
		
		$.each(data, function(key, val){
			$('#recIngre_recetasHome').append('<option value="'+ val.idReceta+ '">'+val.nombre+'</option>')
		});

		$('#recIngre_recetasHome').select2({
			theme: "bootstrap"
		});

	});

	//Change del select recetas panel principal
	$("#recIngre_recetasHome").change(function(event) {
		event.preventDefault();
		let rece = $(this).val();

		if(rece == '9999999')
			return false;
		
		listarTableRecIngre(rece);
	});

	//clic en adicionar una relacion
	$("#btnModalAñadirRecetaIngrediente").on("click", function(){

		if( $.fn.DataTable.isDataTable("#tableReceIngre_ingredientes")){
	       $("#tableReceIngre_ingredientes").DataTable().clear().draw().destroy()
	    }

	    if( $.fn.DataTable.isDataTable("#tableReceIngre_relation")){
	       $("#tableReceIngre_relation").DataTable().clear().draw().destroy()
	    }
		
		tableIngreSelecc = $("#tableReceIngre_relation").DataTable({
	        select: true,
			language: { "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json" },
			searching: false,
			lengthChange: false,
			paging:   true,
	        ordering: false,
	        info:     false,
	        responsive: true,
	        pageLength: 7,

			"columnDefs": [
				{ "targets": 0, "visible" : false},
				{ "targets": 1},
				{ "targets": 2, "visible" : false},
				{ "targets": 3},
				{ "targets": 4},
				{ "targets": 5, "visible" : false},
				{ "targets": 6}
			],
			'bDestroy' : true
		});	

		getDataModalAñadirRecetaIngrediente();
	});

	//cuando cambia el select de categoria para llenar los ingredientes
	$("#recIngre_categoria").change(function(event) {
		event.preventDefault();

		let cate = $(this).val();

		if (cate != '9999999'){
			listarIngredientesXcategoria(cate);
		}
	});

	//cuando cambia el select de receta para obtener el id
	$("#recIngre_receta").change(function(event) {
		event.preventDefault();

		receta = $(this).find(':selected').data('receta');
	});

	//clic en la flecha de adicionar
	$("#recIngre_insert").on('click',  function(event) {
		event.preventDefault();
		llenarTableRelacion();
	});

	//clic en la flecha eliminar
	$("#recIngre_delete").on('click',  function(event) {
		event.preventDefault();
		deleteIngrediente();
	});


});
///////////////////////DOCUMENT///////////////////

var listarTableRecIngre = function(rece){
	
	var parametros = {
		"receta" : rece
	}

	$.ajax({
		url: "../clases/recetasIngredientes.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('listar'),
			Parametros: parametros,
		},beforeSend: function () {
			if( $.fn.DataTable.isDataTable("#tableRecetasIngredientes")){
		       $("#tableRecetasIngredientes").DataTable().clear().draw().destroy()
		    }
		    loadAllWindows();
		},
	}).done(function (data) {
		close_loadAllWindows();
		var table = $("#tableRecetasIngredientes").DataTable({
			// select: true,
			data: data,
			processing: true,
			language: { "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json" },
			searching: true,
			lengthChange: false,
			pageLength: 10,

			"columnDefs": [
				{ "targets": 0, "visible": false, "data": "idRelacion"},
				{ "targets": 1, "visible": false, "data": "idReceta"},
				{ "targets": 2, "data": "receta"},
				{ "targets": 3, "visible": false, "data": "idIngrediente"},
				{ "targets": 4, "data": "ingrediente"},
				{ "targets": 5, "data": "porcion"},
				{ "targets": 6, "className": "text-center", "render": function (data, type, full) {

					if (full.opcional == 'false' || full.opcional == 0){
						var icon = '<i class="fas fa-award fa-2x" data-toggle="tooltip" title="Ingrediente Pincipal" data-placement="bottom" data-original-title="Ingrediente Pincipal"></i>';
					}else{
						var icon = '<i class="fas fa-check-circle fa-2x" style="color:green;" data-toggle="tooltip" title="Ingrediente Opcional" data-placement="bottom" data-original-title="Ingrediente Opcional"></i>';
					}
					
					return icon;
				}
				},
				{ "targets": 7, "className": "text-center", "render": function (data, type, full) {
				  	var edit = '<a href="#" onclick="mostrarModalEditarRelacion('+full.idRelacion+')" id="editarRelacion'+full.idRelacion+'" data-toggle="tooltip" data-placement="left" data-original-title="Editar"><span class="btn btn-warning btn-sm"><i class="far fa-edit fa-lg"></i></span></a>  ';
				  	edit += '<a href="#" onclick="mostrarModalDeleteRelacion('+full.idRelacion+')" id="deleteRelacion'+full.idRelacion+'" data-toggle="tooltip" data-placement="right" data-original-title="Eliminar"><span class="btn btn-danger btn-sm"><i class="far fa-times-circle fa-lg"></i></span></a>';

				  	return edit;
				}
				},
			],
			"order": [[ 1, "asc" ]],
			'bDestroy' : true
		});	
	});
}

////////////////////////////////////////////////////////
var getDataModalAñadirRecetaIngrediente = function(){

	$.ajax({
		url: "../clases/receta.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('listarOnlyRecetas'),
			Parametros: '',
		},beforeSend: function () {
			$('#recIngre_receta').html('');
		},	
	}).done(function (data) {

		$('#recIngre_receta').append('<option value="9999999" selected>Seleccione una receta</option>')
		
		$.each(data, function(key, val){
			$('#recIngre_receta').append('<option value="'+ val.idReceta+ '" data-receta="'+val.nombre+'">'+val.nombre+'</option>')
		});

		$('#recIngre_receta').select2({
			theme: "bootstrap"
		});

	});

	$.ajax({
		url: "../clases/categorias.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('listar'),
			Parametros: '',
		},beforeSend: function () {
			// loadAllWindows();
			$('#recIngre_categoria').html('');
		},	
	}).done(function (data) {
		// close_loadAllWindows();
		$('#recIngre_categoria').append('<option value="9999999" selected>Seleccione una categoría</option>')
		$.each(data, function(key, val){
			$('#recIngre_categoria').append('<option value="'+ val.id+ '">'+val.descripcion+'</option>')
		});
	});

	$('#recIngre_categoria, #recIngre_receta').select2({
		theme: "bootstrap"
	});

	$('#modalAñadirRecetaIngrediente').modal('show');
}

////////////////////////////////////////////////////////////
var listarIngredientesXcategoria = function(cate){
	let idReceta = $("#recIngre_receta").val();

	$.ajax({
		url: "../clases/ingredientes.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('listarXcategoria'),
			idReceta: idReceta,
			categoria: cate,
		},beforeSend: function(){
			if( $.fn.DataTable.isDataTable("#tableReceIngre_ingredientes")){
	       		$("#tableReceIngre_ingredientes").DataTable().clear().draw().destroy()
	    	}
		},
	}).done(function (data) {
		tableIngred = $("#tableReceIngre_ingredientes").DataTable({
	        select: true,
			data: data,
			processing: true,
			language: { "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json" },
			searching: false,
			lengthChange: false,
			paging:   true,
	        ordering: false,
	        info:     false,
	        responsive: true,
	        pageLength: 7,

			"columnDefs": [
				{ "targets": 0, "visible" : false, "data": "idIngrediente"},
				{ "targets": 1, "data": "ingrediente"},
			],
			'bDestroy' : true
		});	
	});
}

//////////////////////////////////////////////////////
var llenarTableRelacion = function(){
	let idReceta = $("#recIngre_receta").val();
	let categoria = $('#recIngre_categoria').val();

	if (idReceta == '9999999' || idReceta == null){
		Swal.fire(
		  	'Advertencia!',
		  	'Debe seleccionar la receta',
		  	'warning'
		).then(() => {
			$( "#recIngre_receta" ).focus();
		});
		
		return false;
	}

	if (categoria == '9999999' || categoria == null){
		Swal.fire(
		  	'Advertencia!',
		  	'Debe seleccionar la categoria',
		  	'warning'
		).then(() => {
			$( "#recIngre_categoria" ).focus();
		});		
		return false;
	}

	let cantidadIngreSelect = tableIngred.rows('.selected').count();

	if (cantidadIngreSelect == 0){
		Swal.fire(
		  	'Advertencia!',
		  	'Debe seleccionar un ingrediente',
		  	'warning'
		);		
		return false;
	}

	let idIngreSelect = tableIngred.rows('.selected').data()[0]['idIngrediente'];
	let ingreSelect = tableIngred.rows('.selected').data()[0]['ingrediente'];

	for (var i = 0; i < tableIngreSelecc.rows().data().length; i++) {
		if (tableIngreSelecc.rows().data()[i][2] == idIngreSelect){
			Swal.fire(
			  	'Advertencia!',
			  	'El ingrediente seleccionado ya ha sido registrado',
			  	'warning'
			);		
			return false;
		}

	}

	(async () => {
		const { value: dataAdicional } = await Swal.fire({
		  title: 'Datos Adicionales',
		  html:
		    '<br><div class="row">'+
                '<div class="col-md-4 text-left">'+
                    '<h6><strong>Cantidad Porción</strong></h6>'+
                '</div>'+
                '<div class="col-md-4">'+
                    '<input type="number" id="cantidadIngre" class="form-control"/>'+
                '</div>'+
            '</div><br>'+
            '<div class="row">'+
                '<div class="col-md-4 text-left">'+
                    '<h6><strong>Medida</strong></h6>'+
                '</div>'+
                '<div class="col-md-4">'+
                    '<input id="medidaIngre" class="form-control" />'+
                '</div>'+
            '</div><br>'+
            '<div class="row">'+
                '<div class="col-md-5 text-left">'+
                    '<h6><strong>Es un ingrediente opcional?</strong></h6>'+
                '</div>'+
                '<div class="col-md-2" text-left">'+
                    '<input type="checkbox" id="opcionalIngre" class="form-control" />'+
                '</div>'+
            '</div>',
		  focusConfirm: false,
		  preConfirm: () => {

		  	if (document.getElementById('cantidadIngre').value === '') {
		      	Swal.showValidationMessage(`Debe digitar la cantidad`)
		      	return false;
		    }

		    if (document.getElementById('medidaIngre').value === '') {
		      	Swal.showValidationMessage(`Debe digitar la medida de la porción`)
		     	return false;
		    }

		    return [document.getElementById('cantidadIngre').value, document.getElementById('medidaIngre').value, $("#opcionalIngre").is(':checked')]
		  }
		})


		if (dataAdicional) {

			tableIngreSelecc.row.add([
		        idReceta,
		        receta,
		        idIngreSelect,
		        ingreSelect,
		        dataAdicional[0]+" "+dataAdicional[1],
		        dataAdicional[0]+"|"+dataAdicional[1],
		        dataAdicional[2] == true ? "Si" : "No"
		    ]).draw(false);

		}
	})();
}

///////////////////////////////////////////////////////////////
var addRelation = function(){
	let cantidadRelation = tableIngreSelecc.rows().count();
	let relations = [];

	if (cantidadRelation == 0){
		Swal.fire(
		  '¡ADVERTENCIA!',
		  'No hay nada por registrar',
		  'warning'
		)
		return false;
	}

	for (var i = 0; i < tableIngreSelecc.rows().data().length; i++) {
		relations[i] = tableIngreSelecc.rows().data()[i];  
	}

	var parametros = {
     	"relations": relations
    }

	$.ajax({
		url: "../clases/recetasIngredientes.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('insertar'),
			Parametros: parametros,
		},
		beforeSend: function () {
			Swal.fire(
			  '¡Insertando!',
			  'Por favor espere...',
			  'info'
			)
		},
	}).done(function (data) {
		Swal.fire(
		  'Exito!',
		  'Los ingredientes fueron añadidos a la receta o recetas',
		  'success'
		)

		let rec = $("#recIngre_recetasHome").val();
		
		if (rec != '9999999') {

			listarTableRecIngre(rec);
		}	

		$("#modalAñadirRecetaIngrediente").modal("hide");
	});	
}

////////////////////////////////////////////////////////////////////////
var deleteIngrediente = function(){
	let cantidadSelect = tableIngreSelecc.rows('.selected').count();

	if (cantidadSelect == 0){
		Swal.fire(
		 	'¡ADVERTENCIA!',
		  	'No hay nada por eliminar',
		  	'warning'
		)	
		return false;
	}

	tableIngreSelecc.rows('.selected').remove().draw(false);
}

///////////////////////////////////////////////////////////////////////
var mostrarModalEditarRelacion = function(id){

	var parametros = {
		"id": id
	}

	$.ajax({
		url: "../clases/recetasIngredientes.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('listarId'),
			Parametros: parametros,
		},beforeSend: function(){
			$("#idEditRelacion").val('');
			$("#inputEditPorcion1").val('');
			$("#inputEditPorcion2").val('');
			$("#inputEditOpcional").prop('checked', false);

		}
	}).done(function (data) {
		$("#idEditRelacion").val(data.idRelacion);
		$("#inputEditPorcion1").val(data.porcion1);
		$("#inputEditPorcion2").val(data.porcion2);
		if(data.opcional == 'true'){
			$("#inputEditOpcional").prop('checked', true);
		}
		$("#modalEditarRelacion").modal("show");

	});

}

///////////////////////////////////////////////////////////////
var editRelacion = function(){
	let id = $("#idEditRelacion").val();
	let porcion = $("#inputEditPorcion1").val()+"|"+$("#inputEditPorcion2").val();
	let opcional = $("#inputEditOpcional").is(':checked');

	var parametros = {
		"id": id,
		"porcion": porcion,
		"opcional": opcional
	}

	$.ajax({
		url: "../clases/recetasIngredientes.php",
		method: "post",
		dataType: 'json',
		data: {
			Metodo: btoa('edit'),
			Parametros: parametros,
		},
	}).done(function (data) {
			
			Swal.fire(
			 	'Exito!',
			  	'Fueron actualizados los datos',
			  	'success'
			)
			let rec = $("#recIngre_recetasHome").val();
			
			listarTableRecIngre(rec);
			$("#modalEditarRelacion").modal("hide");
			return false;
	});
}

///////////////////////////////////////////////////////////////////
var mostrarModalDeleteRelacion = function(id){
	var parametros = {
		"id": id,
	}

	Swal.fire({
		title: 'Estás Seguro?',
		text: "Se eliminará el registro!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, Eliminar!'
	}).then((result) => {
	  	if (result.value) {
	  		$.ajax({
				url  : '../clases/recetasIngredientes.php',
				type:"POST",
				dataType: 'json',
				data: {
					Metodo: btoa("delete"),
					Parametros: parametros,
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
				      	'El registro fue eliminado.',
				      	'success'
				    ).then(() => {
				    	let rec = $("#recIngre_recetasHome").val();
				
						listarTableRecIngre(rec);
					});
			 	},
				error: function (request, status, error) {
					console.log("error delete relacion:"+request.responseText)
				}
			})
		}
	})
}