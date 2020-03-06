<?php
if(!isset($_SESSION["iniciarSesionIntranet"]) &&  $_SESSION["iniciarSesionIntranet"] != "ok"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
?>
<div class="content-wrapper fondo-content-wrapper-kq-2">
	<section class="content-header">
	    <h1 class="page-header color-h3-kq">
	      Contactos con clientes
	    </h1>
	    <ol class="breadcrumb">
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
	      <li class="active">Contactos con cliente</li>
	    </ol>
	</section>
	<section class="content">
		<div class="box" style="border-top: 3px solid #d1d1d1;">
			<?php
    		if($_SESSION["perfilAdministrador"] == 'SI'){
    			echo '<div class="box-header with-border">
					<a href="contacto">
						<button class="btn btn-primary btn-agregar2-kq">Agregar contacto</button>
					</a>
				</div>';
    		}
    		?>
			<div class="box-body table-responsive">
				<table class="table table-bordered table-striped" width="100%" id="tablaClienteCnto">
					<thead class="thead-kq-4">
						<tr>
							<th class="tblCntoCteWidthCorl">&nbsp;</th>
							<th class="text-center tblCntoCteWidthDsc">Cliente</th>
							<th class="hidden"></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
				<input type="hidden" id="perfilAdministradorContacto" value="<?php echo $_SESSION["perfilAdministrador"]; ?>">
			</div>
			<div class="box-header divListadoCntoXCte hidden">
				<h3>Listado</h3>
			</div>
			<div class="box-body divListadoCntoXCte hidden">
				<div class="table-responsive">
					<table class="table table-bordered table-striped tablaKq" width="100%" id="tablaListaCntoXCte">
						<thead class="thead-kq-4">
							<tr>
								<th style="width: 3%">#</th>
								<th class="text-center" style="width: 13%">Fecha registro</th>
								<th class="text-center" style="width: 24%">Cliente</th>
								<th class="text-center" style="width: 12%">Canal</th>
								<th class="text-center" style="width: 12%">Tipo</th>
								<th class="text-center" style="width: 12%">Estado</th>
								<th class="text-center" style="width: 13%">Fecha atención</th>
								<th class="text-center" style="width: 11%">Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
</div>
