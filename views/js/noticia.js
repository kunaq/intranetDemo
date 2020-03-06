$('#noticiaPaginate').easyPaginate({
	paginateElement: 'li',
	elementsPerPage: 4,
	effect: 'climb'
});
/*=============================================
SUBIENDO LA FOTO DEL USUARIO
=============================================*/
$(".imagenNoticia").change(function(){
	var imagen = this.files[0];
	/*=============================================
	VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
	=============================================*/
	if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
		$(".imagenNoticia").val("");
		swal({
			title: "Error al subir la imagen",
			text: "¡La imagen debe estar en formato JPG o PNG!",
			type: "error",
			confirmButtonText: "¡Cerrar!"
		});
	}else{
		//Filereader es una clase para hacer lectura de archivo
		var datosImagen = new FileReader;
		datosImagen.readAsDataURL(imagen);
		//ejecuta el event load, Cuando esto esta cargado
		$(datosImagen).on("load",function(event){
			var rutaImagen = event.target.result;
			$(".previsualizarNoticia").attr("src",rutaImagen);
		})
	}
});
/*=============================================
AGREGAR NOTICIA
=============================================*/
$("#btnAgregarNoticia").click(function(){
	$(".previsualizarNoticia").attr("src","views/img/users/default-50x50.gif");
	$('#formNoticia').trigger("reset");
	$("#modalTituloNoticia").html('Agregar noticia');
	$("#accionNoticia").val("crear");
});//click btnAgregarNoticia
/*=============================================
EDITAR NOTICIA
=============================================*/
$("#noticiaPaginate").on("click", ".btnEditarNoticia", function(){
  	$(".overlay").removeClass('hidden');
	$("#modalTituloNoticia").html('Editar noticia');
	$("#accionNoticia").val("editar");
	var codNoticia = $(this).attr("codNoticia");
	var datos = new FormData();
	datos.append("codNoticia",codNoticia);
	datos.append("accionNoticia","mostrar");
	$.ajax({
		url:"ajax/noticia.ajax.php",
	  	method: "POST",
	  	data: datos,
	  	cache: false,
	  	contentType: false,
	  	processData: false,
	  	dataType:"json",
	  	success:function(respuesta){
	  		$("#codigoNoticia").val(respuesta["cod_noticia"]);
	  		$("#autorNoticia").val(respuesta["dsc_nombres"]+' '+respuesta["dsc_apellido_paterno"]+' '+respuesta["dsc_apellido_materno"]);
	  		$("#fechaPublicacionNoticia").val(respuesta["fch_publicacion"]);
	  		$("#tituloNoticia").val(respuesta["dsc_titulo"]);
	  		$("#resumenNoticia").val(respuesta["dsc_resumen"]);
	  		$("#imagenActualNoticia").val(respuesta["imagen"]);
			$(".previsualizarNoticia").attr("src","archivos/noticia/"+respuesta["imagen"]);
	    	$(".overlay").addClass('hidden');	    
	    }//success
	});//ajax
});//click btnEditarNoticia
/*=============================================
ELIMINAR NOTICIA
=============================================*/
$("#noticiaPaginate").on("click", ".btnEliminarNoticia", function(){
	var codigoNoticia = $(this).attr("codNoticia");
	var imagenNoticia = $(this).attr("imagenNoticia")
  	$("#accionNoticia").val("eliminar");
	swal({	
	    title: '¿Está seguro de borrar la noticia?',
	    text: "¡Si no lo está puede cancelar la accíón!",
	    type: 'warning',
	    showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	    cancelButtonColor: '#d33',
	    cancelButtonText: 'Cancelar',
	    confirmButtonText: 'Si, borrar noticia!'
	}).then(function(result){
        if (result.value) {        
          	$.ajax({
            	url:"ajax/noticia.ajax.php",
            	method: "POST",
            	data: "accionNoticia="+$("#accionNoticia").val()+"&imagenNoticia="+imagenNoticia+"&codigoNoticia="+codigoNoticia,
            	success:function(respuesta){
            		//console.log("respuesta", respuesta);
                	if(respuesta == "ok"){
                		window.location = "noticia";
                	}
              	}//success
            });//ajax        
        }//if
    });
});//click btnEliminarUsuario
/*=============================================
CREAR,EDITAR NOTICIA
=============================================*/
$("#formNoticia").submit(function(e){
	e.preventDefault();
	$(".overlay").removeClass('hidden');
	var formData = new FormData($("#formNoticia")[0]);
	$.ajax({
		url:"ajax/noticia.ajax.php",
      	type: "POST",
      	data: formData,
	    cache:false,
	    contentType: false,
	    processData: false,
      	success:function(respuesta){
      		//console.log("respuesta", respuesta);
      		if(respuesta == "ok"){
      			swal({
             		type: "success",
              		title: "La noticia ha sido guardada correctamente",
              		showConfirmButton: true,
              		confirmButtonText: "Cerrar"
            	}).then(function(result){
                	if (result.value) {
                  		window.location = "noticia";
                	}
            	});//swall
      		}else if(respuesta == "nombreRepetido"){
		        swal({
		          type: "error",
		          title: "El título que has ingresado ya existe, por favor ingrese otro título.",
		          showConfirmButton: true,
		          confirmButtonText: "Cerrar"
		        }).then(function(result){
		            if (result.value) {
		              	$("#tituloNoticia").focus();
		            }
		        });
		    }else{
		        swal({
		          type: "error",
		          title: "Ha ocurrido un problema al guardar esta noticia, por favor intente de nuevo.",
		          showConfirmButton: true,
		          confirmButtonText: "Cerrar"
		        }).then(function(result){
		          if (result.value) {
		            window.location = "noticia";
		          }
		        });
      		}//else
      		$(".overlay").addClass('hidden');
      	}//success
	});//ajax
});//submit formNoticia