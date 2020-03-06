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
	      Noticia	    
	    </h1>
	    <ol class="breadcrumb">	      
	      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>	      
	      <li class="active">Noticia</li>	    
	    </ol>
	</section>	
	<section class="content">	
		<?php
	    if($_SESSION["flgEmpresa"] == 'SI'){
	      echo '<div class="row">
	          <div class="col-md-12">
	        	<button class="btn btn-primary btn-agregar-kq" data-toggle="modal" data-target="#modalNoticia" id="btnAgregarNoticia">Agregar Noticia</button>
	          </div>
	        </div><br>';
	    }
	    ?>
		<div class="row">				
			<div class="col-md-12">				
	                <?php
	                $item = null;
                    $valor = null;
                    $entrada = null;
                    $noticia = ControladorNoticia::ctrMostrarNoticia($item,$valor,$entrada);
                    if(count($noticia) > 0){
                    	echo '<ul class="products-list product-list-in-box border-bottom-kq" id="noticiaPaginate">';
                    	foreach ($noticia as $key => $value) {                    	
	                    	echo '<li class="item border-kq padding-kq liNoticia" style="height:140px;">
	                    			<div style="overflow:hidden;">
			                			<div class="product-img" style="width: 173px;">
			                    			<img src="archivos/noticia/'.$value["imagen"].'" alt="Product Image" style="width: 85%; height:100px;">                    
			                  			</div>
			                  			<div class="product-info" style="margin-left: 167px;">
			                    			<a href="index.php?ruta=ver-noticia&codigo='.$value["cod_noticia"].'" class="product-title">
			                      				'.$value["dsc_titulo"].'
			                    			</a>
				                    		<span class="label label-danger pull-right">'.dateTimeFormat($value["fch_publicacion"]).'</span>
				                    		<span class="product-description" style="white-space: normal;">
				                      			'.recortar_texto($value["dsc_resumen"],400);
				                      		if(strlen($value["dsc_resumen"]) > 400){
				                      			echo '<a href="index.php?ruta=ver-noticia&codigo='.$value["cod_noticia"].'">Ver mas</a>';	
				                      		}			                      		
				                    		echo '</span>	                    			
			                  			</div>
			                  		</div>';
			                  		if($_SESSION["flgEmpresa"] == 'SI'){
			                  			echo '<span class="pull-right">
			                    			<button class="btn btnEditarNoticia" style="background-color:#fff; padding: 3px;" data-toggle="modal" data-target="#modalNoticia" codNoticia="'.$value["cod_noticia"].'" title="Editar"><i class="fa fa-pencil-square-o" style="color: #000;"></i></button>
			                    			<button class="btn btnEliminarNoticia" codNoticia="'.$value["cod_noticia"].'" imagenNoticia="'.$value["imagen"].'" style="background-color:#fff; padding: 3px;" title="Eliminar"><i class="fa fa-trash" style="color: #000;"></i></button>
	                    				</span>';
			                  		}
		                		echo '</li>';                       
	                    }//foreach
	                    echo '</ul>';
                    }else{
                    	echo '<span style="font-weight:bold; font-size:large;">No hay ninguna noticia</span>';
                    }
                    
	                ?>
	            </ul>
			</div>
		</div>
	</section>
</div>
<!--=====================================
MODAL NOTICIA"
======================================-->
<?php
include "modals/noticia.modal.php";
?>

