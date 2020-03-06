<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/perfil.controlador.php";
require_once "../models/perfil.modelo.php";
class AjaxPerfil{
	/*=============================================
	MOSTRAR PERFIL
	=============================================*/
	public function ajaxMostrarPerfil(){
		$item = "cod_perfil";
		$valor = $_POST["codPerfil"];
		$respuesta = ControladorPerfil::ctrMostrarPerfil($item, $valor);
		echo json_encode($respuesta);
	}//function ajaxMostrarPerfil
	/*=============================================
	EDITAR PERFIL
	=============================================*/
	public function ajaxEditarPerfil(){
		$respuesta = ControladorPerfil::ctrEditarPerfil();
		echo $respuesta;
	}//function ajaxEditarPerfil
}//AjaxPerfil
/*=============================================
ACCIONES PERFIL
=============================================*/
if(isset($_POST["accionPerfil"]) && $_POST["accionPerfil"] == 'mostrar'){
	$perfil = new AjaxPerfil();
	$perfil -> ajaxMostrarPerfil();
}else if(isset($_POST["accionPerfil"]) && $_POST["accionPerfil"] == 'editar'){
	$perfil = new AjaxPerfil();
	$perfil -> ajaxEditarPerfil();
}