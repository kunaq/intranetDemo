<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/formaPago.controlador.php";
require_once "../models/formaPago.modelo.php";
class AjaxFormaPago{
	/*=============================================
	MOSTRAR FORMA PAGO
	=============================================*/
	public function ajaxMostrarFormaPago(){
		$item = "cod_forma_pago";
		$valor = $_POST["codFormaPago"];
		$respuesta = ControladorFormaPago::ctrMostrarFormaPago($item, $valor);
		echo json_encode($respuesta);
	}//function ajaxMostrarFormaPago
	/*=============================================
	CREAR FORMA PAGO
	=============================================*/
	public function ajaxCrearFormaPago(){
		$respuesta = ControladorFormaPago::ctrCrearFormaPago();
		echo $respuesta;
	}//function ajaxCrearFormaPago
	/*=============================================
	EDITAR FORMA PAGO
	=============================================*/
	public function ajaxEditarFormaPago(){
		$respuesta = ControladorFormaPago::ctrEditarFormaPago();
		echo $respuesta;
	}//function ajaxEditarFormaPago
	/*=============================================
	ELIMINAR FORMA PAGO
	=============================================*/
	public function ajaxEliminarFormaPago(){
		$respuesta = ControladorFormaPago::ctrEliminarFormaPago();
		echo $respuesta;
	}//function ajaxEliminarFormaPago
}//AjaxFormaPago
/*=============================================
ACCIONES FORMA PAGO
=============================================*/
if(isset($_POST["accionFormaPago"]) && $_POST["accionFormaPago"] == 'mostrar'){
	$formaPago = new AjaxFormaPago();
	$formaPago -> ajaxMostrarFormaPago();
}else if(isset($_POST["accionFormaPago"]) && $_POST["accionFormaPago"] == 'crear'){
	$formaPago = new AjaxFormaPago();
	$formaPago -> ajaxCrearFormaPago();
}else if(isset($_POST["accionFormaPago"]) && $_POST["accionFormaPago"] == 'editar'){
	$formaPago = new AjaxFormaPago();
	$formaPago -> ajaxEditarFormaPago();
}else if(isset($_POST["accionFormaPago"]) && $_POST["accionFormaPago"] == 'eliminar'){
	$formaPago = new AjaxFormaPago();
	$formaPago -> ajaxEliminarFormaPago();
}