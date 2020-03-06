<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/contacto.controlador.php";
require_once "../models/contacto.modelo.php";
class TablaContacto{
	/*=============================================
	MOSTRAR TABLAS MAESTRAS
	=============================================*/
	public function mostrarTablaCntoXCte(){
		$item1 = 'cod_cliente';
		$valor1 = $_GET["cliente"];
		$entrada = $_GET["entrada"];
        $contacto = ControladorContacto::ctrMostrarContacto($item1,$valor1,$entrada);
        if(count($contacto) > 0){
	        $datosJson = '{
			 	"data": [';
				 	for ($i=0; $i < count($contacto) ; $i++) {
				 		/*=============================================
						TRAEMOS LA FECHA DE ATENCION y FECHA DE REGISTRO DE CONTACTO
						=============================================*/
						$fechaAtencion = dateFormat($contacto[$i]["fch_atencion"]);
						$fechaRegistroContacto = dateFormat($contacto[$i]["fch_registro_contacto"]);
				 		/*=============================================
						TRAEMOS LAS ACCIONES
						=============================================*/
						$botones = "";
						if($_SESSION["perfilAdministrador"] == 'SI'){
							$disabled = ($contacto[$i]["flg_atendido"] == 'SI') ? 'disabled' : '';
							$title = ($contacto[$i]["flg_atendido"] == 'SI') ? 'No se puede eliminar ya que está en estado atendido' : 'Eliminar'; 
							$botones = "<div class='btn-group'><button class='btn btn-sm btn-editarContacto btnEditarContacto' data-toggle='modal' data-target='#modalContacto' codContacto='".$contacto[$i]["cod_contacto"]."' title='Editar' style='background-color:#2ac197;border-color:#299e7e;'><i class='fa fa-pencil-square-o'></i></button><button class='btn btn-sm btn-danger btnEliminarContacto' codContacto='".$contacto[$i]["cod_contacto"]."' title='".$title."' $disabled><i class='fa fa-trash'></i></button></div>";
						}				 		
				 		$datosJson .= '[ 
							"'.($i+1).'",
							"'.$fechaRegistroContacto.'",
							"'.escapeComillasJson($contacto[$i]["dsc_razon_social"]).'",
							"'.escapeComillasJson($contacto[$i]["dsc_canal_contacto"]).'",
							"'.escapeComillasJson($contacto[$i]["dsc_tipo_contacto"]).'",
							"'.escapeComillasJson($contacto[$i]["dsc_estado_contacto"]).'",
							"'.$fechaAtencion.'",
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
	}//function mostrarTablaCntoXCte
	public function mostrarTablaCntoAgrupCte(){
		$item1 = $valor1 = null;
		$entrada = $_GET["entrada"];
		$contacto = ControladorContacto::ctrMostrarContacto($item1,$valor1,$entrada);
		if(count($contacto) > 0){
			$datosJson = '{
				"data": [';
				 	for ($i=0; $i < count($contacto) ; $i++) {
				 		$datosJson .= '[ 
							"'.($i+1).'",
							"'.escapeComillasJson($contacto[$i]["dsc_razon_social"]).'",
							"'.$contacto[$i]["cod_cliente"].'"
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
	}//function mostrarTablaCntoAgrupCte
}//class TablaContacto
/*=============================================
ACTIVAR TABLA CONTACTO
=============================================*/
$activarTablaContacto = new TablaContacto();
if($_GET["entrada"] == 'vtnCntoAgrupCte'){
	$activarTablaContacto -> mostrarTablaCntoAgrupCte();
}else if($_GET["entrada"] == 'vntCntoXCte'){
	$activarTablaContacto -> mostrarTablaCntoXCte();	
}
