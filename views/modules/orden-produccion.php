<?php
//if($_SESSION["perfilAdministrador"] == 'SI'){
	if(isset($_GET["localidad"]) && $_GET["localidad"] != '' && isset($_GET["ordenProduccion"]) && $_GET["ordenProduccion"]){
		$item1 = 'cod_localidad';
		$valor1 = $_GET["localidad"];
		$item2 = 'num_orden_produccion';
		$valor2 = $_GET["ordenProduccion"];
		$item3 = $valor3 = $item4 = $valor4 = null;
		$entrada = 'datosFormulario';
		$ordenProduccion = ControladorOrdenProduccion::ctrMostrarOrdenProduccion($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$entrada);
		$fchValidada = ($ordenProduccion["fch_validada"] != '') ? dateFormat($ordenProduccion["fch_validada"]) : '';
		$chekedFchValidada = ($ordenProduccion["flg_fch_validada"] == 'SI') ? 'checked' : '';
		$itemDoc1 = 'flg_activo';
		$valorDoc1 = 'SI';
		$itemDoc2 = $valorDoc2 = $itemDoc3 = $valorDoc3 = null;
		$entradaDoc = 'listaDocumentoOrdProd';
		$documento = ControladorDocumento::ctrMostrarDocumento($itemDoc1,$valorDoc1,$itemDoc2,$valorDoc2,$itemDoc3,$valorDoc3,$entradaDoc);
		$listaDocumento = '';
		foreach ($documento as $key => $value) {
			$listaDocumento .= $value["cod_documento"].',';
		}
		$listaDocumento = trim($listaDocumento,',');
		$inputDisabledAnu = ($ordenProduccion["flg_anulado"] == 'SI') ? 'disabled' : '';
	}else{
		$chekedFchValidada = $inputDisabledAnu = '';
	}
