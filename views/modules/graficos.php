<?php
if(!isset($_SESSION["iniciarSesionIntranet"]) &&  $_SESSION["iniciarSesionIntranet"] != "ok"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
if($_SESSION["flgCotizacion"] == 'SI' && $_SESSION["flgCotizacionEstadistica"] == 'SI'){
?>
<div class="content-wrapper fondo-content-wrapper-kq-2">
	<section class="content-header">    
	    <h1 class="page-header color-h2-kq" id="tituloCotizacion">	      
	    	Estadísticas	    
	    </h1>
	    <ol class="breadcrumb">	      
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
	      <li><a href="cotizaciones"><i class="fa fa-dashboard"></i> Cotizaciones</a></li>	      
	      <li class="active" id="liCotizacion">Estadísticas</li>	    
	    </ol>
	</section>
	<section class="content">
		<!-- <div class="row"> -->
			<div class="box">
				<div class="box-header border-buttom-cotizacion">
					<h3 class="box-title" style="font-weight: bold">Filtros</h3>
				</div>
				<div class="box-body">
					<div class="form-group col-md-4">
						<label for="" class="col-md-5 control-label">Fecha de inicio:</label>
		                <div class="col-md-7">
		                	<div class="input-group date">
		          				<div class="input-group-addon">
		            				<i class="fa fa-calendar"></i>
		          				</div>
		          				<!-- <input type="text" class="form-control pull-right inputFecha" id="fchInicioEstca" value="<?php //echo date('d-m-Y'); ?>" /> -->
		          				<input type="text" class="form-control pull-right inputFecha" id="fchInicioEstca" value="" />
		        			</div>
		                </div>
		            </div>
		            <div class="form-group col-md-4">
						<label for="" class="col-md-5 control-label">Fecha de fin:</label>
		                <div class="col-md-7">
		                	<div class="input-group date">
		          				<div class="input-group-addon">
		            				<i class="fa fa-calendar"></i>
		          				</div>
		          				<!-- <input type="text" class="form-control pull-right inputFecha" id="fchFinEstca" value="<?php //echo date('d-m-Y'); ?>" /> -->
		          				<input type="text" class="form-control pull-right inputFecha" id="fchFinEstca" value="" />
		        			</div>
		                </div>
		            </div>
				</div>
				<!-- <div class="box-header with-border">
				 	<div class="input-group">
					 	<button type="button" class="btn btn-default pull-right" id="daterange-btn-reporteCtz">
			          		<span>
			            		<i class="fa fa-calendar"></i> <span class="textRango">Rango de fecha</span>
			         		</span>
		          			<i class="fa fa-caret-down"></i>
		        		</button>
				 	</div>
				</div> -->
				<div class="box-body">
					<div class="row">
						<!-- <section class="col-lg-5 connectedSortable"> -->
						<div class="col-md-12">
							<div class="box">
								<div class="box-header with-border">
									<h3 class="box-title" style="font-weight: bold">Reporte acumulado del periodo</h3>
								</div>
								<div class="box-body">
									<div class="row">
										<div class="col-md-6">
											<div class="table-responsive">
					               				<table class="table no-margin" id="tblRptEstado">
					               					<thead>
									                  	<!-- <tr>
										                    <th>Order ID</th>
										                    <th>Item</th>
										                    <th>Status</th>
										                    <th>Popularity</th>
									                  	</tr> -->
					                 			 	</thead>
					                  				<tbody></tbody>
					               				</table>
					               			</div>
										</div>
										<div class="col-md-6">
											<div class="chart-responsive">
												<!-- <canvas id="barChart" style="height:230px"></canvas> -->
					                			<div class="chart" id="bar-chart"></div>
					              			</div>
										</div>
									</div>
									
								</div>
							</div>
						</div>
						<!-- <div class="col-md-6">
							<div class="box">
								<div class="box-header with-border">
								</div>
								<div class="box-body">
									<div class="chart-responsive">
					                	<div class="chart" id="bar-chart"></div>
					              	</div>
								</div>
							</div>
						</div> -->
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="box">
								<div class="box-header with-border">
									<h3 class="box-title" style="font-weight: bold">Reporte de tendencia</h3>
								</div>
								<div class="box-body">
									<div class="chart-responsive">
					                	<!-- <canvas id="barChart" style="height:230px"></canvas> -->
					                	<div id="visitors_bar_chart" class="bar-chart-legend" ></div>
					                	<div class="chart" id="bar-chart2" style="height:250px"></div>
					                	
					              	</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- </div> -->
					
	</section>
</div>
<?php
}else{
	include "403.php";
}
?>