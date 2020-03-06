<!--=====================================
MODAL EDITAR DIRECTORIO
======================================-->
<div id="modalDirectorio" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
     		<form id="formTrabajador" method="post">
          <div class="overlay overlay-kq hidden">
            <i class="fa fa-refresh fa-spin fa-spin-kq"></i>
          </div>
     			<!--=====================================
        	CABEZA DEL MODAL
        	======================================-->
      		<div class="modal-header modal-header-kq-2">
      			<button type="button" class="close" data-dismiss="modal" style="color: #fff;">&times;</button>
        			<h4 class="modal-title" style="font-weight: bold;" id="modalTituloProducto">Editar trabajador</h4>
      		</div>
        	<!--=====================================
        	CUERPO DEL MODAL
        	======================================-->
      		<div class="modal-body">
      			<div class="box-body">
        			<!-- ENTRADA PARA EL NOMBRE -->
      				<div class="form-group">              
        				<div class="input-group">              
          				<span class="input-group-addon" title="Nombre del trabajador"><i class="fa fa-user"></i></span>
          				<input type="text" class="form-control input-lg" id="nombreTrabajador" name="nombreTrabajador" value="" readonly>
        				</div>
        			</div>
                <!-- ENTRADA PARA EL ANEXO -->
              <div class="form-group">              
                <div class="input-group">              
                  <span class="input-group-addon" title="Anexo"><i class="fa  fa-phone"></i></span>
                  <input type="text" class="form-control input-lg" id="anexoTrabajador" name="anexoTrabajador" value="" placeholder="Anexo">
                </div>
              </div>
              <!-- ENTRADA PARA EL GRUPO SANGUÍNEO -->
              <div class="form-group">              
                <div class="input-group">              
                  <span class="input-group-addon" title="Grupo sanguíneo"><i class="fa fa-object-ungroup"></i></span>
                  <input type="text" class="form-control input-lg" id="grupoSanguineoTrabajador" name="grupoSanguineoTrabajador" value="" placeholder="Grupo sanguíneo">
                </div>
              </div>
              <!-- ENTRADA PARA EL NOMBRE DE CONTACTO DE EMERGENCIA -->
              <div class="form-group">              
                <div class="input-group">
                  <span class="input-group-addon" title="Nombre de contacto de emergencia" ><i class="fa fa-user-md"></i></span>
                  <input type="text" class="form-control input-lg" id="nombreContactoTrabajador" name="nombreContactoTrabajador" value="" placeholder="nombre del contacto de emergencia">
                </div>
              </div>
              <!-- ENTRADA PARA EL TELÉFONO CONTACTO DE EMERGENCIA -->
              <div class="form-group">              
                <div class="input-group">              
                  <span class="input-group-addon" title="Teléfono de emergencia"><i class="fa fa-phone-square"></i></span>
                  <input type="text" class="form-control input-lg" id="telefonoContactoTrabajador" name="telefonoContactoTrabajador" value="" placeholder="Teléfono del contacto de emergencia">
                </div>
              </div>
              <!-- ENTRADA PARA EL USUARIO -->
              <!-- <div class="form-group">              
                <div class="input-group">              
                  <span class="input-group-addon" title="Contraseña"><i class="fa fa-phone-square"></i></span>
                  <input type="text" class="form-control input-lg" id="usuarioContactoTrabajador" name="usuarioContactoTrabajador" value="" placeholder="Ingresar el usuario">
                </div>
              </div> -->
              <!-- ENTRADA PARA EL PASSWORD -->
              <!-- <div class="form-group">              
                <div class="input-group">              
                  <span class="input-group-addon" title="Contraseña"><i class="fa fa-phone-square"></i></span>
                  <input type="text" class="form-control input-lg" id="passwordContactoTrabajador" name="passwordContactoTrabajador" value="" placeholder="Ingresar la contraseña">
                </div>
              </div> -->
          	</div>
            <input type="hidden" id="codigoTrabajador" name="codigoTrabajador" value="">
          </div>
          <!--=====================================
      		PIE DEL MODAL
      		======================================-->
      		<div class="modal-footer">
      			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
      			<button id="guardarDirectorio" type="button" class="btn btn-primary btn-agregar-kq">Guardar</button>
      		</div>            
          <input type="hidden" id="accionTrabajador" name="accionTrabajador">
     		</form>
     	</div>
    </div>
</div>