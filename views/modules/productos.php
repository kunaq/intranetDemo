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
	      Productos	    
	    </h1>
	    <ol class="breadcrumb">	      
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>	      
	      <li class="active">Productos</li>	    
	    </ol>
	</section>
	<section class="content">
		<div class="box" style="border-top: 3px solid #d1d1d1;">
			<?php
    		if($_SESSION["flgCotizacion"] == 'SI'){
    			echo '<div class="box-header with-border">
					<button class="btn btn-primary btn-agregar-kq btnAgregarProducto" data-toggle="modal" data-target="#modalProducto">Agregar producto</button>
				</div>';
    		}
    		?>
			<div class="box-body">
				<table class="table table-bordered table-striped tablaProducto" width="100%">
					<thead class="thead-kq-2">
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Código</th>
							<th class="text-center">Descripción</th>
							<th class="text-center">Tipo</th>
							<th class="text-center">Acciones</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
	      	<div class="box-footer">
		        <button class="btn btn-default pull-right hidden" style="background-color: #e2e0e0;">            
		            <i class="fa fa-cloud-upload"></i> Importar
		        </button>
		        <a href="views/modules/descargar-reporte.php?reporte=reporteProductos">
		          <button class="btn btn-default pull-right" style="margin-right: 5px; background-color: #e2e0e0;">
		              <i class="fa fa-cloud-download"></i> Exportar
		          </button>
		        </a>
		        <input type="hidden" id="perfilAdministradorProducto" value="<?php echo $_SESSION["perfilAdministrador"]; ?>">   
 		 	</div>
		</div>
	</section>
</div>
<!--=====================================
MODAL PRODUCTO
======================================-->
<?php
include "modals/producto.modal.php";
}else{
	include "403.php";
}
?>