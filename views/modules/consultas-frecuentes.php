<?php
if(!isset($_SESSION["iniciarSesionIntranet"]) &&  $_SESSION["iniciarSesionIntranet"] != "ok"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
?>
<div class="content-wrapper fondo-content-wrapper-kq">
	<section class="content-header">    
	    <h1 class="page-header color-h2-kq">	      
	      Consultas Frecuentes	    
	    </h1>
	    <ol class="breadcrumb">	      
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>	      
	      <li class="active">Consultas Frecuentes</li>	    
	    </ol>
	</section>	
	<section class="content">		
		<div class="box" style="border-top: 3px solid #d1d1d1;">
			<?php
    		if($_SESSION["flgEmpresa"] == 'SI'){
    			echo '<div class="box-header with-border">
				<button class="btn btn-primary btn-agregar-kq" data-toggle="modal" data-target="#modalConsultaFrecuente" id="btnAgregarConsultaFrecuente">
					Agregar consulta</button>
				</div>';
    		}
    		?>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped" width="100%" id="tablaConsultaFrecuente">
						<thead style="background: #d1d1d1; color: #544644;">
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">Consulta</th>
								<th class="text-center">Respuesta</th>
								<th class="text-center">Adjunto</th>
								<th class="text-center">Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>						
					</table>
					<input type="hidden" id="permisoConsultasFrecuente" value="<?php echo $_SESSION["flgEmpresa"]; ?>">
				</div>
			</div>
		</div>
	</section>
</div>
<!--=====================================
MODAL AGREGAR CONSULTA FRECUENTE
======================================-->
<?php
include "modals/consultaFrecuente.modal.php";
?>