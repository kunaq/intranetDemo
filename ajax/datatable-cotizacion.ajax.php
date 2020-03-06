<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/estadoCotizacion.controlador.php";
require_once "../controllers/cotizacion.controlador.php";
require_once "../models/estadoCotizacion.modelo.php";
require_once "../models/cotizacion.modelo.php";
class TablaCotizacion{
	/*=============================================
	MOSTRAR TABLA COTIZACION
	=============================================*/
	public function mostrarTablaCotizacion(){
		$valor1 = (isset($_GET["cliente"]) && $_GET["cliente"] != "") ? $_GET["cliente"] : null;
		$valor2 = (isset($_GET["producto"]) && $_GET["producto"] != "") ? $_GET["producto"] : null;
		$valor3 = (isset($_GET["fechaInicial"]) && $_GET["fechaInicial"] != "") ? $_GET["fechaInicial"] : null;
		$valor4 = (isset($_GET["fechaFinal"]) && $_GET["fechaFinal"] != "") ? $_GET["fechaFinal"]: null;
		$valor5 = null;
		$entrada = (isset($_GET["entrada"]) && $_GET["entrada"] != "") ? $_GET["entrada"]: null;
		$cotizacion = ControladorCotizacion::ctrMostrarCotizacion($valor1,$valor2,$valor3,$valor4,$valor5,$entrada);
        $itemEstado1 = 'flg_aprobado';
        $valorEstado1 = 'SI';
        $entrada = null;
        $estadoAprobado = ControladorEstadoCotizacion::ctrMostrarEstadoCotizacion($itemEstado1,$valorEstado1,$entrada);
        $itemEstado2 = 'flg_rechazado';
        $valorEstado2 = 'SI';
        $estadoRechazado = ControladorEstadoCotizacion::ctrMostrarEstadoCotizacion($itemEstado2,$valorEstado2,$entrada);
        //var_dump($estadoAprobado);
        if(count($cotizacion) > 0){
        	$datosJson = '{
			 	"data": [';
				 	for ($i=0; $i < count($cotizacion); $i++) {
				 		$botones = "";
				 		/* OCULTO, NO SE NECESITA, YA FUNCIONA TODOS SUS ACCIONES */
				 		//$buttonELiminar = "<button class='btn btn-sm btn-danger btnEliminarCotizacion' codCotizacion='".$cotizacion[$i]["cod_cotizacion"]."' title='Eliminar'><i class='fa fa-trash'></i></button>"
				 		/*=============================================
						TRAEMOS LAS ACCIONES
						=============================================*/
						$botones .= "<div class='btn-group'>";
						$botones .= "<button class='btn btn-sm btn-warning btnEditarCotizacion' codCotizacion='".$cotizacion[$i]["cod_cotizacion"]."' title='Editar'><i class='fa fa-pencil-square-o'></i></button>";
						if($_SESSION["flgCotizacionClonar"] == 'SI'){
							$botones .= "<button class='btn btn-sm btn-success btnClonarCotizacion' codCotizacion='".$cotizacion[$i]["cod_cotizacion"]."' title='Clonar'><i class='fa fa-clone'></i></button>";
						}
						if($_SESSION["flgCotizacionImpresionNormal"] == 'SI'){
							$botones .= "<button class='btn btn-sm btn-info btnImprimirCotizacion_1' codCotizacion='".$cotizacion[$i]["cod_cotizacion"]."' title='Impresión normal'><i class='fa fa-print'></i></button>";
						}
						if($_SESSION["flgCotizacionEnviarCorreo"] == 'SI'){
							$botones .= "<button class='btn btn-sm btn-primary btnEnviarCorreoCotizacion' codCotizacion='".$cotizacion[$i]["cod_cotizacion"]."' title='Enviar Correo' data-toggle='modal' data-target='#modalEnviarCorreo'><i class='fa fa-envelope'></i></button>";
						}						
						if($_SESSION["flgCotizacionImpresionReducida"] == 'SI'){
							$botones .= "<button class='btn btn-sm btn-Impresion_2 btnImprimirCotizacion_2' codCotizacion='".$cotizacion[$i]["cod_cotizacion"]."' style='background-color: #a09c9c; border-color:#9a8e8e; color:#fff;' title='Impresión simplificada'><i class='glyphicon glyphicon-print'></i></button>";
						}
						$botones .= "</div>";
				 		/*=============================================
						TRAEMOS DATOS ADJUNTOS
						=============================================*/
						$itemDatosAjuntos = "cod_cotizacion";
        				$valorDatosAjuntos = $cotizacion[$i]["cod_cotizacion"];
						$datosAjuntos = ControladorCotizacion::ctrMostrarCotizacionDatosAdjuntos($itemDatosAjuntos, $valorDatosAjuntos);
						$dscTd = '';
						foreach ($datosAjuntos as $key => $value){
							$dscTd .= "<a class='btn btn-primary btn-sm btn-agregar-kq' href='archivos/cotizacion/".escapeComillasJson2($value["dsc_ruta_archivo"])."' target='_blank'>".escapeComillasJson($value["dsc_archivo"])."</a>&nbsp;&nbsp;&nbsp;";
						}
				 		/*=============================================
						TRAEMOS LA FECHA DE EMISION
						=============================================*/
						$fechaEmision = dateFormat($cotizacion[$i]["fch_emision"]);
				 		$datosJson .= '[ 
				 			"'.($i+1).'",
							"'.$cotizacion[$i]["cod_cotizacion"].'",
							"'.escapeComillasJson($cotizacion[$i]["dsc_razon_social"]).'",
							"'.str_replace("\r\n"," ",escapeComillasJson($cotizacion[$i]["dsc_referencia"])).'",
							"'.$cotizacion[$i]["dsc_simbolo"].'&nbsp;'.number_format($cotizacion[$i]["imp_total"],2).'",
							"'.$fechaEmision.'",
							"'.escapeComillasJson($cotizacion[$i]["dsc_nombres"]).'&nbsp;'.escapeComillasJson($cotizacion[$i]["dsc_apellido_paterno"]).'",
							"'.escapeComillasJson($cotizacion[$i]["dsc_estado_cotizacion"]).'",
							"'.$botones.'",
							"",
							"'.$dscTd.'",
							"'.$cotizacion[$i]["dsc_color"].'"					
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
	}//function mostrarTablaCotizacion
	/*=============================================
	MOSTRAR TABLA COTIZACION DESDE LA VENTANA DE
	ORDEN DE PRODUCCION
	=============================================*/
	public function mostrarTblCotizacionOrdPrd(){
        $valor1 = $_GET["codCliente"];
        $valor2 = $_GET["enUso"];
        $entrada = $_GET["entrada"];
        $valor3 = $valor4 = $valor5 = null;
        $cotizacion = ControladorCotizacion::ctrMostrarCotizacion($valor1,$valor2,$valor3,$valor4,$valor5,$entrada);
        if(count($cotizacion) > 0){
        	$datosJson = '{
			 	"data": [';
				 	for ($i=0; $i < count($cotizacion); $i++) {
				 		$fchEmision = ($cotizacion[$i]["fch_emision"] != '') ? dateFormat($cotizacion[$i]["fch_emision"]) : '';
				 		$datosJson .= '[
				 			"'.$cotizacion[$i]["dsc_orden_compra"].'",
				 			"'.$cotizacion[$i]["cod_cotizacion"].'",
				 			"'.$fchEmision.'",
				 			"'.$cotizacion[$i]["dsc_simbolo"].'&nbsp;'.number_format($cotizacion[$i]["imp_total"],2).'"
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
    }//function mostrarTblCotizacionOrdPrd
    /*=============================================
	MOSTRAR TABLA PRODUCTOS COTIZACION DESDE LA VENTANA DE
	ORDEN DE PRODUCCION
	=============================================*/
	public function mostrarTblProductoCotizacionOrdPrd(){
        $valor1 = $_GET["codCliente"];
        $valor2 = $_GET["ordenCompra"];
        $valor3 = $_GET["enUso"];
        $entrada = $_GET["entrada"];
        $valor4 = $valor5 = null;
        $productos = ControladorCotizacion::ctrMostrarCotizacion($valor1,$valor2,$valor3,$valor4,$valor5,$entrada);
        if(count($productos) > 0){
        	$datosJson = '{
			 	"data": [';
				 	for ($i=0; $i < count($productos); $i++) {
				 		$checkFila = "<input class='checkCtzPrdOrdPrd' type='checkbox' checked value='SI' />";
				 		$cantidad = "<input class='form-control text-right inputCtdPrdOrdPrd' type='number' value='".$productos[$i]["num_ctd"]."' />";
				 		$datosJson .= '[
				 			"'.$checkFila.'",
				 			"'.$productos[$i]["cod_cotizacion"].'",
				 			"'.escapeComillasJson($productos[$i]["dsc_producto"]).'",
				 			"'.$cantidad.'",
				 			"'.$productos[$i]["dsc_simbolo"].'",				 			
				 			"'.$productos[$i]["fchEmision_orden_compra"].'",
				 			"'.$productos[$i]["cod_producto"].'",
				 			"'.$productos[$i]["cod_unidad_medida"].'"
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
    }//function mostrarTblProductoCotizacionOrdPrd
}//class TablaCotizacion
/*=============================================
ACTIVAR TABLA COTIZACION
=============================================*/
$activarTablaCotizacion = new TablaCotizacion();
if(isset($_GET["entrada"]) && $_GET["entrada"] == 'datatablePrincipal'){
	$activarTablaCotizacion -> mostrarTablaCotizacion();	
}else if(isset($_GET["entrada"]) && $_GET["entrada"] == 'vtnOrdenProduccion'){
	$activarTablaCotizacion -> mostrarTblCotizacionOrdPrd();	
}else if(isset($_GET["entrada"]) && $_GET["entrada"] == 'vtnOrdenProduccionCtzPrd'){
	$activarTablaCotizacion -> mostrarTblProductoCotizacionOrdPrd();	
}
