<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/canalContacto.controlador.php";
require_once "../models/canalContacto.modelo.php";
class AjaxCanalContacto{
	/*=============================================
	MOSTRAR CANAL CONTACTO
	=============================================*/
	public function ajaxMostrarCanalContacto(){
		$item = "cod_canal_contacto";
		$valor = $_POST["codCanalContacto"];
		$respuesta = ControladorCanalContacto::ctrMostrarCanalContacto($item, $valor);
		echo json_encode($respuesta);
	}//function ajaxEditarCanalContacto
	/*=============================================
	CREAR CANAL CONTACTO
	=============================================*/
	public function ajaxCrearCanalContacto(){
		$respuesta = ControladorCanalContacto::ctrCrearCanalContacto();
		echo $respuesta;
	}//function ajaxCrearCanalContacto
	/*=============================================
	EDITAR CANAL CONTACTO
	=============================================*/
	public function ajaxEditarCanalContacto(){
		$respuesta = ControladorCanalContacto::ctrEditarCanalContacto();
		echo $respuesta;
	}//function ajaxEditarCanalContacto
	/*=============================================
	ELIMINAR CANAL CONTACTO
	=============================================*/
	public function ajaxEliminarCanalContacto(){
		$respuesta = ControladorCanalContacto::ctrEliminarCanalContacto();
		echo $respuesta;
	}//function ajaxEliminarCanalContacto
}//AjaxCanalContacto
/*=============================================
ACCIONES CANAL CONTACTO
=============================================*/
if(isset($_POST["accionCanalContacto"]) && $_POST["accionCanalContacto"] == 'crear'){
	$canalContacto = new AjaxCanalContacto();
	$canalContacto -> ajaxCrearCanalContacto();
}else if(isset($_POST["accionCanalContacto"]) && $_POST["accionCanalContacto"] == 'editar'){
	$canalContacto = new AjaxCanalContacto();
	$canalContacto -> ajaxEditarCanalContacto();
}else if(isset($_POST["accionCanalContacto"]) && $_POST["accionCanalContacto"] == 'mostrar'){
	$canalContacto = new AjaxCanalContacto();
	$canalContacto -> ajaxMostrarCanalContacto();
}else if(isset($_POST["accionCanalContacto"]) && $_POST["accionCanalContacto"] == 'eliminar'){
	$canalContacto = new AjaxCanalContacto();
	$canalContacto -> ajaxEliminarCanalContacto();
}