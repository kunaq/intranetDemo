<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/estadoContacto.controlador.php";
require_once "../models/estadoContacto.modelo.php";
class AjaxEstadoContacto{
	/*=============================================
	MOSTRAR ESTADO CONTACTO
	=============================================*/
	public function ajaxMostrarEstadoContacto(){
		$item = "cod_estado_contacto";
		$valor = $_POST["codEstadoContacto"];
		$respuesta = ControladorEstadoContacto::ctrMostrarEstadoContacto($item,$valor);
		echo json_encode($respuesta);
	}//function ajaxEditarEstadoContacto
	/*=============================================
	CREAR ESTADO CONTACTO
	=============================================*/
	public function ajaxCrearEstadoContacto(){
		$respuesta = ControladorEstadoContacto::ctrCrearEstadoContacto();
		echo $respuesta;
	}//function ajaxCrearEstadoContacto
	/*=============================================
	EDITAR ESTADO CONTACTO
	=============================================*/
	public function ajaxEditarEstadoContacto(){
		$respuesta = ControladorEstadoContacto::ctrEditarEstadoContacto();
		echo $respuesta;
	}//function ajaxEditarEstadoContacto
	/*=============================================
	ELIMINAR ESTADO CONTACTO
	=============================================*/
	public function ajaxEliminarEstadoContacto(){
		$respuesta = ControladorEstadoContacto::ctrEliminarEstadoContacto();
		echo $respuesta;
	}//function ajaxEliminarEstadoContacto
}//AjaxEstadoContacto
/*=============================================
ACCIONES ESTADO CONTACTO
=============================================*/
if(isset($_POST["accionEstadoContacto"]) && $_POST["accionEstadoContacto"] == 'crear'){
	$estadoContacto = new AjaxEstadoContacto();
	$estadoContacto -> ajaxCrearEstadoContacto();
}else if(isset($_POST["accionEstadoContacto"]) && $_POST["accionEstadoContacto"] == 'editar'){
	$estadoContacto = new AjaxEstadoContacto();
	$estadoContacto -> ajaxEditarEstadoContacto();
}else if(isset($_POST["accionEstadoContacto"]) && $_POST["accionEstadoContacto"] == 'mostrar'){
	$estadoContacto = new AjaxEstadoContacto();
	$estadoContacto -> ajaxMostrarEstadoContacto();
}else if(isset($_POST["accionEstadoContacto"]) && $_POST["accionEstadoContacto"] == 'eliminar'){
	$estadoContacto = new AjaxEstadoContacto();
	$estadoContacto -> ajaxEliminarEstadoContacto();
}