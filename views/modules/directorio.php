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
	      Directorio	    
	    </h1>
	    <ol class="breadcrumb">	      
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>	      
	      <li class="active">Directorio</li>	    
	    </ol>
	</section>
	<section class="content">
		<div class="box" style="border-top: 3px solid #d1d1d1;">
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped tablaDirectorio" width="100%">
						<thead class="thead-kq-3">
							<tr>
								<th class="text-center vertical-bottom-kq">&nbsp;</th>
								<th class="text-center vertical-bottom-kq">Foto</th>
								<th class="text-center vertical-bottom-kq">Nombre</th>
								<th class="text-center vertical-bottom-kq">Cargo</th>
								<th class="text-center vertical-bottom-kq">Correo</th>
								<th class="text-center vertical-bottom-kq">Teléfono</th>
								<th class="text-center vertical-bottom-kq">Anexo</th>
								<th class="text-center vertical-bottom-kq">Fecha de Ingreso</th>
								<th class="text-center vertical-bottom-kq">Fecha de Cumpleaños</th>
								<th></th>
								<th class="text-center vertical-bottom-kq">Acciones</th>
								<th></th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					<input type="hidden" id="permisoDirectorio" value="<?php echo $_SESSION["flgEmpresa"]; ?>">
				</div>
			</div>
		</div>
	</section>
</div>
<!--=====================================
MODAL DIRECTORIO
======================================-->
<?php
include "modals/directorio.modal.php";
?>