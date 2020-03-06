<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/ordenProduccion.controlador.php";
require_once "../controllers/area.controlador.php";
require_once "../models/ordenProduccion.modelo.php";
require_once "../models/area.modelo.php";
class TablaOrdenProduccion{
	/*=============================================
	MOSTRAR ORDEN DE PRODUCCION
	=============================================*/
	public function mostrarTablaOrdenProduccion(){
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
        $ordenProduccion = ControladorOrdenProduccion::ctrMostrarOrdenProduccion($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$entrada);
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
							"'.$ordenProduccion[$i]["num_linea"].'",
							"'.escapeComillasJson($ordenProduccion[$i]["dsc_producto"]).'",
							"'.number_format($ordenProduccion[$i]["ctd_orden"],2).'",
							"'.$ordenProduccion[$i]["dsc_simbolo"].'",
							"'.$color.'",';
						for ($j=0; $j <count($listArea) ; $j++) {
							$dscArea = $modalArea = '';
							foreach ($area as $key => $value) {
								if(isset($value["cod_area"])){
									if($value["cod_area"] == $listArea[$j]){
										$modalArea = ($value["flg_facturacion"] == 'SI') ? "modalFacturacionAreaOrdProd" : "modalAreaOrdProd";
										$btnArea = ($value["flg_facturacion"] == 'SI') ? "btnEditarFacturacionAreaOrdProd" : "btnEditarAreaOrdProd";
										$dscArea = "<button class='btn btn-sm $btnArea' style='background-color: ".$value["dsc_color"].";color:#fff;' title='Ver' codLocalidad='".$value["cod_localidad"]."' numOrdenProd='".$value["num_orden_produccion"]."' numLineaOrdenDetalle=".$value["num_linea_orden_detalle"]." codProducto='".$ordenProduccion[$i]["cod_producto"]."' codArea='".$value["cod_area"]."' flgFacturacion='".$value["flg_facturacion"]."' flgPedido='".$value["flg_pedido"]."' flgCompras='".$value["flg_compras"]."' flgDiseño='".$value["flg_diseño"]."' flgFabricacion='".$value["flg_fabricacion"]."' flgRevMold='".$value["flg_rev_mold"]."' flgPintura='".$value["flg_pintura"]."' flgControlCalidad='".$value["flg_control_calidad"]."' flgDespacho='".$value["flg_despacho"]."'  data-toggle='modal' data-target='#".$modalArea."'><i class='fa fa-eye'></i></button>";
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
	/*=============================================
	MOSTRAR OBSERVACIONES DE ORDEN DE PRODUCCION
	=============================================*/
	public function mostrarTablaObservacionOrdPrd(){
		$localidad = $_GET["localidad"];
		$ordenProduccion = $_GET["numOrdenProd"];
		$observacion = ControladorOrdenProduccion::ctrMostrarTablaObservacionOrdPrd($localidad,$ordenProduccion);
		if(count($observacion) > 0){
	        $datosJson = '{
			 	"data": [';
				 	for ($i=0; $i < count($observacion) ; $i++) {
				 		$fchRegistro = ($observacion[$i]["fch_registro"] != '') ? dateTimeFormat($observacion[$i]["fch_registro"]) : '';
				 		$chkAtm = ($observacion[$i]["flg_automatico"] == 'SI') ? 'checked' : '';
				 		$chkAutomatico = "<input type='checkbox' $chkAtm class='flat-red' disabled>";
				 		if($observacion[$i]["flg_automatico"] == 'SI'){
				 			$botones = "<div class='btn-group'><button type='button' class='btn btn-sm btn-warning' disabled><i class='fa fa-pencil-square-o'></i></button><button type='button' class='btn btn-sm btn-danger' disabled><i class='fa fa-trash'></i></button></div>";
				 		}else{
				 			$botones = "<div class='btn-group'><button type='button' class='btn btn-sm btn-warning btnEditarObservacion' data-toggle='modal' data-target='#modalObservacionOrdPrd' localidad='".$observacion[$i]["cod_localidad"]."' ordenProduccion='".$observacion[$i]["num_orden_produccion"]."' numLinea='".$observacion[$i]["num_linea"]."' title='Editar'><i class='fa fa-pencil-square-o'></i></button><button type='button' class='btn btn-sm btn-danger btnEliminarObservacion' localidad='".$observacion[$i]["cod_localidad"]."' ordenProduccion='".$observacion[$i]["num_orden_produccion"]."' numLinea='".$observacion[$i]["num_linea"]."'><i class='fa fa-trash'></i></button></div>";
				 		}
				 		if($_GET["flgAnulado"] == 'SI'){
				 			$datosJson .= '[
					 			"'.($i+1).'",
					 			"'.str_replace("\r\n"," ",escapeComillasJson($observacion[$i]["dsc_observacion"])).'",
					 			"'.$observacion[$i]["dsc_trabajador"].'",
					 			"'.$fchRegistro.'",				 			
					 			"'.$chkAutomatico.'"
					 		],';
				 		}else{
				 			$datosJson .= '[
					 			"'.($i+1).'",
					 			"'.str_replace("\r\n"," ",escapeComillasJson($observacion[$i]["dsc_observacion"])).'",
					 			"'.$observacion[$i]["dsc_trabajador"].'",
					 			"'.$fchRegistro.'",				 			
					 			"'.$chkAutomatico.'",
					 			"'.$botones.'"
					 		],';	
				 		}
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
	}//function mostrarTablaObservacionOrdPrd
	/*=============================================
	MOSTRAR DATABLE AREA X ORDEN PRODUCCION
	=============================================*/
	public function mostrarTabladatatableOrdProdArea(){
		$productos =  ControladorOrdenProduccion::ctrMostrarAreaXProductoDetalle($_GET["localidad"],$_GET["numOrdenProd"],$_GET["codArea"],$_GET["codProducto"]);
		if(count($productos) > 0){
	        $datosJson = '{
			 	"data": [';
			 		for ($i=0; $i < count($productos) ; $i++) {
			 			$fechaInicial = ($productos[$i]["fch_inicial"] != '') ? dateFormat($productos[$i]["fch_inicial"]) : '';
				 		$datosJson .= '[
					 			"'.number_format($productos[$i]["ctd_orden"],2).'",
					 			"'.$fechaInicial.'",
					 			"'.escapeComillasJson($productos[$i]["dsc_trabajador"]).'"
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
	}//function mostrarTabladatatableOrdProdArea
	/*=============================================
	MOSTRAR DATABLE AREA X ORDEN PRODUCCION DETALLE
	=============================================*/
	public function mostrarTabladatatableDtlOrdProdArea(){
		$localidad = $_GET["localidad"];
		$ordenProduccion = $_GET["numOrdenProd"];
		$lineaOrdenDetalle = $_GET["lineaOrdenDetalle"];
		$codProducto = $_GET["productoAreaOrdProd"];
		$codArea = $_GET["areaOrdProd"];
		$productos =  ControladorOrdenProduccion::ctrMostrarAreaXProductoDetalle($localidad,$ordenProduccion,$lineaOrdenDetalle,$codProducto,$codArea);
		if(count($productos) > 0){
	        $datosJson = '{
			 	"data": [';
			 	for ($i=0; $i < count($productos) ; $i++) {
			 			$fechaInicial = ($productos[$i]["fch_inicial"] != '') ? dateFormat($productos[$i]["fch_inicial"]) : '';
				 		$datosJson .= '[
				 				"'.$fechaInicial.'",
					 			"'.number_format($productos[$i]["num_cantidad"],2).'",					 			
					 			"'.escapeComillasJson($productos[$i]["dsc_trabajador"]).'"
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
	}//function mostrarTabladatatableOrdProdArea
}//class TablaContacto
/*=============================================
ACTIVAR TABLA ORDEN DE PRODUCCION
=============================================*/
$activarTablaOrdenProduccion = new TablaOrdenProduccion();
if(isset($_GET["entrada"]) && $_GET["entrada"] == 'tabObservaciones'){
	$activarTablaOrdenProduccion -> mostrarTablaObservacionOrdPrd();
}else if(isset($_GET["entrada"]) && $_GET["entrada"] == 'listadoPrincipal'){
	$activarTablaOrdenProduccion -> mostrarTablaOrdenProduccion();
}else if(isset($_GET["entrada"]) && $_GET["entrada"] == 'datatableOrdProdArea'){
	$activarTablaOrdenProduccion -> mostrarTabladatatableOrdProdArea();
}else if(isset($_GET["entrada"]) && $_GET["entrada"] == 'datatableDetalleOrdProdArea'){
	$activarTablaOrdenProduccion -> mostrarTabladatatableDtlOrdProdArea();
}