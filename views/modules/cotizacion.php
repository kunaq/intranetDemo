<?php
if(!isset($_SESSION["iniciarSesionIntranet"]) &&  $_SESSION["iniciarSesionIntranet"] != "ok"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
if($_SESSION["flgCotizacion"] == 'SI' && $_SESSION["flgCotizacionCrear"] == 'SI'){
?>
<div class="content-wrapper fondo-content-wrapper-kq-2">
	<section class="content-header">    
	    <h1 class="page-header color-h2-kq" id="tituloCotizacion">	      
	      Crear cotización	    
	    </h1>
	    <ol class="breadcrumb">	      
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
	      <li><a href="cotizaciones"><i class="fa fa-dashboard"></i> Cotizaciones</a></li>	      
	      <li class="active" id="liCotizacion">Crear cotización</li>	    
	    </ol>
	</section>
	<section class="content">
		<!--=====================================
  		EL FORMULARIO
  		======================================-->
		<form enctype="multipart/form-data" class="form-horizontal formularioCotizacion" id="formCotizacion" method="post">
  			<div class="box" style="border-top: 3px solid #d1d1d1;">
  				<div class="overlay overlay-kq">
					<i class="fa fa-refresh fa-spin fa-spin-kq"></i>
				</div>
				<?php
				$disabled = '';
				$entradaCtz = 'formularioPrincipal';
				if(isset($_GET["codigo"]) && $_GET["codigo"] != ''){
					$item = "cod_cotizacion";
					$valor1 = $_GET["codigo"];
					$valor2 = $valor3 = $valor4 = $valor5 = null;
					$entrada = 'formularioPrincipal';
					$cotizacion = ControladorCotizacion::ctrMostrarCotizacion($valor1,$valor2,$valor3,$valor4,$valor5,$entrada);
					$cotizacionAdjuntos = ControladorCotizacion::ctrMostrarCotizacionDatosAdjuntos($item,$valor1);
					$fullDireccion = $cotizacion["dsc_direccion"].' - '.$cotizacion["dsc_distrito"].' - '.$cotizacion["dsc_provincia"].' - '.$cotizacion["dsc_departamento"].' - '.$cotizacion["dsc_pais"];					
					$fchEmisionOC = ($cotizacion['fchEmision_orden_compra'] != '') ? dateFormat($cotizacion['fchEmision_orden_compra']) : '';
					if(isset($_GET["accion"]) && $_GET["accion"] == 'clonar'){
						$accion = "clonar";
						$codigoCotizacion = '';
						$fchEmision = date('d-m-Y');
					}else{
						$accion = "editar";
						$codigoCotizacion = $cotizacion["cod_cotizacion"];
						$fchEmision = dateFormat($cotizacion['fch_emision']);
						$disabled = ($cotizacion["flg_aprobado"] == 'SI') ? 'disabled' : '';
						$entradaCtz = ($cotizacion["flg_aprobado"] == 'SI') ? 'estadoAprobado' : 'formularioPrincipal';
					}
					$flgPeru = $cotizacion["flg_peru"];
				}else{
					$accion = "crear";
					$flgPeru = 'SI';
				}
				?>
  				<!--=====================================
		        BOX DATOS GENERALES
		        ======================================-->
      			<div class="box-header border-buttom-cotizacion">
      				<h3 class="box-title" style="font-weight: bold">Datos generales</h3>            
      			</div>
        		<div class="box-body">
    				<div class="row">
		                <!--=====================================
		                ENTRADA PARA EL CÓDIGO
		                ======================================-->
		                <div class="form-group col-md-6">
        					<label class="col-md-2 control-label">Código:</label>
		                    <div class="col-md-10">
		                    	<?php
		                    	// COMPROBAR SI EXISTE VERSIONES DE LA COTIZACION
		                    	if(isset($cotizacion) && $accion != 'clonar'){
		                    		$itemVrs = "cod_cotizacion_principal";
		                    		$valorVrs = $cotizacion["cod_cotizacion"];
		                    		$contVersion = ModeloCotizacion::mdlVerificarVersionCot($itemVrs,$valorVrs);
		                    		$bloqueo = ($contVersion["contadorVrs"] > 0) ? "readonly" : "";	
		                    	}else{
		                    		$bloqueo = 'readonly';
		                    	}
		                    	?>
		                    	<input type="text" class="form-control" id="codigoCotizacion" name="codigoCotizacion" value="<?php echo isset($cotizacion) ? $codigoCotizacion : ''; ?>" <?php echo $bloqueo; echo $disabled; ?>  />
		                    	<input type="hidden" id="codigoCotizacionOriginal" name="codigoCotizacionOriginal" value="<?php echo isset($cotizacion) ? $cotizacion["cod_cotizacion"] : ''; ?>" />
		                    </div>
		            	</div>
		            	<!--=====================================
		                OBTENER ESTADO POR DEFECTO
		                ======================================-->
		                <?php
		                $item = "flg_pendiente";
		                $valor = "SI";
		                $entradaEstCtz = null;
		                $estadoCotizacion = ControladorEstadoCotizacion::ctrMostrarEstadoCotizacion($item,$valor,$entradaEstCtz);
		                echo '<input type="hidden" name="estadoCotizacion" value="'.$estadoCotizacion["cod_estado_cotizacion"].'">';
		                ?>
		            	<!--=====================================
		                ENTRADA LA FECHA DE EMISIÓN
		                ======================================-->
		                <div class="form-group col-md-6">
        					<label for="" class="col-md-2 control-label">Fecha de emisión:</label>
		                    <div class="col-md-5">
		                    	<div class="input-group date">
	                  				<div class="input-group-addon">
	                    				<i class="fa fa-calendar"></i>
	                  				</div>
	                  				<input type="text" class="form-control pull-right" id="datepicker" value="<?php echo isset($cotizacion) ? $fchEmision : date('d-m-Y'); ?>" name="fechaEmisionCotizacion" <?php echo $disabled; ?> />
	                			</div>		                			 
		                    </div>
		                    <!--=====================================
			                ENTRADA PARA EL ESTADO
			                ======================================-->
		                    <div class="col-md-5">
								<div class="input-group">
									<?php
									if(isset($cotizacion)){
										echo '<span id="span-title-estado" class="input-group-addon" title="">
												<i class="fa fa-thumb-tack"></i>
											</span>';
										$item = null;
										$valor = null;
										$entradaEstCtz = null;
										$estadoCotizacion = ControladorEstadoCotizacion::ctrMostrarEstadoCotizacion($item,$valor,$entradaEstCtz);
										echo '<select class="form-control" id="estadoCotizacion" name="estadoCotizacion" '.$disabled.' >
												<option value="">Seleccione un estado</option>';
											foreach ($estadoCotizacion as $key => $value) {
												echo '<i class="fa fa-thumb-tack"></i>';
												echo '<option value="'.$value["cod_estado_cotizacion"].'">'.$value["dsc_estado_cotizacion"].'</option>';
											}
										echo '</select>';
										echo '<input type="hidden" id="codEstadoCotizacion" value="'.$cotizacion["cod_estado_cotizacion"].'">';
									}else{
										$item = "flg_pendiente";
						                $valor = "SI";
						                $entradaEstCtz = null;
						                $estadoCotizacion = ControladorEstadoCotizacion::ctrMostrarEstadoCotizacion($item,$valor,$entradaEstCtz);
						                echo '<span class="input-group-addon" title="'.$estadoCotizacion["dsc_detalle"].'"><i class="fa fa-thumb-tack"></i></span>';
										echo '<select class="form-control" id="estadoCotizacion" name="estadoCotizacion" readonly>
												<option disabled>Seleccione un estado</option>
												<option selected value="'.$estadoCotizacion["cod_estado_cotizacion"].'">'.$estadoCotizacion["dsc_estado_cotizacion"].'</option>
											  </select>';
									}//else
									?>
		                    	</div>
		                    </div>
		            	</div>
		            </div>
		            <div class="row">
		            	<!--=====================================
		                ENTRADA PARA EL CLIENTE
		                ======================================-->
						<div class="form-group col-md-6">	            
				            <label class="col-md-2 control-label">*Cliente:</label>								
							<div class="col-md-8"  style="width: 73% !important; padding-right: 5px;">
				                <select class="form-control select2" id="clienteCotizacion" name="clienteCotizacion" style="width: 100%;" required <?php echo $disabled; ?>>
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
							</div>
							<div class="col-md-1" style="padding-left: 0px;">
								<button type="button" class="btn btn-primary btn-agregar-kq btnAgregarCliente" data-toggle="modal" data-target="#modalCliente" data-dismiss="modal" title="Agregar Cliente" <?php echo $disabled; ?>><i class="fa fa-plus"></i></button>
								
							</div>
							<input type="hidden" id="codClienteCotizacion" value="<?php echo isset($cotizacion) ? $cotizacion["cod_cliente"] : ''; ?>">
			            </div>
			            <!--=====================================
		                ENTRADA PARA EL CONTACTO
		                ======================================-->
		            	<div class="form-group col-md-6 ">
		            		<div>
		            			<label class="col-md-2 control-label">Contacto:</label>
			                    <div class="col-md-10">
			                    	<input type="text" class="form-control" id="contactoCotizacion" name="contactoCotizacion" value="<?php echo isset($cotizacion) ? htmlspecialchars($cotizacion['dsc_contacto']) : ''; ?>" <?php echo $disabled; ?>>
			                    </div>
		            		</div>
		            	</div>
		            </div>
		            <div class="row">
		            	<!--=====================================
		                ENTRADA PARA EL RUC
		                ======================================-->
		            	<div class="form-group col-md-6 ">
	            			<label for="" class="col-md-2 control-label">RUC:</label>
		                    <div class="col-md-10">
		                    	<input type="text" class="form-control" id="rucClienteCotizacion" value="<?php echo isset($cotizacion) ? $cotizacion['dsc_documento'] : ''; ?>" readonly />  
		                    </div>
		            	</div>
		            	<!--=====================================
		                ENTRADA PARA EL CORREO
		                ======================================-->
		                <div class="form-group col-md-6">
        					<label for="" class="col-md-2 control-label">Correo:</label>
		                    <div class="col-md-10">
		                    	<input type="email" class="form-control" name="correoCotizacion" value="<?php echo isset($cotizacion) ? $cotizacion['dsc_correo'] : ''; ?>" <?php echo $disabled; ?> />  
		                    </div>
		            	</div>
		            </div>
		            <div class="row">
		            	<!--=====================================
		                ENTRADA PARA LA DIRECCIÓN
		                ======================================-->
		            	<div class="form-group col-md-6 ">
	            			<label for="" class="col-md-2 control-label">Dirección:</label>
		                    <div class="col-md-10">
		                    	<textarea class="form-control" style="height: 84px;" readonly id="direccionClienteCotizacion"><?php echo isset($cotizacion) ? $fullDireccion : ''; ?></textarea>
		                    </div>
		            	</div>
		            	<!--=====================================
		                ENTRADA PARA EL CARGO
		                ======================================-->
		                <div class="form-group col-md-6">
        					<label for="" class="col-md-2 control-label">Cargo:</label>
		                    <div class="col-md-10">
		                    	<input type="text" class="form-control" name="cargoCotizacion" value="<?php echo isset($cotizacion) ? htmlspecialchars($cotizacion['dsc_cargo']) : ''; ?>" <?php echo $disabled; ?> />  
		                    </div>
		            	</div>
		            	<!--=====================================
		                ENTRADA PARA EL TELÉFONO
		                ======================================-->
		            	<div class="form-group col-md-6">
        					<label for="" class="col-md-2 control-label">Teléfono:</label>
		                    <div class="col-md-10">
		                    	<input type="text" class="form-control" name="telefonoCotizacion" value="<?php echo isset($cotizacion) ? htmlspecialchars($cotizacion['dsc_telefono']) : ''; ?>" <?php echo $disabled; ?> />  
		                    </div>
		            	</div>
		            </div>
		            <div class="row">
		                <div class="form-group col-md-6">
		                	<label for="fchEmsOrdCmpCotizacion" class="col-md-2 control-label" title="Fecha de emisión de Orden de Compra">F.Emisión OC:</label>
		                    <div class="col-md-10">
		                    	<div class="input-group date">
	                  				<div class="input-group-addon">
	                    				<i class="fa fa-calendar"></i>
	                  				</div>
	                  				<input type="text" class="form-control inputFecha" name="fchEmsOrdCmpCotizacion" id="fchEmsOrdCmpCotizacion" value="<?php echo isset($cotizacion) ? $fchEmisionOC : ''; ?>" <?php echo $disabled; ?> />  
	                			</div>		                			 
		                    </div>
		            	</div>
		            	<div class="form-group col-md-6">
	            			<label for="ordenCompraCotizacion" class="col-md-2 control-label" title="Número de Orden de Compra">Número OC:</label>
		                    <div class="col-md-10" style="padding-top: 7px;">
		                    	<input type="text" class="form-control" name="ordenCompraCotizacion" id="ordenCompraCotizacion" value="<?php echo isset($cotizacion) ? $cotizacion['dsc_orden_compra'] : ''; ?>" <?php echo $disabled; ?> />  
		                    </div>
		            	</div>		            	
		            </div>
		            <div class="row">
		            	<div class="form-group col-md-6">
	            			<label for="" class="col-md-2 control-label">Orden de producción:</label>
		                    <div class="col-md-10" style="padding-top: 7px;">
		                    	<input type="text" class="form-control" id="nroOrdenProdCtzn" name="nroOrdenProdCtzn" value="<?php echo isset($cotizacion) ? $cotizacion['num_orden_produccion'] : ''; ?>" />
		                    </div>
		            	</div>
		            </div>
		            <div class="row">
		            	<!--=====================================
			            ENTRADA PARA LA REFERENCIA
			            ======================================-->
			            <div class="form-group col-md-12">
				            <label class="col-md-2 control-label" style="width: 86.58px;">*Referencia:</label>
							<div class="col-md-10" style="width: 89% !important;">
				                <textarea class="form-control" name="referenciaCotizacion" required <?php echo $disabled; ?>><?php echo isset($cotizacion) ? htmlspecialchars($cotizacion['dsc_referencia']) : ''; ?></textarea>
							</div>
			            </div>			            	
		            </div>
		        </div>
		        <!--=====================================
			    BOX DETALLE
			    ======================================-->
		        <div class="box-header with-border border-buttom-cotizacion" style="border-bottom: 2px solid #d1d1d1;">
      				<h3 class="box-title" style="font-weight: bold">Detalle</h3>        
      			</div>
      			<input type="hidden" id="listaProductosCotizacion" name="listaProductosCotizacion">
      			<input type="hidden" id="listaNuevoProductoCotizacion" name="listaNuevoProductoCotizacion">
      			<input type="hidden" id="listaOrginalProductoCotizacion" name="listaOrginalProductoCotizacion">
				<div class="box-body boxDetalleCotizacion">
					<div class="row">
						<div class="col-lg-6">
							<button type="button" class="btn btn-primary btn-agregar-kq agregarFilaCotizacion" style="display: block;" <?php echo $disabled; ?>><span>+</span> Agregar Item</button>	
						</div>
						<div class="col-lg-6">							
							<label class="col-md-4 control-label">Descuento:</label>
							<div class="col-md-8">
				                <div class="input-group">
				                	<select class="form-control" id="selectDescuentoCotizacion" name="selectDescuentoCotizacion" style="width: 156px; background: #f7f3f3;" title="Seleccione un tipo de descuento" <?php echo $disabled; ?>>
				                		<option selected disabled value="">Tipo de descuento</option>
					                	<?php
					                	$item = null;
					                	$valor = null;
	                                    $tipoDescuento = ControladorTipoDescuento::ctrMostrarTipoDescuento($item,$valor);
	                                    foreach ($tipoDescuento as $key => $value) {
	                                        echo '<option value="'.$value["cod_tipo_descuento"].'">'.$value["dsc_tipo_descuento"].'</option>';
	                                    }
	                                    ?>
					                </select>
					                <input type="hidden" id="codTipoDescuentoCotizacion" value="<?php echo isset($cotizacion) ? trim($cotizacion['cod_tipo_descuento']) : ''; ?>">
			                        <span class="input-group-addon">
			                          <input class="vertical-middle-kq" type="checkbox" id="checkTotalDescuentoCotizacion" title="Debe seleccionar un tipo de descuento para que se active esta opción 'Descuentos a todos los productos'" disabled>
			                        </span>
				                    <input type="text" class="form-control text-right" id="totalDescuentoCotizacion" name="totalDescuentoCotizacion" placeholder="0.00" <?php echo $disabled; ?> />
				                    <input type="hidden" id="impDescuentoCotizacion" value="<?php echo isset($cotizacion) ? $cotizacion['imp_descuento'] : ''; ?>">
				                    <input type="hidden" id="valorCheckTotalDescuentoCotizacion" name="valorCheckTotalDescuentoCotizacion" value="<?php echo isset($cotizacion) ? $cotizacion['flg_descuento'] : 'NO'; ?>">
				                </div>
				            </div>
						</div>						
					</div>
		            <br>
		            <div class="overlay-kq-2 hidden">
						<i class="fa fa-refresh fa-spin fa-spin-kq"></i>
					</div>
		            <div class="row">
		            	<div class="col-md-12">							
			            	<table class="table table-striped tablaCotizacion table-bordered tablaScroll">
			            		<thead style="background-color: #d1d1d1;">
			            			<tr style="width: 100%; background-color: #fff;">
			            				<th style="width: 3%;" class="th-cabecera"></th>
			            				<th style="width: 26.5%;" class="text-center th-cabecera"></th>
			            				<th style="width: 7.5%;" class="text-center th-cabecera"></th>
			            				<th style="width: 10%;" class="text-center th-cabecera"></th>
			            				<th style="width: 9.5%;" class="text-center th-cabecera"></th>
			            				<th style="width: 6%;" class="text-center th-descuentos"></th>
			            				<th style="width: 8.5%; padding-left: 22px;" class="text-center th-descuentos">Descuentos</th>
			            				<th style="width: 8.5%" class="text-center th-descuentos"></th>
			            				<th style="width: 9.5%;" class="text-center th-cabecera"></th>
			            				<th style="width: 5%;" class="text-center th-cabecera"></th>
			            				<th style="width: 6%;"></th>
			            			</tr>			            			
			            			<tr style="width: 100%">
			            				<th style="width: 3%;" ></th>
			            				<th style="width: 26.5%;" class="text-center">Descripción</th>
			            				<th style="width: 7.5%;" class="text-center">Cantidad</th>
			            				<th style="width: 10%;" class="text-center">Unid. Med.</th>
			            				<th style="width: 9.5%;" class="text-center">P. Unitario</th>
			            				<th style="width: 6%;" class="text-center th-descuentos-2">Por %</th>
			            				<th style="width: 8.5%" class="text-center th-descuentos-2">Valor</th>
			            				<th style="width: 8.5%" class="text-center th-descuentos-2">Final</th>
			            				<th style="width: 9.5%;" class="text-center">P. Total</th>
			            				<th style="width: 5%;" class="text-center">Obs.</th>
			            				<th style="width: 6%;"></th>
			            			</tr>
			            		</thead>								
			            		<tbody></tbody>
			            		<tfoot>			            			
			            			<tr>
										<th style="width: 3%;"></th>
			            				<th style="width: 26.5%;"></th>
			            				<th style="width: 7.5%;"></th>
			            				<th style="width: 10%;"></th>
			            				<th style="width: 9.5%;"></th>
			            				<th style="width: 6%;"></th>
			            				<th style="width: 8.5%"></th>
			            				<th style="width: 8.5%;" class="text-center vertical-middle-kq" >Subtotal:</th>
			            				<td style="width: 9.5%;"><input type="text" class="form-control text-right" id="subTotalCotizacion" name="subTotalCotizacion" value="<?php echo isset($cotizacion) ? $cotizacion['imp_subtotal'] : ''; ?>" readonly></td>
			            				<td style="width: 5%;"></td>
			            				<td style="width: 6%;"></td>
			            			</tr>
			            			<tr>
			            				<th style="width: 3%;"></th>
			            				<th style="width: 26.5%;"></th>
			            				<th style="width: 7.5%;"></th>
			            				<th style="width: 10%;"></th>
			            				<th style="width: 9.5%;"></th>
			            				<th style="width: 6%;"></th>
			            				<th style="width: 8.5%"></th>
			            				<th style="width: 8.5%;" class="text-center vertical-middle-kq">IGV:</th>
			            				<td style="width: 9.5%;"><input type="text" class="form-control text-right" id="igvCotizacion" name="igvCotizacion" value="<?php echo isset($cotizacion) ? $cotizacion['imp_igv'] : ''; ?>" readonly></td>
			            				<td style="width: 5%;"></td>
			            				<td style="width: 6%;"></td>
			            			</tr>
			            			<tr>
			            				<th style="width: 3%;"></th>
			            				<th style="width: 26.5%;"></th>
			            				<th style="width: 7.5%;"></th>
			            				<th style="width: 10%;"></th>
			            				<th style="width: 9.5%;"></th>
			            				<th style="width: 6%;"></th>
			            				<th style="width: 8.5%"></th>
			            				<th style="width: 8.5%;" class="text-center vertical-middle-kq">Total:</th>
			            				<td style="width: 9%;"><input type="text" class="form-control text-right" id="totalCottizacion" name="totalCotizacion" value="<?php echo isset($cotizacion) ? $cotizacion['imp_total'] : ''; ?>" readonly></td>
			            				<td style="width: 5%;"></td>
			            				<td style="width: 6%;"></td>
			            			</tr>
			            		</tfoot>
			            	</table>
			            </div>
		            </div>
		            <div class="row">
		            	<div class="form-group col-md-12">				            
				            <label class="col-md-2 control-label" style="width: 8%; text-align: left;">Observación general:</label>							
							<div class="col-md-10" style="width: 87.8%">
				                <textarea class="form-control" id="observacionGeneralCotizacion" name="observacionGeneralCotizacion" <?php echo $disabled; ?>><?php echo isset($cotizacion) ? htmlspecialchars($cotizacion['dsc_observacion']) : ''; ?></textarea>
							</div>
			            </div>		            	
		            </div>
		        </div>
		        <!--=====================================
			    BOX CONDICIONES
			    ======================================-->
		        <div class="box-header border-buttom-cotizacion">
      				<h3 class="box-title" style="font-weight: bold">Condiciones</h3>        
      			</div>
      			<div class="box-body">
		            <div class="row">
			            <!--=====================================
		                SELECCIONAR MONEDA
		                ======================================-->
						<div class="form-group col-md-6">				            
				            <label class="col-md-4 control-label">Moneda:</label>							
							<div class="col-md-8">				                
				                <select class="form-control" name="monedaCotizacion" id="monedaCotizacion" style="width: 100%;" <?php echo $disabled; ?>>
				                	<?php
				                	$item = null;
				                	$valor = null;
                                    $monedas = ControladorMoneda::ctrMostrarMoneda($item,$valor);
                                    foreach ($monedas as $key => $value) {      
                                        echo '<option value="'.$value["cod_moneda"].'">'.$value["dsc_simbolo"].' - '.$value["dsc_moneda"].'</option>';
                                    }
                                    ?>
				                </select>
				                <input type="hidden" id="codMonedaCotizacion" value="<?php echo isset($cotizacion) ? $cotizacion['cod_moneda'] : ''; ?>">
							</div>
			            </div>
			            <!--=====================================
		                ENTRADA PARA LA FORMA DE PAGO
		                ======================================-->
		                <?php
		                $dscLabelFormPag = ($flgPeru == 'SI') ? '*Forma de pago' : 'Forma de pago:' ;
		                $disabledFormPag = ($flgPeru == 'SI') ? 'required' : '' ;
		                ?>
						<div class="form-group col-md-6" id="divFormaPafoCtz">            
				            <label class="col-md-4 control-label"><?php echo $dscLabelFormPag; ?></label>
							<div class="col-md-8">				                
				                <select class="form-control" name="formaPagoCotizacion" id="formaPagoCotizacion" style="width: 100%;" <?php echo $disabled; ?>>
				                	<option selected <?php echo $disabledFormPag; ?> value="">Selecciona una forma de pago</option>
				                	<?php
				                	$item = null;
				                	$valor = null;
                                    $formaPagos = ControladorFormaPago::ctrMostrarFormaPago($item,$valor);
                                    foreach ($formaPagos as $key => $value) {   
                                        echo '<option value="'.$value["cod_forma_pago"].'">'.$value["dsc_forma_pago"].'</option>';
                                    }
                                    ?>
				                </select>
				                <input type="hidden" id="codFormaPagoCotizacion" value="<?php echo isset($cotizacion) ? $cotizacion['cod_forma_pago'] : ''; ?>">
							</div>
			            </div>
		            </div>
		            <div class="row">
		            	<!--=====================================
		                ENTRADA PARA EL LUGAR DE ENTREGA
		                ======================================-->
						<div class="form-group col-md-6">				            
				            <label class="col-md-4 control-label">Lugar de entrega:</label>
							<div class="col-md-8">				                
				                <input type="text" class="form-control" name="lugarEntregaCotizacion" value="<?php echo isset($cotizacion) ? htmlspecialchars($cotizacion['dsc_lugar_entrega']) : ''; ?>" <?php echo $disabled; ?> />
							</div>
			            </div>
		            	<!--=====================================
		                ENTRADA PARA EL TIEMPO DE ENTREGA
		                ======================================-->
						<div class="form-group col-md-6">				            
				            <label class="col-md-4 control-label">Tiempo de entrega:</label>
							<div class="col-md-8">				                
				                <input type="text" class="form-control" name="tiempoEntregaCotizacion" value="<?php echo isset($cotizacion) ? htmlspecialchars($cotizacion['dsc_tiempo_entrega']) : ''; ?>" <?php echo $disabled; ?> />
							</div>
			            </div>		            	
		            </div>
		            <div class="row">
		            	<!--=====================================
		                ENTRADA PARA LA VALIDEZ DE OFERTA
		                ======================================-->
						<div class="form-group col-md-6">				            
				            <label class="col-md-4 control-label">Validez de oferta:</label>
							<div class="col-md-8">
				                <input type="text" class="form-control" name="validezOfertaCotizacion" value="<?php echo isset($cotizacion) ? htmlspecialchars($cotizacion['dsc_validez_oferta']) : ''; ?>" <?php echo $disabled; ?> />
							</div>
			            </div>
		            	<!--=====================================
		                ENTRADA PARA LA GARANTÍA
		                ======================================-->
						<div class="form-group col-md-6">				            
				            <label class="col-md-4 control-label">Garantia:</label>							
							<div class="col-md-8">				                
				                <input type="text" class="form-control" name="garantiaCotizacion" value="<?php echo isset($cotizacion) ? htmlspecialchars($cotizacion['dsc_garantia']) : ''; ?>" <?php echo $disabled; ?> />
							</div>
			            </div>
		            </div>
  				</div>
  				<!--=====================================
			    BOX ANEXOS
			    ======================================-->
  				<div class="box-header border-buttom-cotizacion">
      				<h3 class="box-title" style="font-weight: bold">Anexos</h3>        
      			</div>
      			<div class="box-body">
    				<div class="row">
		            	<!--=====================================
		                ENTRADA PARA INSERTAR ARCHIVOS ADJUNTOS
		                ======================================-->
						<div class="form-group col-md-6">				            
				            <label class="col-md-4 control-label">Documentos de referencia:</label>
							<div class="col-md-8">				                
				                <input type="file" class="form-control" id="adjuntoCotizacion" name="adjuntoCotizacion[]" multiple="" />
							</div>
			            </div>
			        </div>
			        <?php
			        if(isset($cotizacionAdjuntos) && count($cotizacionAdjuntos) > 0){
			        	$cantidadFilasAdjuntos = ceil(count($cotizacionAdjuntos) / 4);
			        	$i3 = 0;
			        	$arrayDatosAdjuntos = $arrayRutaDatosAdjuntos = '';
			        	for ($i=1; $i <= $cantidadFilasAdjuntos ; $i++) {
			        		echo '<div class="row">
			        				<div class="col-md-12">';
			        			for ($i2=0+$i3; $i2 < 4+$i3  ; $i2++) {
			        				if(isset($cotizacionAdjuntos[$i2]["dsc_ruta_archivo"])){
			        					$rutaArchivo = explode("-",$cotizacionAdjuntos[$i2]["dsc_ruta_archivo"]);
			        					echo '<div class="col-md-3 listaAdjuntos-kq" style="border: 1px solid #f4f4f4; padding: 7px;">
			        							<span class="span-listaAdjuntos-kq" title="'.$cotizacionAdjuntos[$i2]["dsc_archivo"].'">'.$cotizacionAdjuntos[$i2]["dsc_archivo"].'</span>&nbsp;
			        							<a class="btn btn-primary btn-sm btn-agregar-kq" href="archivos/cotizacion/'.$cotizacionAdjuntos[$i2]["dsc_ruta_archivo"].'" target="_blank">Ver archivo</a>
												<button type="button" class="btn btn-sm btn-danger quitarDatoAdjuntoCotizacion" title="Eliminar" ><i class="fa fa-times"></i></button>
												<input type="hidden" class="rutaDatosAdjuntosCotizacion" value="'.$cotizacionAdjuntos[$i2]["dsc_ruta_archivo"].'">
												<input type="hidden" class="numLineaAdjuntosCotizacion" value="'.$cotizacionAdjuntos[$i2]["num_linea"].'">
												<input type="hidden" class="dscArchivoAdjuntosCotizacion" value="'.$cotizacionAdjuntos[$i2]["dsc_archivo"].'">
			        						</div>';
			        					$arrayDatosAdjuntos .= $cotizacionAdjuntos[$i2]["dsc_archivo"].',';
			        					$arrayRutaDatosAdjuntos .= $cotizacionAdjuntos[$i2]["dsc_ruta_archivo"].',';
			        				}//if
			        			}//for
			        			$i3 = $i3 + 4;
			        		echo '	</div>
			        			</div>';			        		
			        	}//for
			        	echo '<input type="hidden" name="arrayDatosAdjuntos" value="'.substr($arrayDatosAdjuntos, 0, -1).'">';
			        	echo '<input type="hidden" name="arrayRutaDatosAdjuntos" value="'.substr($arrayRutaDatosAdjuntos, 0, -1).'">';
			        }//if			        
			        ?>
			       <input type="hidden" id="listaDatosAdjuntosCotizacion" name="listaDatosAdjuntosCotizacion" />
			       <input type="hidden" id="listaDatosAdjuntosClonarCotizacion" name="listaDatosAdjuntosClonarCotizacion" />
			       <input type="hidden" id="contadorNumLinea" />
	            </div>
	            <div class="box-footer text-right">
     				<button id="guardarCotizacion" type="submit" class="btn btn-primary btn-agregar-kq">Guardar cotizacion</button>      
    			</div>
            	<input type="hidden" id="accionCotizacion" name="accionCotizacion" value="<?php echo $accion; ?>" />
            	<input type="hidden" id="flgApbEstCtz" value="<?php echo $cotizacion["flg_aprobado"]; ?>" />
            	<input type="hidden" name="entradaCtz" value="<?php echo $entradaCtz; ?>" />
            	<input type="hidden" id="flgCtePeruCtz" value="<?php echo $flgPeru; ?>" />
			</div>
		</form>
	</section>
</div>
<?php
include "modals/cliente.modal.php";
}else{
	include "403.php";
}
?>