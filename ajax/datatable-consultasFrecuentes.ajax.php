<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/consultaFrecuente.controlador.php";
require_once "../models/consultaFrecuente.modelo.php";
class TablaConsultaFrecuente{
	/*=============================================
	MOSTRAR TABLA CONSULTA FRECUENTE
	=============================================*/
	public function mostrarTablaConsultaFrecuente(){
		$item = null;
        $valor = null;
        $entrada = null;
        $consultas = ControladorConsultaFrecuente::ctrMostrarConsultaFrecuente($item,$valor,$entrada);
        $datosAdjuntos = '';
        if(count($consultas) > 0){
        	$datosJson = '{
			 	"data": [';
				 	for ($i=0; $i < count($consultas) ; $i++) {
				 		/*=============================================
						TRAEMOS DATOS ADJUNTOS
						=============================================*/
						if($consultas[$i]["dsc_ruta_archivo"] != ''){
							$datosAdjuntos = "<a href='archivos/consulta-frecuente/".escapeComillasJson2($consultas[$i]["dsc_ruta_archivo"])."' target='_blank'><button class='btn btn-success btn-xs' style='background-color:#337ab7;'>Ver archivo</button></a>";	
						}else{
							$datosAdjuntos = "<button class='btn btn-xs' style='background-color:#716b6b;border-color:#4c4545;color:#fff;' disabled title='No hay archivo'>Ver archivo</button>";
						}						
				 		/*=============================================
						TRAEMOS LAS ACCIONES
						=============================================*/
						$botones = "";
						if($_SESSION["flgEmpresa"] == 'SI'){
							$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarConsultaFrecuente' data-toggle='modal' data-target='#modalConsultaFrecuente' codConsultaFrecuente='".$consultas[$i]["cod_consulta"]."' title='Editar'><i class='fa fa-pencil-square-o'></i></button><button class='btn btn-sm btn-danger btnEliminarConsultaFrecuente' codConsultaFrecuente='".$consultas[$i]["cod_consulta"]."' imagenConsultaFrecuente='".escapeComillasJson2($consultas[$i]["dsc_ruta_archivo"])."' title='Eliminar'><i class='fa fa-trash'></i></button></div>";
						}
				 		$datosJson .= '[
							"'.($i+1).'",
							"'.escapeComillasJson($consultas[$i]["dsc_consulta"]).'",
							"'.escapeComillasJson($consultas[$i]["dsc_respuesta"]).'",
							"'.$datosAdjuntos.'",
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
	}//function mostrarTablaConsultaFrecuente
}//class TablaConsultaFrecuente
/*=============================================
ACTIVAR TABLA CONSULTA FRECUENTE
=============================================*/
$activarTablaConsultaFrecuente = new TablaConsultaFrecuente();
$activarTablaConsultaFrecuente -> mostrarTablaConsultaFrecuente();