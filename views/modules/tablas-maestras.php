<?php
if(!isset($_SESSION["iniciarSesionIntranet"]) &&  $_SESSION["iniciarSesionIntranet"] != "ok"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
if($_SESSION["perfilAdministrador"] == 'SI'){
?>
<div class="content-wrapper fondo-content-wrapper-kq-2">
	<section class="content-header">    
	    <h1 class="page-header color-h2-kq">	      
	      Tablas maestras	    
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>	      
	      <li class="active">Tablas maestras</li>	    
	    </ol>
	</section>
	<section class="content content-tablaMaestra">
		<div class="box" style="border-top: 3px solid #d1d1d1;">
			<div class="box-header with-border">
				<div class="row">
					<div class="col-md-4">
						<label>Tablas:</label>						
						<select class="form-control select2" style="width: 100%;" id="seleccioneTablas">
							<option disabled selected>Selecciona una tabla</option>
							<?php
							$item = null;
							$valor = null;
							$tablas = ControladorTablaMaestra::ctrMostrarTablaMaestra($item,$valor);
							foreach ($tablas as $key => $value) {								
								echo '<option value="'.$value["cod_tabla_maestra"].'">'.$value["dsc_tabla_maestra"].'</option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class="divAgregar">					
				</div>
			</div>
			<div class="box-body table-responsive">
				<table class="table table-bordered table-striped tablasMaestras" width="100%" id="tablasMaestras">
					<thead class="thead-kq-2">
						<th class="text-center" style="width: 6%;">#</th>
						<th class="text-center" style="width: 79%;">Descripción</th>
						<th class="text-center" style="width: 15%;">Acciones</th>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</section>
</div>
<div class="modalAgregar"></div>
<?php
}else{
	include "403.php";
}
?>
