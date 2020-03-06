<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/moneda.controlador.php";
require_once "../models/moneda.modelo.php";
class AjaxMoneda{
	/*=============================================
	MOSTRAR MONEDA
	=============================================*/
	public function ajaxMostrarMoneda(){
		$item = "cod_moneda";
		$valor = $_POST["codMoneda"];
		$respuesta = ControladorMoneda::ctrMostrarMoneda($item, $valor);
		echo json_encode($respuesta);
	}//function ajaxMostrarMoneda
	/*=============================================
	CREAR MONEDA
	=============================================*/
	public function ajaxCrearMoneda(){
		$respuesta = ControladorMoneda::ctrCrearMoneda();
		echo $respuesta;
	}//function ajaxCrearMoneda
	/*=============================================
	EDITAR MONEDA
	=============================================*/
	public function ajaxEditarMoneda(){
		$respuesta = ControladorMoneda::ctrEditarMoneda();
		echo $respuesta;
	}//function ajaxEditarMoneda
	/*=============================================
	ELIMINAR MONEDA
	=============================================*/
	public function ajaxEliminarMoneda(){
		$respuesta = ControladorMoneda::ctrEliminarMoneda();
		echo $respuesta;
	}//function ajaxEliminarMoneda
}//AjaxMoneda
/*=============================================
ACCIONES ESTADO COTIZACION
=============================================*/
if(isset($_POST["accionMoneda"]) && $_POST["accionMoneda"] == 'mostrar'){
	$moneda = new AjaxMoneda();
	$moneda -> ajaxMostrarMoneda();
}else if(isset($_POST["accionMoneda"]) && $_POST["accionMoneda"] == 'crear'){
	$moneda = new AjaxMoneda();
	$moneda -> ajaxCrearMoneda();
}else if(isset($_POST["accionMoneda"]) && $_POST["accionMoneda"] == 'editar'){
	$moneda = new AjaxMoneda();
	$moneda -> ajaxEditarMoneda();
}else if(isset($_POST["accionMoneda"]) && $_POST["accionMoneda"] == 'eliminar'){
	$moneda = new AjaxMoneda();
	$moneda -> ajaxEliminarMoneda();
}