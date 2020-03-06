<?php
if(!isset($_SESSION["iniciarSesionIntranet"]) &&  $_SESSION["iniciarSesionIntranet"] != "ok"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
if($_SESSION["flgCotizacion"] == 'SI'){
?>
<div class="content-wrapper fondo-content-wrapper-kq-2">
	<section class="content-header">    
	    <h1 class="page-header color-h2-kq">	      
	      Control de cotizaciones	    
	    </h1>
	    <ol class="breadcrumb">	      
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>	      
	      <li class="active">Control de cotizaciones</li>	    
	    </ol>
	</section>
	<section class="content">
		<div class="box" style="border-top: 3px solid #d1d1d1;">
			<div class="box-header with-border">
				<a href="cotizacion">				
					<button class="btn btn-primary btn-agregar-kq">Agregar cotización</button>
				</a>
				<span style="padding-left: 5px; padding-top: 6px; cursor: pointer;" class="glyphicon glyphicon-question-sign pull-right" title="Ayuda"></span>   		
				<button type="button" class="btn btn-default pull-right" id="daterange-btn-cotizacion">
	          		<span>
	            		<i class="fa fa-calendar"></i> <span class="textRango">Rango de fecha</span>
	         		</span>
	          		<i class="fa fa-caret-down"></i>
        		</button>
        		<!-- <div class="row">
        			<div class="col-md-4">
        				<div class="input-group">		                	
		                	<div class="input-group-addon">
		                		<i class="fa fa-user"></i>
		                	</div>
		                  	<input type="text" class="form-control" value="" placeholder="Buscar Cliente" id="filtroClienteCotizacion">
		                </div>
        			</div>
        			<div class="col-md-4">
        				<div class="input-group">		                	
		                	<div class="input-group-addon">
		                		<i class="fa fa-product-hunt"></i>
		                	</div>
		                  	<input type="text" class="form-control" value="" placeholder="Buscar Producto" id="filtroProductoCotizacion">
		                </div>
        			</div>
        			<div class="col-md-4">
        				<button type="button" class="btn btn-default pull-right" id="daterange-btn-cotizacion" style="width: 100%;">
			          		<span>
			            		<i class="fa fa-calendar"></i> <span class="textRango">Rango de fecha</span>
			         		</span>
			          		<i class="fa fa-caret-down"></i>
		        		</button>
        			</div>        			
        		</div>-->
        		<input type="hidden" id="filtroFInicialCotizacion">
        		<input type="hidden" id="filtroFFinalCotizacion">
			</div>
			<div class="box-body table-responsive">
				<table class="table table-bordered table-striped" width="100%" id="tablaListaCotizacion">
					<thead class="thead-kq-2">
						<tr>
							<th>&nbsp;</th>
							<th class="text-center">Código</th>
							<th class="text-center filtroCotizacion">Cliente</th>
							<th class="text-center">REF.</th>
							<th class="text-center">Monto</th>
							<th style="/*width: 51px;*/" class="text-center">Fecha</th>
							<th class="text-center">Cotizado&nbsp;por</th>
							<th class="text-center">Estado</th>
							<!-- <th class="text-center" style="width: 160px;">Acciones</th> -->
							<!-- <th style="width: 173px;" class="text-center">Acciones</th> -->
							<th class="text-center">Acciones</th>
							<th class="text-center"></th>
							<th class="hidden"></th>
							<th class="hidden"></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
			<input type="hidden" id="accionCotizacion" value="listar">
		</div>
	</section>
</div>
<?php
include "modals/enviarCorreo.modal.php";
}else{
	include "403.php";
}
?>