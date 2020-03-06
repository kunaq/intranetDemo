<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/ordenProduccion.controlador.php";
require_once "../controllers/area.controlador.php";
require_once "../models/ordenProduccion.modelo.php";
require_once "../models/area.modelo.php";

class TablaResumenOP{

	public function mostrarTablaResumenOP(){
		$item1 = (isset($_GET["fechaInicial"]) && $_GET["fechaInicial"] != "") ? "fch_compromiso" : null;
		$valor1 = (isset($_GET["fechaInicial"]) && $_GET["fechaInicial"] != "") ? $_GET["fechaInicial"] : null;
		$item2 = (isset($_GET["fechaFinal"]) && $_GET["fechaFinal"] != "") ? "fch_compromiso" : null;
		$valor2 = (isset($_GET["fechaFinal"]) && $_GET["fechaFinal"] != "") ? $_GET["fechaFinal"] : null;
		$item3 = (isset($_GET["estado"]) && $_GET["estado"] != "") ? "cod_estado" : null;
		$valor3 = (isset($_GET["estado"]) && $_GET["estado"] != "") ? $_GET["estado"] : null;

		if(isset($_GET["fechaValidada"]) && $_GET["fechaValidada"] != ""){
			if($_GET["fechaValidada"] == 'MDF'){
				$item4 = 'flg_fch_validada_modificado';
				$valor4 = 'SI';
			}else{
				$item4 = 'flg_fch_validada';
				$valor4 = $_GET["fechaValidada"];
			}
		}else{
			$item4 = $valor4 = null;
		}
		$entrada = 'datatableListado';
		$listArea = $_GET["listAreas"];
		$listArea = explode(",", $listArea);
        $ordenProduccion = ControladorOrdenProduccion::ctrMostrarResumenOrdenProduccion($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$entrada);
        if(count($ordenProduccion) > 0){
	        $datosJson = '{
			 	"data": [';
				 	for ($i=0; $i < count($ordenProduccion) ; $i++) {
				 		$dscArea = '';
				 		/*=============================================
						MOSTRAR AREAS RELACIONADAS
						=============================================*/
						$item1 = 'cod_localidad';
						$valor1 = $ordenProduccion[$i]["cod_localidad"];
						$item2 = 'num_orden_produccion';
						$valor2 = $ordenProduccion[$i]["num_orden_produccion"];
						$item3 = "num_linea_orden_detalle";
						$valor3 = $ordenProduccion[$i]["num_linea"];
						$item4 = 'cod_producto'; 
						$valor4 = $ordenProduccion[$i]["cod_producto"];
						$item5 = 'cod_estado';
						$valor5 = $_GET["estado"];
						$entrada = "dtbleVinculoOrdPrd";
						$area = ControladorArea::ctrMostrarArea($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$item5,$valor5,$entrada);
						$columArea = '';
						$fechaValidada = ($ordenProduccion[$i]["fch_validada"] != '') ? dateFormat($ordenProduccion[$i]["fch_validada"]) : '';
						if($ordenProduccion[$i]['flg_fch_validada_modificado'] == 'SI'){
							$color = "<p style='color:#12bd12'>".$fechaValidada."</p>";
						}else if($ordenProduccion[$i]['flg_fch_validada'] == 'NO' || $ordenProduccion[$i]['flg_fch_validada'] == NULL || $ordenProduccion[$i]['flg_fch_validada'] == ''){
							$color = "<p style='color:#ff0000'>".$fechaValidada."</p>";
						}else if($ordenProduccion[$i]['flg_fch_validada'] == 'SI'){
							$color = "<p style='color:#0000ff'>".$fechaValidada."</p>";
						}
						$botones = "<div class='btn-group'><button class='btn btn-sm btn-warning btnEditarOrdProd' title='Editar' codLocalidad='".$ordenProduccion[$i]["cod_localidad"]."' numOrdenProduccion=".$ordenProduccion[$i]["num_orden_produccion"]."><i class='fa fa-pencil-square-o'></i></button></div>";						
						//$botonEstado = "<button class='btn btn-sm' style='background-color: ".$ordenProduccion[$i]["dsc_color"].";color:#fff;'><i class='fa fa-lightbulb-o'></i></button>";
						$estTerminado = 'NO';
						for ($j=0; $j<count($listArea); $j++){
							$estTerminado = 'SI';
							//echo 'a444';
							if(count($area) > 0){
								foreach ($area as $key => $value) {
									if(isset($value["cod_area"])){
										if($value["flg_facturacion"] == 'NO'){
											if($value["flg_terminado"] == 'NO'){
												$estTerminado = 'NO';
											}
										}
									}
								}//foreach
							}else{
								$estTerminado = 'NO';
							}
						}//for
						if($ordenProduccion[$i]["difFechaValidada"] > 0 && $ordenProduccion[$i]["difFechaValidada"] <= 7){
							$colorFch = '#ffa500';
						}else if($estTerminado == 'SI'){
							$colorFch = '#3dd27a';
						}else if($ordenProduccion[$i]["difFechaValidada"] <= 0 && $estTerminado == 'NO'){
							$colorFch = 'red';
						}else{
							$colorFch = '#fff';
						}
						$botonEstado = "<button class='btn btn-sm' style='background-color: ".$colorFch.";color:#000;'><i class='fa fa-lightbulb-o'></i></button>";
				 		$datosJson .= '[
				 			"'.$botonEstado.'",	
				 			"'.escapeComillasJson($ordenProduccion[$i]["dsc_razon_social"]).'",
				 			"'.$ordenProduccion[$i]["num_orden_produccion"].'",
				 			"'.escapeComillasJson($ordenProduccion[$i]["dsc_estado"]).'",
							"'.$color.'",';
						for ($j=0; $j <count($listArea) ; $j++) {
							$dscArea = $modalArea = '';
							foreach ($area as $key => $value) {
								if(isset($value["cod_area"])){
									if($value["cod_area"] == $listArea[$j]){
										$modalArea = ($value["flg_facturacion"] == 'SI') ? "modalFacturacionAreaOrdProd" : "modalAreaOrdProd";
										$btnArea = ($value["flg_facturacion"] == 'SI') ? "btnEditarFacturacionAreaOrdProd" : "btnEditarAreaOrdProd";
										$dscArea = "<button class='btn btn-sm' style='background-color: ".$value["dsc_color"].";color:#fff;' title='Ver' codLocalidad='".$value["cod_localidad"]."' numOrdenProd='".$value["num_orden_produccion"]."' codArea='".$value["cod_area"]."' flgFacturacion='".$value["flg_facturacion"]."' data-toggle='modal'><i class='fa fa-eye'></i></button>";
									}
								}
							}//foreach
							$datosJson .= '"'.$dscArea.'",';
						}//for
						$datosJson .= '"'.$botones.'"							
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
	}//function mostrarTablaContacto
}

/*=============================================
ACTIVAR TABLA ORDEN DE PRODUCCION
=============================================*/
$activarTablarResumenOP = new TablaResumenOP();
if(isset($_GET["entrada"]) && $_GET["entrada"] == 'tabResumenOP'){
	$activarTablarResumenOP -> mostrarTablaResumenOP();
}