?>
<div class="content-wrapper fondo-content-wrapper-kq-2">
	<section class="content-header">    
	    <h1 class="page-header color-h2-kq" id="tituloCotizacion">	      
	      Registro de OP	    
	    </h1>
	    <ol class="breadcrumb">	      
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>	      
	      <li class="active" id="liCotizacion">Registro de OP</li>	    
	    </ol>
	</section>
	<section class="content">
		<!--=====================================
  		INICIO FORMULARIO
  		======================================-->
		<form class="form-horizontal" id="formOrdenProduccion" method="post">
  			<div class="box" style="border-top: 3px solid #d1d1d1;">
  				<!--=====================================
		        BOX DATOS GENERALES
		        ======================================-->
  				<div class="box-header border-buttom-cotizacion">
      				<h3 class="box-title"><b>Datos generales</b></h3>
      				<?php
      				if(isset($_GET["localidad"])){
      					echo '<button type="button" class="btn btn-default" id="btnDescargarExcelDetOrdPrd" style="margin-left:15px;">
		             	<i class="fa fa-cloud-download"></i> Exportar Productos
		          	</button>';
		          	}
		          	?>
		          	<button style="margin-left:5px;" id="cancelarOrdPrd" type="button" class="btn btn-canelarContacto">Cancelar</button>
		          	<?php
		          	if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
		          		echo '<button style="margin-left:5px;" id="guardarOrdPrd" type="submit" class="btn btn-primary btn-agregar-kq">Guardar OP</button>';
		          	}
		          	?>
      			</div>
      			<!-- <div class="box-footer text-right">
					<button id="cancelarOrdPrd" type="button" class="btn btn-canelarContacto">Cancelar</button>
     				<button id="guardarOrdPrd" type="submit" class="btn btn-primary btn-agregar-kq">Guardar OP</button>
    			</div> -->
        		<div class="box-body">
    				<div class="row">
    					<div class="form-group col-md-5">
        					<label class="col-md-3 control-label">Usuario:</label>
		                    <div class="col-md-9">
		                    	<input type="text" class="form-control" value="<?php echo isset($ordenProduccion) ? $ordenProduccion["full_nombre"] : $_SESSION["apellido_paterno"].' '.$_SESSION["apellido_materno"].', '.$_SESSION["nombres"]; ?>" readonly />
		                    	<input type="hidden" name="codUsuarioOrdPrd" value="<?php echo isset($ordenProduccion) ? $ordenProduccion["cod_trabajador"] : $_SESSION["cod_trabajador"]; ?>" />
		                    </div>
		            	</div>
		            	<div class="form-group col-md-5">
        					<label for="" class="col-md-3 control-label">Fecha:</label>
		                    <div class="col-md-9">
		                    	<div class="input-group date">
	                  				<div class="input-group-addon">
	                    				<i class="fa fa-calendar"></i>
	                  				</div>
	                  				<input type="text" class="form-control pull-right" value="<?php echo isset($ordenProduccion) ? dateFormat($ordenProduccion['fch_registro']) : date('d-m-Y'); ?>" readonly />
	                			</div>
		                    </div>
		                </div>
    				</div>
    				<div class="row">
    					<div class="form-group col-md-5">
        					<label class="col-md-3 control-label">Nº orden producción:</label>
		                    <div class="col-md-9">
		                    	<input type="text" class="form-control" id="numOrdPrd" name="numOrdPrd" placeholder="Ingresar Nº orden" value="<?php echo isset($ordenProduccion) ? $ordenProduccion['num_orden_produccion'] : ''; ?>" required <?php echo $inputDisabledAnu; ?> />
		                    </div>
		            	</div>
		            	<div class="form-group col-md-5">
        					<label class="col-md-3 control-label">Estado:</label>
		                    <div class="col-md-9">
		                    	<?php		                    	
		                    	if(isset($ordenProduccion)){
		                    		if($ordenProduccion["flg_anulado"] == 'SI'){
		                    			echo '<input type="text" class="form-control" id="" name="dscEstadoOrdPrd" value="'.$ordenProduccion["dsc_estado"].'" disabled />';
		                    		}else{
		                    			$item1Est = 'flg_activo';
			                    		$valor1Est = 'SI';
			                    		$item2Est = $valor2Est = null;
			                    		$entradaEst = 'inputSelect';
			                    		$estado = ControladorEstadoOrdenProduccion::ctrMostrarEstadoOrdenProduccion($item1Est,$valor1Est,$item2Est,$valor2Est,$entradaEst);
			                    		echo '<select class="form-control" id="codEstadoOrdPrd" name="codEstadoOrdPrd">';
			                    		echo '<option value="">Seleccione</option>';
			                    		foreach ($estado as $key => $value) {
			                    			$selected = ($value["cod_estado"] == $ordenProduccion["cod_estado"]) ? 'selected' : '';
			                    			echo '<option value="'.$value["cod_estado"].'" '.$selected.'>'.$value["dsc_estado"].'</option>';
			                    		}
			                    		echo '</select>';	
		                    		}
		                    	}else{
		                    		$item1Est = 'flg_pendiente';
			                    	$valor1Est = 'SI';
			                    	$item2Est = 'flg_activo';
			                    	$valor2Est = 'SI';
			                    	$entradaEst = 'flgPendiente';
			                    	$estado = ControladorEstadoOrdenProduccion::ctrMostrarEstadoOrdenProduccion($item1Est,$valor1Est,$item2Est,$valor2Est,$entradaEst);
		                    		echo '<input type="text" class="form-control" id="" name="dscEstadoOrdPrd" value="'.$estado["dsc_estado"].'" readonly />';
		                    		echo '<input type="hidden" name="codEstadoOrdPrd" value="'.$estado["cod_estado"].'" />';
		                    	}		                    	
		                    	?>
		                    </div>
		            	</div>
		            </div>
		            <div class="row">
		            	<!--=====================================
		                ENTRADA PARA EL CLIENTE
		                ======================================-->
						<div class="form-group col-md-10">	            
				            <label class="col-md-3 control-label" style="width: 12.2%;">Cliente:</label>
				            <?php
				            if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
				            ?>
				            <div class="col-md-10"  style="width: 78.5% !important; padding-right: 5px;">
				                <select class="form-control select2" id="clienteOrdProd" name="clienteOrdProd" style="width: 100%;" required>
				                	<option selected value="">Selecciona un cliente</option>
				                	<?php
				                	$item = null;
				                	$valor = null;
				                	$entrada = null;
	    							$clientes = ControladorClientes::ctrMostrarClientes($item,$valor,$entrada);
	    							foreach ($clientes as $key => $value) {
	    								$selected = ($value["cod_cliente"] == $ordenProduccion["cod_cliente"]) ? 'selected' : '';
	    								echo '<option value="'.$value["cod_cliente"].'" '.$selected.'>'.$value["dsc_razon_social"].'</option>';
	    							}//foreach
	    							?>
				                </select>
							</div>
							<div class="col-md-1" style="padding-left: 0px;">
								<button type="button" class="btn btn-primary btn-agregar-kq btnAgregarCliente" data-toggle="modal" data-target="#modalCliente" data-dismiss="modal" title="Agregar Cliente"><i class="fa fa-plus"></i></button>
							</div>
							<input type="hidden" id="codClienteOrdProd" value="<?php echo isset($ordenProduccion) ? $ordenProduccion["cod_cliente"] : ''; ?>">
							<?php
							}else{
							?>
							<div class="col-md-9" style="width: 84.3%;">
		                    	<input type="text" class="form-control" id="" name="dscEstadoOrdPrd" value="<?php echo $ordenProduccion["dsc_razon_social"]; ?>" disabled />
		                    </div>
							<?php
							}
							?>						
			            </div>
		           	</div>
    				<div class="row">
    					<div class="form-group col-md-10">
        					<label class="col-md-3 control-label" style="width: 12.2%;">Descripción:</label>
		                    <div class="col-md-9" style="width: 84.3%;">
		                    	<textarea class="form-control" name="descripcionOrdPrd" <?php echo $inputDisabledAnu; ?>><?php echo isset($ordenProduccion) ? $ordenProduccion['dsc_orden'] : ''; ?></textarea>
		                    </div>
		            	</div>
		            </div>
		            <div class="row">
		            	<div class="form-group col-md-5">
				            <label class="col-md-3 control-label">Orden de Compra:</label>								
							<!-- <div class="col-md-7"  style="width: 62.7% !important; padding-right: 5px;">
				                <input class="form-control inputDisabled" type="text" id="ordenCompraOrdPrd" name="ordenCompraOrdPrd" value="<?php echo isset($ordenProduccion) ? $ordenProduccion["dsc_orden_compra"] : ''; ?>" disabled />
							</div> -->
							<?php
							if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
							?>
							<div class="col-md-7"  style="width: 51.7% !important; padding-right: 5px;">
			                	<input class="form-control inputDisabled" type="text" id="ordenCompraOrdPrd" name="ordenCompraOrdPrd" value="<?php echo isset($ordenProduccion) ? $ordenProduccion["dsc_orden_compra"] : ''; ?>" disabled />
							</div>
							<div class="col-md-1" style="padding-left: 0px;">
							<?php
							if(isset($ordenProduccion)){
								echo '<button type="button" class="btn btn-primary btn-agregar-kq" id="btnBuscarOrdenCompra" data-toggle="modal" data-target="#modalCotizacion" data-dismiss="modal" title="Buscar"><i class="fa fa-search"></i></button>';
							}else{
								echo '<button type="button" class="btn btn-primary btn-agregar-kq" id="btnBuscarOrdenCompra" title="Debes seleccionar un cliente" disabled><i class="fa fa-search"></i></button>';
							}
							?>
							</div>
							<?php							
							}else{
							?>
							<div class="col-md-9">
								<input class="form-control inputDisabled" type="text" id="ordenCompraOrdPrd" name="ordenCompraOrdPrd" value="<?php echo isset($ordenProduccion) ? $ordenProduccion["dsc_orden_compra"] : ''; ?>" disabled />
							</div>
							<?php
							}
							?>							
							<!-- <div class="col-md-1" style="padding-left: 9px;">
								<button type="button" class="btn btn-danger" id="btnLimpiarOrdenCompra" title="Limpiar"><i class="fa fa-eraser"></i></button>
							</div> -->
			            </div>
			            <div class="form-group col-md-5">
        					<label class="col-md-3 control-label">Sede:</label>
		                    <div class="col-md-9">
	                    	<?php
	                    	if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
	                    		$item1Sede = 'flg_activo';
	                    		$valor1Sede = 'SI';
	                    		$sede = ControladorOrdenProduccion::ctrMostrarSede($item1Sede,$valor1Sede);
	                    		echo '<select class="form-control" name="codSedeOrdPrd">';
	                    		foreach ($sede as $key => $value) {
	                    			$selected = ($value["cod_sede"] == $ordenProduccion["cod_sede"]) ? 'selected' : '';
	                    			echo '<option value="'.$value["cod_sede"].'" '.$selected.'>'.$value["dsc_sede"].'</option>';
	                    		}
	                    		echo '</select>';	
	                    	}else{
	                    		echo '<input type="text" class="form-control" id="" name="dscEstadoOrdPrd" value="'.$ordenProduccion["dsc_sede"].'" disabled />';
	                    	}                    		
	                    	?>
		                    </div>
		            	</div>
		            	
    				</div>
    				<div class="row">
    					<div class="form-group col-md-5">
        					<label for="" class="col-md-3 control-label">Fecha de entrega:</label>
        					<?php
        					if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
        					?>
        					<div class="col-md-8" style="width: 62.55%;padding-right: 5px;">
		                    	<div class="input-group date">
	                  				<div class="input-group-addon">
	                    				<i class="fa fa-calendar"></i>
	                  				</div>
	                  				<input type="text" class="form-control inputFecha" id="fchCompromisoOrdPrd" name="fchCompromisoOrdPrd" placeholder="Ingresar fecha" value="<?php echo isset($ordenProduccion) ? dateFormat($ordenProduccion['fch_compromiso']) : ''; ?>" />
	                			</div>
		                    </div>
		                    <div class="col-md-1" style="padding-left: 0px;">
		                    	<?php
		                    	if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
		                    		echo '<button type="button" id="btnReplicarFchEntrega" class="btn btn-primary btn-agregar-kq" title="Replicar"><i class="fa fa-repeat"></i></button>';
		                    	}
		                    	?>
							</div>
        					<?php
        					}else{
        					?>
        					<div class="col-md-9">
		                    	<div class="input-group date">
	                  				<div class="input-group-addon">
	                    				<i class="fa fa-calendar"></i>
	                  				</div>
	                  				<input type="text" class="form-control inputFecha" id="fchCompromisoOrdPrd" name="fchCompromisoOrdPrd" placeholder="Ingresar fecha" value="<?php echo isset($ordenProduccion) ? dateFormat($ordenProduccion['fch_compromiso']) : ''; ?>" <?php echo $inputDisabledAnu; ?> />
	                			</div>
		                    </div>
        					<?php
        					}
        					?>		                    
		                </div>
    					<div class="form-group col-md-5">
        					<label for="fchValidadaOrdPrd" class="col-md-3 control-label" title="Fecha validada por cliente">F. validada por cliente:</label>
        					<?php
        					if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
        					?>
        					<div class="col-md-8" style="width: 62.55%;padding-right: 5px;">
		                    	<div class="input-group date">
	                  				<div class="input-group-addon">
	                    				<i class="fa fa-calendar"></i>
	                  				</div>
	                  				<input type="text" class="form-control inputFecha" id="fchValidadaOrdPrd" name="fchValidadaOrdPrd" placeholder="Ingresar fecha" value="<?php echo isset($ordenProduccion) ? $fchValidada : ''; ?>" <?php echo $inputDisabledAnu; ?> />
	                			</div>
		                    </div>
		                    <div class="col-md-1" style="padding-left: 0px;">
		                    	<?php
		                    	if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
		                    		echo '<button type="button" id="btnReplicarFchValidada" class="btn btn-primary btn-agregar-kq" title="Replicar"><i class="fa fa-repeat"></i></button>';
		                    	}
		                    	?>
							</div>
        					<?php
        					}else{
        					?>
        					<div class="col-md-9">
		                    	<div class="input-group date">
	                  				<div class="input-group-addon">
	                    				<i class="fa fa-calendar"></i>
	                  				</div>
	                  				<input type="text" class="form-control inputFecha" id="fchValidadaOrdPrd" name="fchValidadaOrdPrd" placeholder="Ingresar fecha" value="<?php echo isset($ordenProduccion) ? $fchValidada : ''; ?>" <?php echo $inputDisabledAnu; ?> />
	                			</div>
		                    </div>
        					<?php
        					}
        					?>		                    
		                </div>
    				</div>
    				<div class="row">
    					<div class="form-group col-md-5">
        					<label for="" class="col-md-3 control-label">Validado:</label>
		                    <div class="col-md-8" style="width: 62.55%;padding-right: 5px;">
		                    	<?php
		                    	if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
		                    		echo "<input type='checkbox' $chekedFchValidada id='chkValidadoOrdProd' name='chkValidadoOrdProd' />";		                    		
		                    	}else{
		                    		echo "<input type='checkbox' $chekedFchValidada disabled />";
		                    	}
		                    	?>
		                    	
		                    </div>
		                </div>
		            </div>
    			</div>
    			<!--=====================================
			    BOX DETALLE
			    ======================================-->
    			<div class="box-header with-border border-buttom-cotizacion" style="border-bottom: 2px solid #d1d1d1;">
      				<h3 class="box-title" style="width: 83.5%;vertical-align: middle;"><b>Detalle</b></h3>
      			</div>
      			<div class="box-body boxDetalleCotizacion">
      				<div id="parentHorizontalTab">
			            <ul class="resp-tabs-list hor_1">
			                <li id="tabProductoOrdProd">Productos o Servicios</li>
			                <li id="tabAreaOrdProd">Áreas</li>
			                <li id="tabDocumentoOrdPrd">Documentos</li>
			                <li id="tabObservacionOrdPrd">Observaciones</li>
			            </ul>
			            <div class="resp-tabs-container hor_1">
			            	<div>
			            		<div style="width: 100%;" class="text-right">
			            			<?php
			            			if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
			            				echo '<button type="button" class="btn btn-sm btn-primary" title="Agregar" id="btnAgregarPrdOrdProd" ><i class="fa fa-plus"></i></button>';
			            			}
			            			?>
			            		</div>
			            		<div class="table-responsive">
				                    <table class="table table-striped table-bordered tablaKq" id="tablaPrdOrdProd" style="width: 100%;">
				                    	<thead class="thead-kq">
				                    		<tr>
				                    			<th class="text-center tblPrdOrdProdWidthCorl">#</th>
				                    			<th class="text-center tblPrdOrdProdWidthCtz">Nº Cotización</th>
				                    			<th class="text-center tblPrdOrdProdWidthFchEtg">Fecha de entrega</th>
				                    			<th class="text-center tblPrdOrdProdWidthFchVld">Fecha Validada</th>
				                    			<th class="text-center tblPrdOrdProdWidthArea">Area</th>
				                    			<th class="text-center tblPrdOrdProdWidthPeso">Peso</th>
				                    			<th class="text-center tblPrdOrdProdWidthDscPrd">Producto o Servicio</th>
				                    			<th class="text-center tblPrdOrdProdWidthCnt" title="Cantidad">Ctd</th>
				                    			<th class="text-center tblPrdOrdProdWidthUnd" title="Unidad">Und</th>
				                    			<th class="text-center tblPrdOrdProdWidthUnd" title="Impresión Simplificada"></th>
				                    			<?php
				                    			if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
				                    				echo '<th class="tblPrdOrdProdWidthBtnElm"></th>';
				                    			}
				                    			?>
				                    		</tr>
				                    	</thead>
				                    	<tbody></tbody>
				                    </table>
				                 </div>
			                </div>
			                <div>
			                    <table class="table table-striped table-bordered tablaKq" id="tablaAreaOrdProd" style="width: 100%;">
			                    	<thead style="background-color: #d1d1d1;">
			                    		<tr>
			                    			<th class="text-center tblAreaOrdProdWidthCorl">Nº</th>
			                    			<th class="text-center tblAreaOrdProdWidthDsc">Áreas</th>
			                    			<th class="text-center tblAreaOrdProdWidthChk">
			                    				<?php
			                    				if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
			                    					echo '<input type="checkbox" id="chkTotalAreaOrdProd" />';
			                    				}
			                    				?>
			                    			</th>
			                    		</tr>
			                    	</thead>
			                    	<tbody></tbody>
			                    </table>
			                </div>
			                <div>
			                	<!-- <div style="float: left;width: 60%;"> -->
			                		<div class="table-responsive">
				                		<table class="table table-striped table-bordered" id="tablaDocumentoOrdProd" style="width: 100%;">
					                    	<thead style="background-color: #d1d1d1;">
					                    		<tr>
					                    			<th class="text-center tblDctoOrdProdWidthCorl">Nº</th>
					                    			<th class="text-center tblDctoOrdProdWidthDsc">Descripción</th>
					                    			<th class="text-center tblDctoOrdProdWidthChk">
					                    				<?php
					                    				if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
					                    					echo '<input type="checkbox" id="chkTotalDocumentoOrdProd" />';
					                    				}
					                    				?>
					                    			</th>
					                    			<th class="text-center tblAreaOrdProdWidtBtn"></th>
					                    			<th class="hidden"></th>
					                    		</tr>
					                    	</thead>
					                    	<tbody></tbody>
					                    </table>
				                	</div>
				                <br />
				            	<!-- <div id="divUsuarioDctoOrdProd" class="hidden">
				            		<div style="overflow: hidden;">
				            			<h4 style="float: left;">Usuarios</h4>
				            			<button style="float: right;" type="button" class="btn btn-sm btn-primary" title="Agregar" id="btnAgregarUsrDctoOrdProd" ><i class="fa fa-plus"></i></button>	
				            		</div>				            		
				            		<div class="table-responsive">
				                		<table class="table table-striped table-bordered" style="width: 100%" id="tablaUsrOrdProd">
				                			<thead style="background-color: #d1d1d1;">
					                    		<tr>
					                    			<th class="text-center tblUsrDctoOrdProdWidthCorl">Nº</th>
					                    			<th class="text-center tblUsrDctoOrdProdWidthDsc">Usuario</th>
					                    			<th class="text-center tblUsrDctoOrdProdWidthElm"></th>
					                    		</tr>
					                    	</thead>
					                    	<tbody></tbody>
				                		</table>
				                	</div>	
			                    </div>		       -->          		
			                </div>
			                <div>
			            		<div style="width: 100%;" class="text-right">
			            			<?php
			            			if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
			            				echo '<button type="button" class="btn btn-sm btn-primary" title="Agregar" id="btnAgregarObsOrdProd" data-toggle="modal" data-target="#modalObservacionOrdPrd" data-dismiss="modal"><i class="fa fa-plus"></i></button>';
			            			}
			            			?>
			            		</div>
			            		<div class="table-responsive">
				                    <table class="table table-striped table-bordered tablaKq" id="tablaObservacionOrdProd" style="width: 100%;">
				                    	<thead class="thead-kq">
				                    		<tr>
				                    			<th class="text-center tblObsOrdProdWidthCorl">#</th>
				                    			<th class="text-center tblObsOrdProdWidthObs">Observación</th>
				                    			<th class="text-center tblObsOrdProdWidthUsr">Usuario</th>
				                    			<th class="text-center tblObsOrdProdWidthFchRgs">Fecha Registro</th>
				                    			<th class="text-center tblObsOrdProdWidthAtm" title="Observación Automática">A</th>
				                    			<?php
				                    			if(!isset($_GET["localidad"]) || (isset($_GET["localidad"]) && $ordenProduccion["flg_anulado"] != 'SI')){
				                    				echo '<th class="text-center tblObsOrdProdWidthAcn">Acciones</th>';
				                    			}
				                    			?>
				                    			
				                    		</tr>
				                    	</thead>
				                    	<tbody></tbody>
				                    </table>
				                </div>
				            </div>
			            </div>
        			</div>
      			</div>      			
  			</div>
  			<input type="hidden" name="accionOrdenProduccion" value="<?php echo isset($_GET["localidad"]) ? 'editar' : 'crear'; ?>" />
  			<input type="hidden" id="listaProductosOrdPrd" name="listaProductosOrdPrd" />
  			<input type="hidden" id="listaAreasOrdPrd" name="listaAreasOrdPrd" />
  			<input type="hidden" id="listaAreasOrigOrdPrd" name="listaAreasOrigOrdPrd" />
  			<input type="hidden" id="listaDocumentosOrdPrd" name="listaDocumentosOrdPrd" />
  			<input type="hidden" id="listaDocumentosOrginOrdPrd" name="listaDocumentosOrginOrdPrd" />
  			<input type="hidden" id="codLocalidadOrdPrd" name="codLocalidadOrdPrd" value="<?php echo isset($_GET["localidad"]) ? $_GET["localidad"] : ''; ?>" />
  			<input type="hidden" id="numOrdPrdOrig" name="numOrdPrdOrig" value="<?php echo isset($ordenProduccion) ? $ordenProduccion["num_orden_produccion"] : 0; ?>" />
  			<input type="hidden" name="listaMaestraDocOrdProd" value="<?php echo isset($ordenProduccion) ? $listaDocumento : '';?>" />
  			<input type="hidden" name="entrada" value="formularioPrincipal" />
  			<input type="hidden" id="cotizacionOrdProd" name="cotizacionOrdProd" />
  			<input type="hidden" id="listaAreasInsertarOrdPrd" name="listaAreasInsertarOrdPrd">
  			<input type="hidden" id="listaAreasEliminarOrdPrd" name="listaAreasEliminarOrdPrd">
  			<input type="hidden" id="chkValidadoOriginOrdPrd" name="chkValidadoOriginOrdPrd" value="<?php echo isset($ordenProduccion) ? $ordenProduccion["flg_fch_validada"] : ''; ?>" />
  			<input type="hidden" id="flgAnuladoEstOrdPrd" value="<?php echo isset($ordenProduccion) ? $ordenProduccion["flg_anulado"] : ''; ?>">
  			<input type="hidden" id="codEstadoOriginOrdPrd" value="<?php echo isset($ordenProduccion) ? $ordenProduccion["cod_estado"] : ''; ?>">
  		</form>
  		<!--=====================================
  		FIN FORMULARIO
  		======================================-->
	</section>
</div>
<?php
include "modals/cliente.modal.php";
include "modals/observacionOrdenProduccion.modal.php";
include "modals/usuarioDocOrdenProd.modal.php";
include "modals/datatableCotizacion.modal.php";
include "modals/datosAdjuntosCotizacion.modal.php";
include "modals/productosCotizacion.modal.php";
/*}else{
	include "403.php";
}*/