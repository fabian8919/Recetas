$( document ).ready(function() {
	$(document).keypress(function(event){
	    var keycode = (event.keyCode ? event.keyCode : event.which);
	    if(keycode == '13'){
	        auth();  
	    }
	});
});

var auth = function(){
	let email = $("#inputEmail").val();
	let pass = $("#inputPassword").val();

	if (email == ''){
		Swal.fire(
		  'Advertencia!',
		  'Debe digitar el email...',
		  'warning'
		)
		return false;
	}

	if (pass == ''){
		Swal.fire(
		  'Advertencia!',
		  'Debe digitar la contraseña...',
		  'warning'
		)
		return false;
	}

	$.ajax({
		url: "clases/auth.php",
		method: "post",
		data: {
			email: btoa(email),
			pass: btoa(pass),
		},
		beforeSend: function () {
			Swal.fire({
		      	icon: 'info',
		      	title: 'Validando!',
		      	text: 'Por favor espera...',
		      	showConfirmButton: false
		    })
		},
	}).done(function (data) {
		if (data == "true"){
			window.location.href = 'views/admin.php';
		}else{
			Swal.fire({
		      	icon: 'error',
		      	title: 'Error!',
		      	text: 'Usuario o contraseña erronea!',
		    })
			return false;
		}
	});
};