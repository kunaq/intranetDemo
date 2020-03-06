<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/area.controlador.php";
require_once "../controllers/estadoAreaOrdProd.controlador.php";
require_once "../models/area.modelo.php";
require_once "../models/estadoAreaOrdProd.modelo.php";
class TablaArea{
	/*=============================================
	MOSTRAR TABLAS AREA / VENTANA ORDEN DE
	PRODUCCION
	=============================================*/
	public function mostrarTablaAreaVtnOrdPrd(){
		$item1 = 'flg_activo';
		$valor1 = 'SI';
		$item2 = "cod_localidad";
		$valor2 = $_GET["localidad"];
		$item3 = "num_orden_produccion";
		$valor3 =$_GET["numOrdenProd"];
        $entrada = $_GET["entrada"];
        $area = ControladorArea::ctrMostrarArea($item1,$valor1,$item2,$valor2,$item3,$valor3,null,null,null,null,$entrada);
        if(count($area) > 0){
        	$datosJson = '{
			 	"data": [';
				 	for ($i=0; $i < count($area) ; $i++) {
				 		$checked = ($area[$i]["flgAreaNumOrdProd"] == 'SI') ? 'checked' : '';
				 		$disabled = ($_GET["flgAnulado"] == 'SI') ? 'disabled' : '';
				 		$checkFila = "<input codArea='".$area[$i]["cod_area"]."' codEstado='".$area[$i]["cod_estado"]."' class='checkAreaOrdPrd' type='checkbox' $checked value='".$area[$i]["flgAreaNumOrdProd"]."' $disabled />";
				 		$datosJson .= '[
							"'.($i+1).'",
							"'.escapeComillasJson($area[$i]["dsc_area"]).'",
							"'.$checkFila.'"
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
	}//function mostrarTablaAreaVtnOrdPrd
}//class TablaArea
/*=============================================
ACTIVAR TABLA AREA
=============================================*/
$activarTablaArea = new TablaArea();
if(isset($_GET["entrada"]) && ($_GET["entrada"] == 'vtnOrdenProduccion')){	
	$activarTablaArea -> mostrarTablaAreaVtnOrdPrd();
}