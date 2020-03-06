<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/pais.controlador.php";
require_once "../models/pais.modelo.php";
class AjaxPais{
	/*=============================================
	MOSTRAR PAÍS
	=============================================*/
	public function ajaxMostrarPais(){
		$item = "cod_pais";
		$valor = $_POST["codPais"];
		$respuesta = ControladorPais::ctrMostrarPaises($item, $valor);
		echo json_encode($respuesta);
	}//function ajaxMostrarPais
	/*=============================================
	CREAR PAIS
	=============================================*/
	public function ajaxCrearPais(){
		$respuesta = ControladorPais::ctrCrearPais();
		echo $respuesta;
	}//function ajaxCrearPais
	/*=============================================
	EDITAR PAIS
	=============================================*/
	public function ajaxEditarPais(){
		$respuesta = ControladorPais::ctrEditarPais();
		echo $respuesta;
	}//function ajaxEditarPais
	/*=============================================
	ELIMINAR PAIS
	=============================================*/
	public function ajaxEliminarPais(){
		$respuesta = ControladorPais::ctrEliminarPais();
		echo $respuesta;
	}//function ajaxEliminarPais
}//class AjaxPais
if(isset($_POST["accionPais"]) && $_POST["accionPais"] == 'mostrar'){
	$pais = new AjaxPais();
	$pais -> ajaxMostrarPais();
}else if(isset($_POST["accionPais"]) && $_POST["accionPais"] == 'crear'){
	$pais = new AjaxPais();
	$pais -> ajaxCrearPais();
}else if(isset($_POST["accionPais"]) && $_POST["accionPais"] == 'editar'){
	$pais = new AjaxPais();
	$pais -> ajaxEditarPais();
}else if(isset($_POST["accionPais"]) && $_POST["accionPais"] == 'eliminar'){
	$pais = new AjaxPais();
	$pais -> ajaxEliminarPais();
}