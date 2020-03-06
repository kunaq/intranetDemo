<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/productos.controlador.php";
require_once "../models/productos.modelo.php";
class TablaProductos{
	/*=============================================
	MOSTRAR TABLAS PRODUCTO
	=============================================*/
	public function mostrarTablaProductos(){
		$item = null;
        $valor = null;
        $entrada = null;
        $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $entrada);
        if(count($productos) > 0){
        	$datosJson = '{
			 	"data": [';
				 	for ($i=0; $i < count($productos) ; $i++) {
				 		/*=============================================
						TRAEMOS LAS ACCIONES
						=============================================*/
						$botones = "";
						if($_SESSION["perfilAdministrador"] == 'SI'){
				 			$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarProducto' data-toggle='modal' data-target='#modalProducto' codProducto='".$productos[$i]["cod_producto"]."' title='Editar'><i class='fa fa-pencil-square-o'></i></button><button class='btn btn-sm btn-danger btnEliminarProducto' codProducto='".$productos[$i]["cod_producto"]."' title='Eliminar'><i class='fa fa-trash'></i></button></div>";
				 		}
				 		$datosJson .= '[
							"'.($i+1).'",
							"'.$productos[$i]["cod_producto"].'",
							"'.escapeComillasJson($productos[$i]["dsc_producto"]).'",
							"'.$productos[$i]["dsc_tipo_producto"].'",
							"'.$botones.'"
						],';
				 	}			 	
					$datosJson = substr($datosJson, 0, -1);
				$datosJson .= '] 
			}';
        }else{
        	$datosJson = '{
				"data": []
			}';
        }
        echo $datosJson;
	}//function mostrarTablaProductos
	/*=============================================
	MOSTRAR TABLAS PRODUCTO / VENTANA ORDEN DE
	PRODUCCION
	=============================================*/
	public function mostrarTablaProductoVtnOrdPrd(){
		$item = $valor = null;
        $entrada = $_GET["entrada"];
        $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $entrada);
        if(count($productos) > 0){
        	$datosJson = '{
			 	"data": [';
				 	for ($i=0; $i < count($productos) ; $i++) {
				 		/*=============================================
						TRAEMOS LAS ACCIONES
						=============================================*/
						$botones = "";
						if($_SESSION["perfilAdministrador"] == 'SI'){
				 			$botones = "<div class='btn-group'></button><button class='btn btn-sm btn-danger btnEliminarProducto' codProducto='".$productos[$i]["cod_producto"]."' title='Eliminar'><i class='fa fa-trash'></i></button></div>";
				 		}
				 		$datosJson .= '[
							"'.($i+1).'",
							"'.escapeComillasJson($productos[$i]["dsc_producto"]).'",
							"12",
							"kg",
							"'.$botones.'"
						],';
				 	}			 	
					$datosJson = substr($datosJson, 0, -1);
				$datosJson .= '] 
			}';
        }else{
        	$datosJson = '{
				"data": []
			}';
        }
        echo $datosJson;
	}//function mostrarTablaProductoVtnOrdPrd
}//class TablaProductos
/*=============================================
ACTIVAR TABLA PRODUCTO
=============================================*/
$activarTablaProductos = new TablaProductos();
if(isset($_GET["entrada"]) && ($_GET["entrada"] == 'vtnOrdenProduccion')){	
	$activarTablaProductos -> mostrarTablaProductoVtnOrdPrd();
}else{
	$activarTablaProductos -> mostrarTablaProductos();
}