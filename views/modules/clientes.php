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
	    <h1 class="page-header color-h2-kq">	      
	      Clientes	    
	    </h1>
	    <ol class="breadcrumb">	      
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>	      
	      <li class="active">Clientes</li>	    
	    </ol>
	</section>
	<section class="content">
		<div class="box" style="border-top: 3px solid #d1d1d1;">
			<?php
    		if($_SESSION["perfilAdministrador"] == 'SI'){
    			echo '<div class="box-header with-border">					
					<button class="btn btn-primary btn-agregar-kq btnAgregarCliente" data-toggle="modal" data-target="#modalCliente">Agregar cliente</button>
				</div>';
    		}
    		?>
			<div class="box-body table-responsive">
				<table class="table table-bordered table-striped tablaCliente" width="100%">
					<thead class="thead-kq-2">
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">RUC</th>
							<th class="text-center">Razón Social</th>
                            <th class="text-center">Categoría</th>
							<th class="text-center">Pais</th>
                            <th class="text-center">Departamento</th>
                            <th class="text-center">Provincia</th>
                            <th class="text-center">Distrito</th>
							<th class="text-center">Acciones</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
				<input type="hidden" id="perfilAdministradorCliente" value="<?php echo $_SESSION["perfilAdministrador"]; ?>">
			</div>
            <div class="box-footer">
                <button class="btn btn-default pull-right hidden" style="background-color: #e2e0e0;">
                    <i class="fa fa-cloud-upload"></i> Importar
                </button>
                <a href="views/modules/descargar-reporte.php?reporte=reporteClientes">
                    <button class="btn btn-default pull-right" style="margin-right: 5px; background-color: #e2e0e0;">                    
                        <i class="fa fa-cloud-download"></i> Exportar
                    </button>
                </a>
            </div>
		</div>
	</section>   
</div>
<!--=====================================
MODAL CLIENTE
======================================-->
<?php
include "modals/cliente.modal.php";
?>