<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/estadoCotizacion.controlador.php";
require_once "../models/estadoCotizacion.modelo.php";
class AjaxEstadoCotizacion{
	/*=============================================
	MOSTRAR ESTADO COTIZACION
	=============================================*/
	public function ajaxMostrarEstadoCotizacion(){
		$item = isset($_POST["codEstadoCotizacion"]) ? "cod_estado_cotizacion" : null;
		$valor = isset($_POST["codEstadoCotizacion"]) ? $_POST["codEstadoCotizacion"] : null;
		$entrada = isset($_POST["entrada"]) ? $_POST["entrada"] : null;
		$respuesta = ControladorEstadoCotizacion::ctrMostrarEstadoCotizacion($item,$valor,$entrada);
		echo json_encode($respuesta);
	}//function ajaxEditarCategoriaCliente
	/*=============================================
	EDITAR ESTADO COTIZACION
	=============================================*/
	public function ajaxEditarEstadoCotizacion(){
		$respuesta = ControladorEstadoCotizacion::ctrEditarEstadoCotizacion();
		echo $respuesta;
	}//function ajaxEditarProducto
}//AjaxEstadoCotizacion
/*=============================================
ACCIONES ESTADO COTIZACION
=============================================*/
if(isset($_POST["accionEstadoCotizacion"]) && $_POST["accionEstadoCotizacion"] == 'mostrar'){
	$estadoCotizacion = new AjaxEstadoCotizacion();
	$estadoCotizacion -> ajaxMostrarEstadoCotizacion();
}else if(isset($_POST["accionEstadoCotizacion"]) && $_POST["accionEstadoCotizacion"] == 'editar'){
	$estadoCotizacion = new AjaxEstadoCotizacion();
	$estadoCotizacion -> ajaxEditarEstadoCotizacion();
}