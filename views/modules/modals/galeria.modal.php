<div id="modalGaleria" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
   		<form role="form" method="post" id="formGaleria">
        <div class="overlay overlay-kq hidden">
          <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
        </div>
   			<!--=====================================
      	CABEZA DEL MODAL
      	======================================-->
    		<div class="modal-header fondo-modal-header-kq">
    			<button type="button" class="close" data-dismiss="modal">&times;</button>
      			<h4 class="modal-title" style="font-weight: bold;" id="modalTituloGaleria">Agregar Galería</h4>
    		</div>
    		<!--=====================================
    		CUERPO DEL MODAL
    		======================================-->
    		<div class="modal-body">
    			<div class="box-body">
      			<!-- ENTRADA PARA EL TÍTULO -->
    				<div class="form-group">              
        				<div class="input-group">              
          				<span class="input-group-addon" title="Nombre"><i class="fa fa-th"></i></span>
          				<input type="text" class="form-control input-lg" id="nombreGaleria" name="nombreGaleria" placeholder="Ingresar galería" required autofocus>
        				</div>
      			</div>
      		</div>
        </div>
        <!--=====================================
      	PIE DEL MODAL
      	======================================-->
    		<div class="modal-footer">
    			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
    			<button type="submit" class="btn btn-primary btn-agregar-kq">Guardar galería</button>
    		</div>
        <input type="hidden" id="accionGaleria" name="accionGaleria">
        <input type="hidden" id="codigoGaleria" name="codigoGaleria">
      </form>
    </div>
  </div>
</div>