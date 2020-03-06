<div id="modalTipoGaleria" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
   		<form enctype="multipart/form-data" role="form" method="post" id="formTipoGaleria">
        <div class="overlay overlay-kq hidden">
          <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
        </div>
   			<!--=====================================
    		CABEZA DEL MODAL
    		======================================-->
    		<div class="modal-header" style="background:#FBBA00 repeat scroll 0 0; color:#013976;">
    			<button type="button" class="close" data-dismiss="modal">&times;</button>
      			<h4 class="modal-title" style="font-weight: bold;" id="modalTituloTipoGaleria">Agregar Imagen</h4>
    		</div>
    		<!--=====================================
    		CUERPO DEL MODAL
    		======================================-->
    		<div class="modal-body">
    			<div class="box-body">    				
      			<!-- ENTRADA PARA SELECCIONAR SUBIR FOTO -->
      			<div class="form-group">
      		    <div class="panel">SUBIR FOTO</div>							
			        <input type="file" class="imagenTipoGaleria" name="imagenTipoGaleria[]" id="imagenTipoGaleria" multiple="" required>        	    
              <!-- Sino modificamos la imagen, seria buena guardar la imagen actual en un hidden -->
              <input type="hidden" name="imagenActualNoticia" id="imagenActualNoticia">
      			</div>
    			</div>
      	</div>
      	<!--=====================================
    		PIE DEL MODAL
    		======================================-->
    		<div class="modal-footer">
    		  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
    			<button type="submit" class="btn btn-primary btn-agregar-kq">Guardar imagen</button>
    		</div>
        <input type="hidden" id="accionTipoGaleria" name="accionTipoGaleria">
        <input type="hidden" id="codigoGaleria" name="codigoGaleria" value="<?php echo $_GET["codigo"]; ?>">
   		</form>
    </div>		
	</div>
</div>