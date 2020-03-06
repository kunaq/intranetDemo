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
	      Políticas	y Procedimientos    
	    </h1>
	    <ol class="breadcrumb">	      
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>	      
	      <li class="active">Políticas-Procedimientos</li>
	    </ol>
	</section>
	<section class="content">
		<?php
	    if($_SESSION["flgEmpresa"] == 'SI'){
	      echo '<div class="row">
	          <div class="col-md-12">
	        <button class="btn btn-primary btn-agregar-kq" data-toggle="modal" data-target="#modalPoliticaProcedimiento" id="btnAgregarPoliticaProcedimiento">Agregar Politica/Procedimiento</button>
	          </div>
	        </div><br>';
	    }
	    ?>
		<div class="row">
			<div class="col-md-12">				
				<div class="box box-solid">            			
        			<div class="callout callout-success" style="background-color: #fff !important; border-color: #000; color: #000 !important;" id="listaPoliticaProcedimiento">
						<!-- <ul>
							<li>Formatos</i>
								<ul>
									<li data-jstree='{ "icon":"fa fa-file-pdf-o" }'>Asignación de equipos de cómputo.pdf</li>
								</ul>
							</li>
							<li>Ficha de procesos</li>
		                    <li>Instrucciones</li>
		                    <li>Procedimientos
								<ul>
									<li data-jstree='{ "icon":"fa fa-file-pdf-o" }'>Procedimiento de solicitud de equipos de cómputo.pdf</li>
									<li data-jstree='{ "icon":"fa fa-file-pdf-o" }'>Procedimiento de atención de incidentes de soporte técnico.pdf</li>
								</ul>
		                    </li>
		                    <li>Planes y Programas</li>
		                    <li>Manuales</li>
		                    <li>Otros documentos</li>
						</ul> -->
          			</div>
            	</div>
			</div>
		</div>
	</section>
</div>
<?php
include "modals/politica-procedimiento.modal.php";
?>