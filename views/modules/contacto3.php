<?php
if(isset($_GET["codigo"]) && $_GET["codigo"] != ''){
	$item = "cod_contacto";
	$valor = $_GET["codigo"];
	$contacto = ControladorContacto::ctrMostrarContacto($item,$valor);
	$accion = "editar";
}else{
	$accion = "crear";
}
?>
<div class="content-wrapper fondo-content-wrapper-kq-2">
	<section class="content-header">
	    <h1 class="page-header color-h3-kq" id="tituloContacto">
	      Crear contacto
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
	      <li><a href="contactos"><i class="fa fa-dashboard"></i> Contactos</a></li>
	      <li class="active" id="liContacto">Crear contacto</li>
	    </ol>
	</section>
	<section class="content">
		<!--=====================================
  		EL FORMULARIO
  		======================================-->
		<form enctype="multipart/form-data" class="form-horizontal formularioContacto" id="formContacto" method="post">
  			<div class="box" style="border-top: 3px solid #d1d1d1;">
  				<!-- <div class="overlay overlay-kq">
					<i class="fa fa-refresh fa-spin fa-spin-kq"></i>
				</div> -->
				<!--=====================================
		        BOX DATOS DEL CONTACTO
		        ======================================-->
      			<div class="box-header border-buttom-cotizacion">
      				<h3 class="box-title" style="font-weight: bold">Datos del contacto</h3>
      			</div>
        		<div class="box-body">
        			<div class="row">
			        	<div class="form-group col-md-5">
        					<label for="" class="col-md-3 control-label">Fecha de registro:</label>
		                    <div class="col-md-9" style="padding-top: 7px;">
		                    	<div class="input-group date">
	                  				<div class="input-group-addon">
	                    				<i class="fa fa-calendar"></i>
	                  				</div>
	                  				<input type="text" class="form-control pull-right" id="datepicker" name="fechaAtencionContacto" value=" <?php echo isset($contacto) ? dateFormat($contacto['fch_atencion']) : date('d-m-Y'); ?>">
	                			</div>
		                    </div>
		                </div>
			        	<!--=====================================
		                ENTRADA PARA EL TRABAJADOR
		                ======================================-->
						<div class="form-group col-md-5">
							<label class="col-md-3 control-label">Usuario registro:</label>
							<div class="col-md-9" style="padding-top: 7px;">
				                <input type="text" class="form-control" value="<?php echo $_SESSION["nombres"]." ".$_SESSION["apellido_paterno"]; ?>" readonly>
							</div>
						</div>
					</div>
        			<div class="row">
		            	<!--=====================================
		                ENTRADA PARA EL CLIENTE
		                ======================================-->
						<div class="form-group col-md-5">
				            <label class="col-md-3 control-label">Cliente:</label>
							<div class="col-md-7" style="width: 73% !important; padding-right: 5px;">
				                <select class="form-control select2" id="clienteContacto" name="clienteContacto" style="width: 100%;" required>
				                	<option selected disabled value="">Selecciona un cliente</option>
				                	<?php
				                	$item = null;
				                	$valor = null;
				                	$entrada = null;
        							$clientes = ControladorClientes::ctrMostrarClientes($item,$valor,$entrada);
        							foreach ($clientes as $key => $value) {
        								echo '<option value="'.$value["cod_cliente"].'">'.$value["dsc_razon_social"].'</option>';
        							}
        							?>
				                </select>
				                <input type="hidden" id="codClienteContacto" value="<?php echo isset($contacto) ? $contacto['cod_cliente'] : ''; ?>">
							</div>
							<!-- <div class="col-md-1" style="padding-left: 0px;">
								<button type="button" class="btn btn-primary btn-agregar2-kq btnAgregarCliente" data-toggle="modal" data-target="#modalCliente" data-dismiss="modal" title="Agregar Cliente"><i class="fa fa-plus"></i></button>
							</div> -->
			            </div>
			            <!--=====================================
		                ENTRADA PARA EL CANAL
		                ======================================-->
						<div class="form-group col-md-5">
							<label class="col-md-3 control-label">Canal:</label>
							<div class="col-md-9">
				                <select class="form-control" name="canalContacto" id="canalContacto" style="width: 100%;" required>
				                	<option selected disabled value="">Selecciona un canal</option>
									<?php
				                	$item = null;
				                	$valor = null;
				                	$canal = ControladorCanalContacto::ctrMostrarCanalContacto($item,$valor);
        							foreach ($canal as $key => $value) {
        								echo '<option value="'.$value["cod_canal_contacto"].'">'.$value["dsc_canal_contacto"].'</option>';
        							}
				                	?>
				                </select>
				                <input type="hidden" id="codCanalContacto" value="<?php echo isset($contacto) ? $contacto['cod_canal'] : ''; ?>">
							</div>
						</div>
			        </div>
			        <div class="row">
			        	<!--=====================================
		                ENTRADA PARA EL TIPO
		                ======================================-->
						<div class="form-group col-md-5">
							<label class="col-md-3 control-label">Tipo de contacto:</label>
							<div class="col-md-9" style="padding-top: 7px;">
				                <select class="form-control" name="tipoContacto" id="tipoContacto" style="width: 100%;" required>
				                	<option selected disabled value="">Selecciona un tipo de contacto</option>
				                	<?php
				                	$item = null;
				                	$valor = null;
				                	$tipo = ControladorTipoContacto::ctrMostrarTipoContacto($item,$valor);
        							foreach ($tipo as $key => $value) {
        								echo '<option value="'.$value["cod_tipo_contacto"].'|'.$value["flg_informe"].'">'.$value["dsc_tipo_contacto"].'</option>';
        							}
        							?>
				                </select>
				                <input type="hidden" id="codTipoContacto" value="<?php echo isset($contacto) ? $contacto['cod_tipo'].'|'.$contacto['flg_informe'] : ''; ?>">
							</div>
						</div>
						<!--=====================================
		                ENTRADA PARA EL ESTADO
		                ======================================-->
						<div class="form-group col-md-5">
							<label class="col-md-3 control-label" style="padding-top: 14px;">Estado:</label>
							<div class="col-md-9" style="padding-top: 7px;">
				                <select class="form-control" name="estadoContacto" id="estadoContacto" style="width: 100%;" required>
				                	<option  disabled>Selecciona un estado</option>
				                	<?php
				                	$item = null;
				                	$valor = null;
				                	$estado = ControladorEstadoContacto::ctrMostrarEstadoContacto($item,$valor);
        							foreach ($estado as $key => $value) {
        								echo '<option value="'.$value["cod_estado_contacto"].'">'.$value["dsc_estado_contacto"].'</option>';
        							}
        							?>
				                </select>
				                <input type="hidden" id="codEstadoContacto" value="<?php echo isset($contacto) ? $contacto['cod_estado'] : ''; ?>">
							</div>
						</div>
			        </div>
			        <div class="row">
		            	<!--=====================================
			            ENTRADA PARA LA REFERENCIA
			            ======================================-->
			            <div class="form-group col-md-12">
							<label class="col-md-2 control-label" style="width: 8.2%;">Detalle contacto:</label>
							<div class="col-md-10" style="width: 89%;">
				                <textarea id="detalleAtencionContacto" name="detalleAtencionContacto" class="form-control" placeholder="Ingrese el detalle del contacto"><?php echo isset($contacto) ? $contacto["dsc_detalle_atencion"] : '' ?></textarea>
							</div>
			            </div>
		            </div>
				</div>
				<!--=====================================
			    BOX DATOS DE LA ATENCION
			    ======================================-->
			    <div class="box-header border-buttom-cotizacion">
      				<h3 class="box-title" style="font-weight: bold">Datos de la atención</h3>
      			</div>
      			<div class="box-body">
      				<div class="row">
			        	<div class="form-group col-md-6">
        					<label for="" class="col-md-2 control-label">Fecha de atención:</label>
		                    <div class="col-md-10" style="padding-top: 7px;">
		                    	<div class="input-group date">
	                  				<div class="input-group-addon">
	                    				<i class="fa fa-calendar"></i>
	                  				</div>
	                  				<input type="text" class="form-control pull-right" id="datepicker" name="fechaAtencionContacto" value=" <?php echo isset($contacto) ? dateFormat($contacto['fch_atencion']) : date('d-m-Y'); ?>">
	                			</div>
		                    </div>
		                </div>
			        	<!--=====================================
		                ENTRADA PARA EL TRABAJADOR
		                ======================================-->
						<div class="form-group col-md-6">
							<label class="col-md-2 control-label">Trabajador Atención:</label>
							<div class="col-md-10" style="padding-top: 7px;">
				                <select class="form-control select2" name="trabajadorAtencionContacto" id="trabajadorAtencionContacto" style="width: 100%;" required>
			                		<option selected disabled value="">Selecciona un trabajador</option>
				                	<?php
				                	$item = null;
				                	$valor = null;
				                	$entrada = "modalContacto";
				                	$trabajador = ControladorTrabajador::ctrMostrarTrabajador($item,$valor,$entrada);
	    							foreach ($trabajador as $key => $value) {
	    								echo '<option value="'.$value["cod_trabajador"].'">'.$value["dsc_nombres"]." ".$value["dsc_apellido_paterno"]." ".$value["dsc_apellido_materno"].'</option>';
	    							}
	    							?>
	    						</select>
	    						<input type="hidden" id="codTrabajadorAtencionContacto" value="<?php echo isset($contacto) ? $contacto['cod_trabajador_atencion'] : ''; ?>">
							</div>
						</div>
					</div>
					<div class="row">
		            	<!--=====================================
			            ENTRADA PARA LA REFERENCIA
			            ======================================-->
			            <div class="form-group col-md-12">
							<label class="col-md-2 control-label" style="width: 8.2%;">Detalle Atención:</label>
							<div class="col-md-10" style="width: 89%;">
				                <textarea id="detalleAtencionContacto" name="detalleAtencionContacto" class="form-control" placeholder="Ingrese el detalle de la atención"><?php echo isset($contacto) ? $contacto["dsc_detalle_atencion"] : '' ?></textarea>
							</div>
			            </div>
		            </div>
      			</div>
				<!--=====================================
			    BOX DETALLE
			    ======================================-->
		        <div class="box-header boxHeaderContacto with-border border-buttom-cotizacion hidden" style="border-bottom: 2px solid #d1d1d1;">
		        	<h3 class="box-title" style="font-weight: bold">Tabla</h3>
      			</div>
      			<div class="box-body boxDetalleInformeContacto hidden">
					<div class="row">
						<div class="col-lg-6">
							<button type="button" class="btn btn-primary btn-agregar2-kq agregarFilaContacto" style="display: block;"><span>+</span> Agregar Item</button>
						</div>
					</div><br>
					<div class="row">
		            	<div class="col-md-12">
			            	<table class="table table-striped tablaContacto table-bordered">
			            		<thead style="background-color: #d1d1d1;">
			            			<tr style="width: 100%">
			            				<th style="width: 5%;" class="text-center">Informe</th>
			            				<th style="width: 9.5%;" class="text-center">Fecha</th>
			            				<th style="width: 8%;" class="text-center">Actividad</th>
			            				<th style="width: 8%;" class="text-center">Lugar</th>
			            				<th style="width: 8%;" class="text-center">Participantes cliente</th>
			            				<th style="width: 8%;" class="text-center">Participantes indelat</th>
			            				<th style="width: 8%;" class="text-center">Acuerdo</th>
			            				<th style="width: 8%;" class="text-center">Objetivo</th>
			            				<th style="width: 8%;" class="text-center">Responsable indelat</th>
			            				<th style="width: 9.5%;" class="text-center">Fecha programada</th>
			            				<th style="width: 8%;" class="text-center">Status</th>
			            				<th style="width: 8%;" class="text-center">Área del informe</th>
			            				<th style="width: 4%;"></th>
			            			</tr>
			            		</thead>
			            		<tbody></tbody>
			            	</table>
			            </div>
			        </div>
				</div>

				<div class="box-footer text-right">
     				<button id="guardarContacto" type="submit" class="btn btn-primary btn-agregar2-kq">Guardar Contacto</button>
    			</div>
            	<input type="hidden" id="accionContacto" name="accionContacto" value="<?php echo $accion; ?>">
            	<input type="hidden" id="codigoContacto" name="codigoContacto" value="<?php echo isset($contacto) ? $contacto['cod_contacto'] : ''; ?>">
			</div>
		</form>
	</section>
</div>
<?php
include "modals/cliente.modal.php";
?>