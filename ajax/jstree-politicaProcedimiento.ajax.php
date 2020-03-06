<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/politicaProcedimiento.controlador.php";
require_once "../models/politicaProcedimiento.modelo.php";
class ArbolPoliticaProcedimiento{
	/*=============================================
	MOSTRAR ARBOL POLITICA/PROCEDIMIENTO
	=============================================*/
	public function mostrarArbolPoliticaProcedimiento(){
		$item = null;
        $valor = null;
        $entrada = null;
        $politica = ControladorPoliticaProcedimiento::ctrMostrarPoliticaProcedimiento($item,$valor,$entrada);
        if(count($politica) > 0){
			$i3 = 1;
			$datosJson = '[';
				for ($i=0; $i < count($politica) ; $i++) {
					$botones = "";
					if($_SESSION["flgEmpresa"] == 'SI'){
						$botones = "<a><i class='fa fa-pencil-square-o btnEditarPoliticaProcedimiento' data-toggle='modal' data-target='#modalPoliticaProcedimiento' title='Editar' codPoliticaProcedimiento='".$politica[$i]["cod_politica"]."' style='cursor:pointer;padding-left:12px;'></i><i class='fa fa-trash btnEliminarPoliticaProcedimiento' codPoliticaProcedimiento='".$politica[$i]["cod_politica"]."' style='cursor:pointer;padding-left:12px;' title='Eliminar'></i></a>";
					}					
					$datosJson .= '{ 
						"id": "'.$politica[$i]["cod_politica"].'",
						"parent": "#",
						"type": "root",
						"text": "'.escapeComillasJson($politica[$i]["dsc_politica"]).''.$botones.'"
					},';
					$itemDetalle = "cod_politica";
					$valorDetalle = $politica[$i]["cod_politica"];
					$entradaDetalle = "listaDetalle";
					$detallePolitica = ControladorPoliticaProcedimiento::ctrMostrarPoliticaProcedimientoDetalle($itemDetalle,$valorDetalle,$entradaDetalle);
					$i3++;
					for ($i2=0; $i2 < count($detallePolitica); $i2++) {
						$i3++;
						$botonEliminar = "";
						if($_SESSION["flgEmpresa"] == 'SI'){
							$botonEliminar = "<a><i class='fa fa-trash btnEliminarPoliticaProcedimientoDetalle' codPoliticaProcedimiento='".$detallePolitica[$i2]["cod_politica"]."' numLinea='".$detallePolitica[$i2]["num_linea"]."' archivo='".escapeComillasJson2($detallePolitica[$i2]["dsc_ruta_archivo"])."' style='cursor:pointer;padding-left:12px;' title='Eliminar'></i></a>";
						}						
						$datosAdjuntos = "<a class='aDatoAdjuntoPolitica' href='archivos/politica-procedimiento/".escapeComillasJson2($detallePolitica[$i2]["dsc_ruta_archivo"])."#toolbar=0&navpanes=0&scrollbar=0' frameborder='0' scrolling='auto' style='width:100%; height:100%;' target='_blank'>".escapeComillasJson($detallePolitica[$i2]["dsc_archivo"])."</a>".$botonEliminar;
						$datosJson .= '{ 
							"id": "'.$detallePolitica[$i2]["dsc_ruta_archivo"].'",
							"parent": "'.$detallePolitica[$i2]["cod_politica"].'",
							"type": "file",
							"text": "'.$datosAdjuntos.'"
						},';
					}
				}//for
				$datosJson = substr($datosJson, 0, -1);
			$datosJson .= ']';
        }else{
        	$datosJson = '{
				"data": []
			}';
        }
        echo $datosJson;
    }//function mostrarArbolPoliticaProcedimiento
}//class TablaArbolPoliticaProcedimiento
/*=============================================
ACTIVAR ARBOL POLÍTICAS/PROCEDIMIENTOS
=============================================*/
$activarArbolPoliticaProcedimiento = new ArbolPoliticaProcedimiento();
$activarArbolPoliticaProcedimiento -> mostrarArbolPoliticaProcedimiento();