<div id="modalNoticia" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
   		<form enctype="multipart/form-data" role="form" method="post" id="formNoticia">
        <div class="overlay overlay-kq hidden">
          <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
        </div>
   			<!--=====================================
    		CABEZA DEL MODAL
    		======================================-->
    		<div class="modal-header" style="background:#FBBA00 repeat scroll 0 0; color:#013976;">
    			<button type="button" class="close" data-dismiss="modal">&times;</button>
      			<h4 class="modal-title" style="font-weight: bold;" id="btnAgregarNoticia">Agregar Noticia</h4>
    		</div>
    		<!--=====================================
    		CUERPO DEL MODAL
    		======================================-->
    		<div class="modal-body">
    			<div class="box-body">
      			<!-- ENTRADA PARA EL AUTOR -->
    				<div class="form-group">
      				<div class="input-group">              
        				<span class="input-group-addon" title="Usuario"><i class="fa fa-user"></i></span>
        				<input type="text" class="form-control input-lg" id="autorNoticia" name="autorNoticia" value="<?php echo $_SESSION["nombres"]." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"]; ?>" readonly>
      				</div>
      			</div>
      			<!-- ENTRADA PARA LA FECHA -->
    				<div class="form-group">
      				<div class="input-group">              
        				<span class="input-group-addon" title="Fecha de publicación"><i class="fa fa-calendar"></i></span>
        				<input type="text" class="form-control input-lg" id="fechaPublicacionNoticia" name="fechaPublicacionNoticia" placeholder="Ingresar fecha de publicación" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required value="<?php echo date('d-m-Y'); ?>">
      				</div>
      			</div>
      			<!-- ENTRADA PARA EL TÍTULO -->
    				<div class="form-group">
      				<div class="input-group">              
        				<span class="input-group-addon" title="Título"><i class="fa fa-certificate"></i></span>
        				<input type="text" class="form-control input-lg" id="tituloNoticia" name="tituloNoticia" placeholder="Ingresar título" required>
      				</div>
      			</div>
      			<!-- ENTRADA PARA EL RESUMEN -->
    				<div class="form-group">
      				<div class="input-group">              
        				<span class="input-group-addon" title="Resumen"><i class="fa fa-book"></i></span> 
        				<textarea class="form-control input-lg" id="resumenNoticia" name="resumenNoticia" placeholder="Ingresar el resumen" required></textarea>
      				</div>
      			</div>
      			<!-- ENTRADA PARA SELECCIONAR SUBIR FOTO -->
      			<div class="form-group">
      		    <div class="panel">SUBIR FOTO</div>							
			        <input type="file" class="imagenNoticia" name="imagenNoticia" id="imagenNoticia">
				      <!-- <a class="help-block">Peso máximo de la foto 200 MB</a> -->
        	    <img src="views/img/users/default-50x50.gif" class="img-thumbnail previsualizarNoticia" width="100px">
              <!-- Sino modificamos la imagen, seria buena guardar la imagen actual en un hidden -->
              <input type="hidden" class="imagenActualNoticia" name="imagenActualNoticia" id="imagenActualNoticia">
      			</div>
    			</div>
      	</div>
      	<!--=====================================
    		PIE DEL MODAL
    		======================================-->
    		<div class="modal-footer">
    		  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
    			<button type="submit" class="btn btn-primary btn-agregar-kq">Guardar noticia</button>
    		</div>
        <input type="hidden" id="accionNoticia" name="accionNoticia">
        <input type="hidden" id="codigoNoticia" name="codigoNoticia">
   		</form>
    </div>		
	</div>
</div>