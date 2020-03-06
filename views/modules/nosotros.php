<?php
if(!isset($_SESSION["iniciarSesionIntranet"]) &&  $_SESSION["iniciarSesionIntranet"] != "ok"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
$entrada = "nosotros";
$empresa = ControladorEmpresa::ctrMostrarEmpresa($entrada);
?>
<div class="content-wrapper fondo-content-wrapper-kq">
	<section class="content-header">    
	    <h1 class="page-header color-h2-kq">	      
	      Nosotros	    
	    </h1>
	    <ol class="breadcrumb">	      
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>	      
	      <li class="active">Nosotros</li>	    
	    </ol>
	</section>
	<section class="content">
		<div class="row">
	        <div class="col-md-12">
	          	<div class="box box-solid" style="background: #d1d1d1;">
	            	<div class="box-header with-border" style="color: #000 !important;">
	             		<i class="fa fa-balance-scale font-weight-kq"></i>
	              		<h3 class="box-title font-weight-kq">Historia</h3>
	              		<?php
	              		if($_SESSION["flgEmpresa"] == 'SI'){
	              			echo '<div class="box-tools pull-right">							
								<button type="button" class="btn btn-box-tool btnEditarHistoria"><i class="fa fa-edit" style="color: #000;"></i>
							</div>';
	              		}
	              		?>
	            	</div>
		            <div class="box-body text-justify">
		            	<?php
		            	if($_SESSION["flgEmpresa"] == 'SI'){
		            		echo '<a href="#" id="texto-historia" style="color: #000;">'.$empresa["dsc_historia"].'</a>';
		            	}else{
		            		echo '<a href="#" style="color: #000; cursor:default;">'.$empresa["dsc_historia"].'</a>';
		            	}
		            	?>		            	
		            </div>
	          	</div>
	        </div>
	    </div>
	    <div class="row">
	        <div class="col-md-12">
	          	<div class="box box-solid" style="background: #ffffff;">
	            	<div class="box-header with-border" style="color: #000 !important; border-bottom: 1px solid #9b9c9b;" >
	             		<i class="fa fa-eye font-weight-kq"></i>
	              		<h3 class="box-title font-weight-kq">Visión</h3>
	              		<?php
	              		if($_SESSION["flgEmpresa"] == 'SI'){
	              			echo '<div class="box-tools pull-right">							
								<button type="button" class="btn btn-box-tool btnEditarVision"><i class="fa fa-edit" style="color: #000;"></i>
							</div>';
	              		}
	              		?>	              		
	            	</div>
		            <div class="box-body text-justify">	
		            	<?php
		            	if($_SESSION["flgEmpresa"] == 'SI'){
		            		echo '<a href="#" id="texto-vision" style="color: #000;">'.$empresa["dsc_vision"].'</a>';
		            	}else{
		            		echo '<a href="#" style="color: #000; cursor:default;">'.$empresa["dsc_vision"].'</a>';
		            	}
		            	?>		            		             	
		            </div>
	          	</div>
	        </div>
	    </div>
	    <div class="row">
	        <div class="col-md-12">
	          	<div class="box box-solid" style="background: #d1d1d1;">
	            	<div class="box-header with-border" style="color: #000 !important">
	             		<i class="fa fa-street-view font-weight-kq"></i>
	              		<h3 class="box-title font-weight-kq">Misión</h3>
	              		<?php
	              		if($_SESSION["flgEmpresa"] == 'SI'){
		              		echo '<div class="box-tools pull-right">							
								<button type="button" class="btn btn-box-tool btnEditarMision"><i class="fa fa-edit" style="color: #000;"></i>
							</div>';
						}
						?>
	            	</div>
		            <div class="box-body text-justify">
		            	<?php
		            	if($_SESSION["flgEmpresa"] == 'SI'){
		            		echo '<a href="#" id="texto-mision" style="color: #000;">'.$empresa["dsc_mision"].'</a>';
		            	}else{
		            		echo '<a href="#" style="color: #000; cursor:default;">'.$empresa["dsc_mision"].'</a>';
		            	}
		            	?>
		            </div>
	          	</div>
	        </div>
	    </div>
	    <div class="row">
	        <div class="col-md-12">
	          	<div class="box box-solid" style="background: #ffffff;">
	            	<div class="box-header with-border" style="color: #000 !important; border-bottom: 1px solid #9b9c9b;">
	             		<i class="fa fa-star-half-empty font-weight-kq"></i>
	              		<h3 class="box-title font-weight-kq">Valores</h3>	              		
	              		<!-- <div class="box-tools pull-right">							
							<button type="button" class="btn btn-box-tool btnEditarValores"><i class="fa fa-edit" style="color: #000;"></i>
						</div> -->
	            	</div>
		            <div class="box-body text-justify">
						<div class="row">
							<?php
							$valores = ControladorEmpresaValores::ctrMostrarEmpresaValores();
							foreach ($valores as $key => $value) {
								echo '<div class="col-md-6">
					              		<div class="attachment-block clearfix">
					                		<img class="attachment-img" src="archivos/valores/'.$value["imagen"].'" alt="Attachment Image" style="width: 150px; height: 80px;">
					                		<div class="attachment-pushed">
					                  			<div class="attachment-text">
					                  				'.$value["dsc_valor"].'
					                  			</div>
					                		</div>
					              		</div>
					             	</div>';
							}//foreach
							?>		
						</div>
		            </div>
	          	</div>
	        </div>
	    </div>	    
	</section>
</div>