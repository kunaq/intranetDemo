/*=============================================
AGREGAR GALERIA
=============================================*/
$("#btnAgregarGaleria").click(function(){
  $('#formGaleria').trigger("reset");
  $("#modalTituloGaleria").html('Agregar Galería');
  $("#accionGaleria").val("crear");
});//click btnAgregarNoticia
/*=============================================
AGREGAR TIPO GALERIA
=============================================*/
$("#btnAgregarTipoGaleria").click(function(){
  $('#formTipoGaleria').trigger("reset");
  $("#modalTituloTipoGaleria").html('Agregar Imagen');
  $("#accionTipoGaleria").val("crear");
});//click btnAgregarNoticia
/*=============================================
EDITAR GALERIA
=============================================*/
$(".rowGaleria").on("click", ".btnEditarGaleria", function(){
  $(".overlay").removeClass('hidden');
  $("#modalTituloGaleria").html('Editar galeria');
  $("#accionGaleria").val("editar");
  var codGaleria = $(this).attr("codGaleria");
  var datos = new FormData();
  datos.append("codGaleria",codGaleria);
  datos.append("accionGaleria","mostrar");
  $.ajax({
    url:"ajax/galeria.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType:"json",
    success:function(respuesta){
      $("#codigoGaleria").val(respuesta["cod_galeria"]);
      $("#nombreGaleria").val(respuesta["dsc_galeria"]);
      $(".overlay").addClass('hidden');
    }//success
  });//ajax
});//click btnEditarGaleria
if($("#cantFotosGaleriaDetalle").val() > 0){
  $("#gallery").unitegallery({
    tile_width: 202,            //tile width
    tile_height: 160,
    grid_num_rows:3
  });
  setTimeout(function(){
       jQuery(document).find('.ug-thumb-wrapper').each(function(){
        var l = jQuery(this).find('div.ug-icon-zoom').css('left') || 0;
        //var capt = $('div.ug-icon-zoom').parent().parent().children('img').attr("src");
        var imagen = $(this).children('img').attr("src").replace(/'/g,"<");
        //console.log("imagen", imagen);
        var t = jQuery(this).find('div.ug-icon-zoom').css('top') || 0;
        var newl= l.split('px');
        var newle=parseInt(newl[0] || 0)+parseInt(41)+'px';
        var newt= t.split('px');
        var newte=parseInt(newt[0] || 0)+parseInt(3)+'px';
        if($("#permisoTipoGaleria").val() == 'SI'){
          jQuery(this).find('div.ug-icon-zoom')
          .after('<div class="ug-tile-icon ui-heart white_heart" style="position: absolute; margin: 0px; left: '+newle+'; top: '+newte+';"><i class="fa fa-remove" style="font-size:33px;color:#fff;" onClick="javascript:addToCart(\''+imagen+'\')"></i></div>');
        }else{
          jQuery(this).find('div.ug-icon-zoom')
          .after('<div class="ug-tile-icon ui-heart white_heart" style="position: absolute; margin: 0px; left: '+newle+'; top: '+newte+';"></div>');
        }
       });
   },1000);//setTimeout
  addToCart = function(imagen){
    $(".ug-lightbox-button-close").trigger("click");
    imagen = imagen.replace(/</g,"'");
    var nombreImagen = imagen.split('/');
    swal({
      title: '¿Está seguro de borrar la imagen?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar imagen!'
    }).then(function(result){
        if (result.value) {
          $.ajax({
            url:"ajax/galeria.ajax.php",
            method: "POST",
            data: "accionTipoGaleria=eliminar&imagen="+nombreImagen[2],
            success:function(respuesta){
              if(respuesta == "ok"){
                window.location = "index.php?ruta=tipoGaleria&codigo="+$("#codigoGaleria").val(); 
              }else{
                swal({
                  type: "error",
                  title: "Ha ocurrido un problema al eliminar esta imagen, por favor intente de nuevo.",
                  showConfirmButton: true,
                  confirmButtonText: "Cerrar"
                });//swal
              }//else
            }//success
          });//ajax
        }
    });
  }//function addToCart
}//if
/*=============================================
CREAR,EDITAR GALERIA
=============================================*/
$("#formGaleria").submit(function(e){
	e.preventDefault();
	$(".overlay").removeClass('hidden');
	$.ajax({
    url:"ajax/galeria.ajax.php",
    method: "POST",
    data: $("#formGaleria").serialize(),
    success:function(respuesta){
    	console.log("respuesta", respuesta);
    	if(respuesta == "ok"){
  			swal({
       		type: "success",
      		title: "La galeria ha sido guardada correctamente",
      		showConfirmButton: true,
      		confirmButtonText: "Cerrar"
      	}).then(function(result){
        	if (result.value) {
          		window.location = "galeria";
        	}
        });//swall
  		}else if(respuesta == "nombreRepetido"){
        swal({
          type: "error",
          title: "El nombre que has ingresado ya existe, por favor ingrese otro nombre.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
            if (result.value) {
              $("#nombreGaleria").focus();
            }
        });
      }else{
        swal({
          type: "error",
          title: "Ha ocurrido un problema al guardar esta galeria, por favor intente de nuevo.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
          if (result.value) {
            window.location = "galeria";
          }
        });
      }//else
    	$(".overlay").addClass('hidden');
    }//success
	});//ajax
});//submit formGaleria
/*=============================================
ELIMINAR GALERIA
=============================================*/
$(".rowGaleria").on("click", ".btnEliminarGaleria", function(){
  var codigoGaleria = $(this).attr("codGaleria");
  var accionGaleria = "eliminar";
  swal({
    title: '¿Está seguro de borrar la galeria?',
    text: "¡Si no lo está puede cancelar la acción!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, borrar la galeria!'
  }).then(function(result){
    if (result.value) {
      $.ajax({
        url:"ajax/galeria.ajax.php",
        method: "POST",
        data: "accionGaleria="+accionGaleria+"&codigoGaleria="+codigoGaleria,
        success:function(respuesta){
          if(respuesta == 'ok'){
            window.location = "galeria";
          }else{
            swal({
              type: "error",
              title: "Ha ocurrido un problema al eliminar esta galería, por favor intente de nuevo.",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
            });//swal
          }//else
        }//success
      });//ajax
    }//if
  });//then
});//Click btnEliminarCotizacion

/*=============================================
TIPO GALERIA
=============================================*/

/*=============================================
SUBIENDO LA IMAGEN DE LA GALERIA
=============================================*/
$(".imagenTipoGaleria").change(function(){
  var imagen = [];
  for (var i = 0; i < this.files.length; i++) {
    imagen = this.files[i];
    if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){
      $(".imagenTipoGaleria").val("");
      swal({
        title: "Error al subir la imagen",
        text: "¡La imagen debe estar en formato JPG o PNG!",
        type: "error",
        confirmButtonText: "¡Cerrar!"
      });
    }//if
  }//for
});//change imagenTipoGaleria
/*=============================================
CREAR,EDITAR TIPO GALERIA
=============================================*/
$("#formTipoGaleria").submit(function(e){
  e.preventDefault();
  $(".overlay").removeClass('hidden');
  var formData = new FormData($("#formTipoGaleria")[0]);
  $.ajax({
    url:"ajax/galeria.ajax.php",
    method: "POST",
    data: formData,
    cache:false,
    contentType: false,
    processData: false,
    success:function(respuesta){
      console.log("respuesta2", respuesta);
      if(respuesta == "ok"){
        swal({
          type: "success",
          title: "La imagen ha sido guardada correctamente",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
          if (result.value) {
              window.location = "index.php?ruta=tipoGaleria&codigo="+$("#codigoGaleria").val();
          }
        });//swall
      }else{
        swal({
          type: "error",
          title: "Ha ocurrido un problema al ingresar esta galeria, por favor intente de nuevo.",
          showConfirmButton: true,
          confirmButtonText: "Cerrar"
        }).then(function(result){
          if (result.value) {
            window.location = "index.php?ruta=tipoGaleria&codigo="+$("#codigoGaleria").val();
          }
        });
      }//else
      $(".overlay").addClass('hidden');
    }//success
  });//ajax
});//submit formTipoGaleria