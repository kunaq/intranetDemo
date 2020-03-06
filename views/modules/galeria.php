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
      Galería	    
    </h1>
    <ol class="breadcrumb">	      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>	      
      <li class="active">Galería</li>	    
    </ol>
	</section>	
	<section class="content">
    <?php
    if($_SESSION["flgEmpresa"] == 'SI'){
      echo '<div class="row">
          <div class="col-md-12">
        <button class="btn btn-primary btn-agregar-kq" data-toggle="modal" data-target="#modalGaleria" id="btnAgregarGaleria">Agregar Galería</button>
          </div>
        </div><br>';
    }
    ?>
		<div class="row rowGaleria">
      <?php
      $item = null;
      $valor = null;
      $entrada = null;
      $galeria = ControladorGaleria::ctrMostrarGaleria($item,$valor,$entrada);
      if(count($galeria) > 0){
        foreach ($galeria as $key => $value) {
          echo '<div class="col-lg-4 col-xs-6">           
                  <div class="small-box" style="background-color: #f9f9f9 !important; color: #000;">
                    <div class="inner">';
          $itemDetalle = "cod_galeria";
          $valorDetalle = $value["cod_galeria"];
          $entrada = "cantidadFotosXGaleria";
          $cantidadFotos = ControladorGaleria::ctrMostrarGaleriaDetalle($itemDetalle,$valorDetalle,$entrada);
                      echo '<h3>'.$cantidadFotos["cantidad"].'<span style="font-size: 20px;"> fotos</span></h3>
                      <p>'.$value["dsc_galeria"].'</p>
                    </div>
                    <div class="icon">
                      <i class="fa fa-bank"></i>
                    </div>';
                    
                    if($_SESSION["flgEmpresa"] == 'SI'){
                      echo '<a href="index.php?ruta=tipoGaleria&codigo='.$value["cod_galeria"].'" class="small-box-footer" style="width: 88%;float: left;">
                      Ver todas las fotos <i class="fa fa-arrow-circle-right"></i>
                      </a>
                      <a href="javascript: void(0)" class="small-box-footer btnEliminarGaleria" codGaleria="'.$value["cod_galeria"].'" style="width: 6%;float: right;"><i class="fa fa-remove " style="color: #000;" title="Eliminar"></i></a>
                    <a href="javascript: void(0)" class="small-box-footer btnEditarGaleria" style="width: 6%;float: right;" title="Editar" data-toggle="modal" data-target="#modalGaleria" codGaleria="'.$value["cod_galeria"].'">
                      <i class="fa fa-edit" style="color: #000;"></i></a>';
                    }else{
                      echo '<a href="index.php?ruta=tipoGaleria&codigo='.$value["cod_galeria"].'" class="small-box-footer" style="width: 100%;float: left;">
                      Ver todas las fotos <i class="fa fa-arrow-circle-right"></i>
                      </a>';
                    }
                  echo '</div>              
                </div>';
        }//foreach
      }else{
        echo '<span style="font-weight:bold; font-size:large; padding-left:17px;">No hay ninguna galería</span>';
      }      
      ?>
		</div>
	</section>
</div>
<!--=====================================
MODAL GALERIA
======================================-->
<?php
include "modals/galeria.modal.php";
?>
