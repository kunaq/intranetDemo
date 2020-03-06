<!--=====================================
MODAL AGREGAR CONSULTA FRECUENTE
======================================-->
<div id="modalConsultaFrecuente" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
     		<form enctype="multipart/form-data" role="form" method="post" id="formConsultaFrecuente" >
          <div class="overlay overlay-kq hidden">
            <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
          </div>
     			<!--=====================================
      		CABEZA DEL MODAL
      		======================================-->
      		<div class="modal-header modal-header-kq-2">
      			<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
        			<h4 class="modal-title" style="font-weight: bold;" id="modalTituloConsultaFrecuente">Agregar consulta</h4>
      		</div>
      		<!--=====================================
      		CUERPO DEL MODAL
      		======================================-->
      		<div class="modal-body">
      			<div class="box-body">
      				<!-- ENTRADA PARA LA CONSULTA -->
      				<div class="form-group">          
          				<div class="input-group">          
            				<span class="input-group-addon"><i class="fa fa-cube"></i></span>
            				<textarea class="form-control input-lg" placeholder="Ingresar la consulta" id="nombreConsultaFrecuente" name="nombreConsultaFrecuente" required></textarea>
          				</div>
        			</div>
        			<!-- ENTRADA PARA LA RESPUESTA -->
      				<div class="form-group">          
        				<div class="input-group">          
          				<span class="input-group-addon"><i class="fa fa-book"></i></span>
          				<textarea class="form-control input-lg" placeholder="Ingresar la respuesta" id="respuestaConsultaFrecuente" name="respuestaConsultaFrecuente" required></textarea>
        				</div>
        			</div>
        			<div class="form-group">          
          				<div class="panel">SUBIR ARCHIVO</div>
          				<input type="file" name="archivoConsultaFrecuente" id="archivoConsultaFrecuente">
        			</div>
        		</div>
        	</div>
          <!--=====================================
      		PIE DEL MODAL
      		======================================-->
      		<div class="modal-footer">
      			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
      			<button type="submit" class="btn btn-primary btn-agregar-kq">Guardar consulta</button>
      		</div>
          <input type="hidden" id="accionConsultaFrecuente" name="accionConsultaFrecuente">
          <input type="hidden" id="codigoConsultaFrecuente" name="codigoConsultaFrecuente">
          <input type="hidden" id="archivoOriginalConsultaFrecuente" name="archivoOriginalConsultaFrecuente">
        </form>
      </div>
    </div>
</div>