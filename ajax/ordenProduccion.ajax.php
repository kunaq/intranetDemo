<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/ordenProduccion.controlador.php";
require_once "../models/ordenProduccion.modelo.php";
class AjaxOrdenProduccion{
	/*=============================================
	MOSTRAR ORDEN DE PRODUCCION
	=============================================*/
	public function ajaxMostrarOrdenProduccion(){
		$item1 = (isset($_POST["codLocalidad"])) ? "cod_localidad" : null;
		$valor1 = (isset($_POST["codLocalidad"])) ? $_POST["codLocalidad"] : null;
		$item2 = (isset($_POST["numOrdProd"])) ? "num_orden_produccion" : null;
		$valor2 = (isset($_POST["numOrdProd"])) ? $_POST["numOrdProd"] : null;
		$item3 = (isset($_POST["numLinea"])) ? "num_linea" : null;
		$valor3 = (isset($_POST["numLinea"])) ? $_POST["numLinea"] : null;
		$item4 = $valor4 = null;
		$entrada = $_POST["entrada"];
		$respuesta = ControladorOrdenProduccion::ctrMostrarOrdenProduccion($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$entrada);
		if($entrada == 'areaRelacOrdProd'){
			$respuesta["fecha"] = ($respuesta["fecha"] != '') ? dateFormat($respuesta["fecha"]) : '';
		}else if($entrada == 'productoRelacOrdProd'){
			foreach ($respuesta as $key => $value) {
				$respuesta[$key]["fch_entrega"] = ($respuesta[$key]["fch_entrega"] != '') ? dateFormat($respuesta[$key]["fch_entrega"]) : '';
				$respuesta[$key]["fch_validada"] = ($respuesta[$key]["fch_validada"] != '') ? dateFormat($respuesta[$key]["fch_validada"]) : '';
				$respuesta[$key]["imp_area"] = number_format($respuesta[$key]["imp_area"],2);
				$respuesta[$key]["imp_peso"] = number_format($respuesta[$key]["imp_peso"],2);
				$respuesta[$key]["ctd_orden"] = number_format($respuesta[$key]["ctd_orden"],2);
			}
		}
		echo json_encode($respuesta);
	}//function ajaxMostrarOrdenProduccion
	/*=============================================
	CREAR ORDEN DE PRODUCCION
	=============================================*/
	public function ajaxCrearOrdenProduccion(){
		$respuesta = ControladorOrdenProduccion::ctrCrearOrdenProduccion();
		echo $respuesta;
	}//function ajaxCrearOrdenProduccion
	/*=============================================
	EDITAR ORDEN DE PRODUCCION
	=============================================*/
	public function ajaxEditarOrdenProduccion(){
		$respuesta = ControladorOrdenProduccion::ctrEditarOrdenProduccion();
		echo $respuesta;
	}//function ajaxEditarOrdenProduccion
	/*=============================================
	MOSTRAR COTIZACION RELACIODA A LA ORDEN DE COMPRA Y CLIENTE
	=============================================*/
	public function ajaxMostrarRelCotizacion(){
		$valor1 = (isset($_POST["codCliente"])) ? $_POST["codCliente"] : null;
		$valor2 = (isset($_POST["ordenCompra"])) ? $_POST["ordenCompra"] : null;
		$respuesta = ControladorOrdenProduccion::ctrMostrarRelCotizacion($valor1,$valor2);
		echo json_encode($respuesta);
	}//function ajaxEditarOrdenProduccion
	/*=============================================
	ELIMINAR ORDEN DE PRODUCCION
	=============================================*/
	public function ajaxEliminarOrdenProduccion(){
		$respuesta = ControladorOrdenProduccion::ctrEliminarOrdenProduccion();
		echo $respuesta;
	}//function ajaxEditarOrdenProduccion
	/*=============================================
	MOSTRAR AREAS X PRODUCTO
	=============================================*/
	public function ajaxMostrarAreaXProducto(){
		$localidad = $_POST["localidad"];
		$ordenProduccion = $_POST["ordenProduccion"];
		$lineaOrdenDetalle = $_POST["lineaOrdenDetalle"];
		$producto = $_POST["producto"];
		$area = $_POST["area"];
		$entrada = $_POST["entrada"];
		$respuesta = ControladorOrdenProduccion::ctrMostrarAreaXProducto($localidad,$ordenProduccion,$lineaOrdenDetalle,$producto,$area,$entrada);
		echo json_encode($respuesta);
	}//function ajaxMostrarAreaXProducto;
	/*=============================================
	MOSTRAR ESTADO AREA
	=============================================*/
	public function ajaxMostrarEstadoArea(){
		$flgPendiente = (isset($_POST["flgPendiente"])) ? $_POST["flgPendiente"] : null;
		$entrada = (isset($_POST["entrada"])) ? $_POST["entrada"] : null;
		$respuesta = ControladorOrdenProduccion::ctrMostrarEstadoArea($flgPendiente,$entrada);
		echo json_encode($respuesta);
	}//function ajaxMostrarEstadoArea;
	/*=============================================
	MOSTRAR EL HISTORICO DE REMISION DE LA AREA FACTURACION
	=============================================*/
	public function ajaxMostrarHistoricoAreaFacturacion(){
		$localidad = $_POST["localidad"];
		$ordenProduccion = $_POST["ordenProduccion"];
		$lineaOrdenDetalle = $_POST["lineaOrdenDetalle"];
		$producto = $_POST["producto"];
		$area = $_POST["area"];
		$flgGuiaRemision = $_POST["flgGuiaRemision"];
		$entrada = (isset($_POST["entrada"])) ? $_POST["entrada"] : null;
		$respuesta = ControladorOrdenProduccion::ctrMostrarHistoricoAreaFacturacion($localidad,$ordenProduccion,$lineaOrdenDetalle,$producto,$area,$flgGuiaRemision,$entrada);
		foreach ($respuesta as $key => $value) {
			$respuesta[$key]["fch_emision"] = ($respuesta[$key]["fch_emision"] != '') ? dateFormat($respuesta[$key]["fch_emision"]) : '';
			$respuesta[$key]["fch_registro"] = ($respuesta[$key]["fch_registro"] != '') ? dateFormat($respuesta[$key]["fch_registro"]) : '';
		}
		echo json_encode($respuesta);
	}//function ajaxMostrarEstadoArea;
	function ajaxConsultarOrdenProduccion(){
		$entrada = $_POST["entrada"];
		if($entrada == 'listadoAreas'){
			$datos = array("cod_localidad"=>$_POST["localidad"],
						   "num_orden_produccion"=>$_POST["ordenProduccion"]);
		}
		$respuesta = ControladorOrdenProduccion::ctrConsultarOrdenProudccion($datos,$entrada);
		echo json_encode($respuesta);
	}//function ajaxConsultarOrdenProduccion
	function ajaxConsultarEstadoOrdProd(){
		$codEstado = $_POST["codEstado"];
		$localidad = $_POST["localidad"];
		$ordenProduccion = $_POST["ordenProduccion"];
		$entrada = $_POST["entrada"];
		$respuesta = ControladorOrdenProduccion::ctrConsultarEstadoOrdProd($codEstado,$localidad,$ordenProduccion,$entrada);
		echo $respuesta;
	}//function ajaxConsultarEstadoOrdProd
}//class AjaxOrdenProduccion
/*=============================================
ACCIONES ORDEN DE PRODUCCION
=============================================*/
if(isset($_POST["accionOrdenProduccion"]) && $_POST["accionOrdenProduccion"] == 'mostrar'){
	$ordenProduccion = new AjaxOrdenProduccion();
	$ordenProduccion -> ajaxMostrarOrdenProduccion();
}else if(isset($_POST["accionOrdenProduccion"]) && $_POST["accionOrdenProduccion"] == 'crear'){
	$ordenProduccion = new AjaxOrdenProduccion();
	$ordenProduccion -> ajaxCrearOrdenProduccion();
}else if(isset($_POST["accionOrdenProduccion"]) && $_POST["accionOrdenProduccion"] == 'editar'){
	$ordenProduccion = new AjaxOrdenProduccion();
	$ordenProduccion -> ajaxEditarOrdenProduccion();
}else if(isset($_POST["accionOrdenProduccion"]) && $_POST["accionOrdenProduccion"] == 'eliminar'){
	$ordenProduccion = new AjaxOrdenProduccion();
	$ordenProduccion -> ajaxEliminarOrdenProduccion();
}else if(isset($_POST["accionOrdenProduccion"]) && $_POST["accionOrdenProduccion"] == 'relacionCtzOrdCmp'){
	$ordenProduccion = new AjaxOrdenProduccion();
	$ordenProduccion -> ajaxMostrarRelCotizacion();
}else if(isset($_POST["accionOrdenProduccion"]) && $_POST["accionOrdenProduccion"] == 'mostrarAreaXProducto'){	
	$ordenProduccion = new AjaxOrdenProduccion();
	$ordenProduccion -> ajaxMostrarAreaXProducto();
}else if(isset($_POST["accionOrdenProduccion"]) && $_POST["accionOrdenProduccion"] == 'mostrarEstadoArea'){
	$ordenProduccion = new AjaxOrdenProduccion();
	$ordenProduccion -> ajaxMostrarEstadoArea();
}else if(isset($_POST["accionOrdenProduccion"]) && $_POST["accionOrdenProduccion"] == 'mostrarHistoricoAreaFacturacion'){
	$ordenProduccion = new AjaxOrdenProduccion();
	$ordenProduccion -> ajaxMostrarHistoricoAreaFacturacion();
}else if(isset($_POST["accionOrdenProduccion"]) && $_POST["accionOrdenProduccion"] == 'consultar'){
	$ordenProduccion = new AjaxOrdenProduccion();
	$ordenProduccion -> ajaxConsultarOrdenProduccion();
}else if(isset($_POST["accionOrdenProduccion"]) && $_POST["accionOrdenProduccion"] == 'consultarEstado'){
	$ordenProduccion = new AjaxOrdenProduccion();
	$ordenProduccion -> ajaxConsultarEstadoOrdProd();
}
