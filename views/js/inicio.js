$("#formIngresarSistema").submit(function(e){
      $(".overlay").removeClass('hidden');
	e.preventDefault();
	$.ajax({
		url:"ajax/trabajador.ajax.php",
      	method: "POST",
      	data: $("#formIngresarSistema").serialize(),
      	success:function(respuesta){
      		if(respuesta == "ok"){
      			window.location = "inicio";
      		}else{
      			swal({
			  		type: "error",
			  		title: "Los datos ingresados, son incorrectos",
			  		showConfirmButton: true,
			  		confirmButtonText: "Cerrar"
			  	}).then(function(result){
                              if (result.value) {
                                    $(".overlay").addClass('hidden');
                              }
                        });
      		}//else
      	}//success
    });//ajax
});//submit formIngresarSistema