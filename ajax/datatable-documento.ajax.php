<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/documento.controlador.php";
require_once "../models/documento.modelo.php";
class TablaDocumento{
	/*=============================================
	MOSTRAR TABLAS DOCUMENTO / VENTANA ORDEN DE
	PRODUCCION
	=============================================*/
	public function mostrarTablaDocumentoVtnOrdPrd(){
		$item1 = 'flg_activo';
		$valor1 = 'SI';
        $item2 = "cod_localidad";
		$valor2 = $_GET["localidad"];
		$item3 = "num_orden_produccion";
		$valor3 =$_GET["numOrdenProd"];
        $entrada = $_GET["entrada"];
        $documento = ControladorDocumento::ctrMostrarDocumento($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada);
        if(count($documento) > 0){
        	$datosJson = '{
			 	"data": [';
				 	for ($i=0; $i < count($documento) ; $i++) {
				 		$checked = ($documento[$i]["flgDocumentoNumOrdProd"] == 'SI') ? 'checked' : '';
				 		$disabled = ($_GET["flgAnulado"] == 'SI') ? 'disabled' : '';
				 		$checkFila = "<input class='checkDocumentoOrdPrd' codDocumento='".$documento[$i]["cod_documento"]."' numLinea='".$documento[$i]["num_linea"]."' type='checkbox' value='".$documento[$i]["flgDocumentoNumOrdProd"]."' $checked $disabled />";
				 		$checkHidden = "<input class='checkDocumentoOrgOrdPrd' type='hidden' value='".$documento[$i]["flgDocumentoNumOrdProd"]."' $checked />";

				 		if($documento[$i]["flgDocumentoNumOrdProd"] == 'SI'){
				 			$botones = "<div class='btn-group'><button type='button' class='btn btn-sm btn-warning btnVerUsrDocOrdProd' title='Usuarios' codLocalidad='".$documento[$i]["cod_localidad"]."' numOrdenProduccion=".$documento[$i]["num_orden_produccion"]." numLinea=".$documento[$i]["num_linea"]." data-toggle='modal' data-target='#modalUsuarioDocOrdProd'><i class='fa fa-pencil-square-o'></i></button></div>";		
				 		}else{
				 			$botones = '';
				 		}
				 		$datosJson .= '[
							"'.($i+1).'",
							"'.escapeComillasJson($documento[$i]["dsc_documento"]).'",
							"'.$checkFila.'",
							"'.$botones.'",
							"'.$checkHidden.'"
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
	}//function mostrarTablaDocumentoVtnOrdPrd
}//class TablaDocumento
/*=============================================
ACTIVAR TABLA DOCUMENTO
=============================================*/
$activarTablaDocumento = new TablaDocumento();
if(isset($_GET["entrada"]) && ($_GET["entrada"] == 'vtnOrdenProduccion')){	
	$activarTablaDocumento -> mostrarTablaDocumentoVtnOrdPrd();
}