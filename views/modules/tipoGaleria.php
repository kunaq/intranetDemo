<?php
if(!isset($_SESSION["iniciarSesionIntranet"]) &&  $_SESSION["iniciarSesionIntranet"] != "ok"){
  echo '<script>
    window.location = "inicio";
  </script>';
  return;
}
$item = "cod_galeria";
$valor = $_GET["codigo"];
$entrada = "obtenerDatosDesdeTipoGaleria";
$galeria = ControladorGaleria::ctrMostrarGaleria($item,$valor,$entrada);
?>
<div class="content-wrapper fondo-content-wrapper-kq">
	<section class="content-header">    
	    <h1 class="page-header color-h2-kq">	      
	      Galería:  <?php echo $galeria["dsc_galeria"]; ?>
	    </h1>
	    <ol class="breadcrumb">	      
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>	      
	      <li><a href="galeria">Galería</a></li>
	      <li class="active"><?php echo $galeria["dsc_galeria"]; ?></li>	    
	    </ol>
	</section>
	<section class="content">
		<?php
	    if($_SESSION["flgEmpresa"] == 'SI'){
	      echo '<div class="row">
	          <div class="col-md-12">
	        <button class="btn btn-primary btn-agregar-kq" data-toggle="modal" data-target="#modalTipoGaleria" id="btnAgregarTipoGaleria">Agregar imagen</button>
	          </div>
	        </div><br>';
	    }
	    ?>
		<div class="row">
			<div id="gallery" style="display:none;">
				<?php
				$item = "cod_galeria";
				$valor = $_GET["codigo"];
				$entrada2 = "listaTipoGaleria";
				$fotoTipoGaleria = ControladorGaleria::ctrMostrarGaleriaDetalle($item,$valor,$entrada2);
				if(count($fotoTipoGaleria) > 0){
					foreach ($fotoTipoGaleria as $key => $value) {
						echo '<a>
								<img alt=""
							     src="archivos/galeria/'.$value["imagen"].'"
							     data-image="archivos/galeria/'.$value["imagen"].'"
							     data-description="">
							</a>';
					}//foreach
			echo '</div>';
				}else{
					echo '</div>';
					echo '<span style="font-weight:bold; font-size:large; padding-left:17px;">No hay ninguna imagen</span>';
				}				
				?>
			<input type="hidden" id="cantFotosGaleriaDetalle" value="<?php echo count($fotoTipoGaleria); ?>">
			<input type="hidden" id="permisoTipoGaleria" value="<?php echo $_SESSION["flgEmpresa"]; ?>">
		</div>
	</section>
</div>
<!--=====================================
MODAL TIPO GALERIA
======================================-->
<?php
include "modals/tipoGaleria.modal.php";
?>