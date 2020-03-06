<!--=====================================
MODAL POLITICA/PROCEDIMIENTO
======================================-->
<div id="modalPoliticaProcedimiento" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
   		<form enctype="multipart/form-data" role="form" method="post" id="formPoliticaProcedimiento">
        <div class="overlay overlay-kq hidden">
          <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
        </div>
   			<!--=====================================
      	CABEZA DEL MODAL
      	======================================-->
    		<div class="modal-header fondo-modal-header-kq">
    			<button type="button" class="close" data-dismiss="modal">&times;</button>
      		<h4 class="modal-title" style="font-weight: bold;" id="modalTituloPoliticaProcedimiento">Agregar Política/Procedimiento</h4>
    		</div>
    		<!--=====================================
    		CUERPO DEL MODAL
    		======================================-->
    		<div class="modal-body">
    			<div class="box-body">    				
      			<!-- ENTRADA PARA EL TÍTULO -->
    				<div class="form-group">
      				<div class="input-group">              
        				<span class="input-group-addon"><i class="fa fa-user"></i></span>
        				<input type="text" class="form-control input-lg" id="nombrePoliticaProcedimiento" name="nombrePoliticaProcedimiento" placeholder="Ingresar título" required>
      				</div>
      			</div>
            <!-- ENTRADA PARA EL ARCHIVO -->
            <div class="form-group">
              <div class="panel">SUBIR ARCHIVO</div>
              <input type="file" class="archivoPoliticaProcedimiento" name="archivoPoliticaProcedimiento[]" id="archivoPoliticaProcedimiento" multiple="">
            </div>
      		</div>
        </div>
        <!--=====================================
      	PIE DEL MODAL
      	======================================-->
    		<div class="modal-footer">
    			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
    			<button type="submit" class="btn btn-primary btn-agregar-kq">Guardar</button>
    		</div>
        <input type="hidden" id="accionPoliticaProcedimiento" name="accionPoliticaProcedimiento">
        <input type="hidden" id="codigoPoliticaProcedimiento" name="codigoPoliticaProcedimiento">
      </form>
    </div>
  </div>
</div>