<?php
if(!isset($_SESSION["iniciarSesionIntranet"]) &&  $_SESSION["iniciarSesionIntranet"] != "ok"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
//if($_SESSION["perfilAdministrador"] == 'SI'){
?>
<div class="content-wrapper fondo-content-wrapper-kq-2">
	<section class="content-header">    
	    <h1 class="page-header color-h2-kq">	      
	      Seguimiento de Ordenes de Producción
	    </h1>
	    <ol class="breadcrumb">	      
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>	      
	      <li class="active">Seguimiento de Ordenes de Producción</li>
	    </ol>
	</section>
	<section class="content">
		<div class="box" style="border-top: 3px solid #d1d1d1;">
			<div class="box-header with-border">
				<a href="orden-produccion">				
					<button class="btn btn-primary btn-agregar-kq">Agregar orden de producción</button>
				</a>
				<span style="padding-left: 5px; padding-top: 6px; cursor: pointer;" class="glyphicon glyphicon-question-sign pull-right" title="Ayuda"></span>
				
				<button type="button" class="btn btn-default pull-right" id="daterange-btn-ordProd">
	          		<span>
	            		<i class="fa fa-calendar"></i> <span class="textRango">Rango de fecha</span>
	         		</span>
	          		<i class="fa fa-caret-down"></i>
        		</button>
        		<select id="filtroEstadoOrdProd" class="form-control" style="width: 15%;float: right;margin-right: 5px;">
        			<option value="todos">Todas los estados</option>
        			<?php
        			$item1 = 'flg_activo';
        			$valor1 = 'SI';
        			$item2 = $valor2 = null;
        			$entrada = 'inputSelect';
        			$estado = ControladorEstadoAreaOrdProd::ctrMostrarEstadoAreaOrdProd($item1,$valor1,$item2,$valor2,$entrada);
        			foreach ($estado as $key => $value) {
        				echo '<option value="'.$value["cod_estado"].'">Estado: '.$value["dsc_estado"].'</option>';
        			}
        			?>
        		</select>
        		<select id="filtroFchValidadaOrdProd" class="form-control" style="width: 15%;float: right;margin-right: 5px;">
        			<option value="todos">Todos</option>
        			<option value="MDF">Fecha Modificada</option>
        			<option value="NO">Pendiente de validar por planeamiento</option>
        			<option value="SI">Validado por planeamiento</option>
        		</select>
	          	<!-- <button class="btn btn-default pull-right" id="btnDescargarExcelDetOrdPrd2" style="margin-right: 5px;">
	              <i class="fa fa-cloud-download"></i> Exportar Detalle
	          	</button> -->
	          	<button class="btn btn-default pull-right" id="btnDescargarExcelOrdPrd" style="margin-right: 5px;">
	              <i class="fa fa-cloud-download"></i> Exportar
	          	</button>
        		<input type="hidden" id="filtroFInicialOrdProd">
        		<input type="hidden" id="filtroFFinalOrdProd">
			</div>
			<div class="box-body table-responsive">
				<table class="table table-bordered table-striped tablaKq" width="100%" id="tablaListaOrdProd">
					<thead class="thead-kq-2">
						<tr>
							<th class="text-center"></th>
							<th class="text-center tblOrdProdWidthCte">Cliente</th>
							<th class="text-center tblOrdProdWidthOrdPrd">OP</th>
							<th class="text-center tblOrdProdWidthEst">Estado</th>
							<th class="text-center tblOrdProdWidthNitm">Item</th>
							<th class="text-center tblOrdProddWidthDsc">Producto</th>
							<th class="text-center tblOrdProdWidthCtd">CTD</th>
							<th class="text-center tblOrdProdWidthUnd">Unid</th>						
							<th class="text-center tblOrdProdWidthFchEtg">Fecha Validada</th>
							<?php
							$item1 = 'flg_activo';
							$valor1 = 'SI';
							$item2 = $valor2 = $item3 = $valor3 = $item4 = $valor4 = $item5 = $valor5 = null;
							$entrada = "dtbleOrdPrd";
							$listaCodArea = '';
							$numAreas = 0;
							$area = ControladorArea::ctrMostrarArea($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$item5,$valor5,$entrada);
							foreach ($area as $key => $value) {
								echo '<th class="text-center">'.$value["dsc_area"].'</th>';
								$listaCodArea .= $value["cod_area"].',';
								$numAreas++;							
							}//foreach
							?>
							<th class="text-center tblOrdProdWidthAcn"></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
				<input type="hidden" id="codigoAreasOrdProd" value="<?php echo trim($listaCodArea,','); ?>" />
				<input type="hidden" id="numAreasOrdProd" value="<?php echo $numAreas; ?>" />
			</div>
		</div>
	</section>
</div>
<?php
include "modals/areaOrdenProd.modal.php";
include "modals/areaFacturacionOrdenProd.modal.php";
// }else{
// 	include "403.php";
// }
?>