<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/consultaFrecuente.controlador.php";
require_once "../models/consultaFrecuente.modelo.php";
class AjaxConsultaFrecuente{
	/*=============================================
	MOSTRAR CONSULTA FRECUENTE
	=============================================*/
	public function ajaxMostrarConsultaFrecuente(){
		$item = "cod_consulta";
		$valor = $_POST["codConsultaFrecuente"];
		$entrada = "modalConsultaFrecuente";
		$respuesta = ControladorConsultaFrecuente::ctrMostrarConsultaFrecuente($item,$valor,$entrada);
		echo json_encode(trimForeach($respuesta));
	}//function ajaxMostrarConsultaFrecuente
	/*=============================================
	CREAR CONSULTA FRECUENTE
	=============================================*/
	public function ajaxCrearConsultaFrecuente(){
		$respuesta = ControladorConsultaFrecuente::ctrCrearConsultaFrecuente();
		echo $respuesta;
	}//function ajaxCrearConsultaFrecuente
	/*=============================================
	EDITAR CONSULTA FRECUENTE
	=============================================*/
	public function ajaxEditarConsultaFrecuente(){
		$respuesta = ControladorConsultaFrecuente::ctrEditarConsultaFrecuente();
		echo $respuesta;
	}//function ajaxEditarConsultaFrecuente
	/*=============================================
	ELIMINAR CONSULTA FRECUENTE
	=============================================*/
	public function ajaxEliminarConsultaFrecuente(){
		$respuesta = ControladorConsultaFrecuente::ctrEliminarConsultaFrecuente();
		echo $respuesta;
	}//function ajaxEliminarConsultaFrecuente
}//class AjaxConsultaFrecuente
/*=============================================
ACCIONES CONSULTA FRECUENTE
=============================================*/
if(isset($_POST["accionConsultaFrecuente"]) && $_POST["accionConsultaFrecuente"] == "mostrar"){
	$consultaFrecuente = new AjaxConsultaFrecuente();
	$consultaFrecuente -> ajaxMostrarConsultaFrecuente();
}else if(isset($_POST["accionConsultaFrecuente"]) && $_POST["accionConsultaFrecuente"] == "crear"){
	$consultaFrecuente = new AjaxConsultaFrecuente();
	$consultaFrecuente -> ajaxCrearConsultaFrecuente();
}else if(isset($_POST["accionConsultaFrecuente"]) && $_POST["accionConsultaFrecuente"] == "editar"){
	$consultaFrecuente = new AjaxConsultaFrecuente();
	$consultaFrecuente -> ajaxEditarConsultaFrecuente();
}else if(isset($_POST["accionConsultaFrecuente"]) && $_POST["accionConsultaFrecuente"] == "eliminar"){
	$consultaFrecuente = new AjaxConsultaFrecuente();
	$consultaFrecuente -> ajaxEliminarConsultaFrecuente();
}