<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/politicaProcedimiento.controlador.php";
require_once "../models/politicaProcedimiento.modelo.php";
class AjaxPoliticaProcedimiento{
	/*=============================================
	MOSTRAR POLITICA/PROCEDIMIENTO
	=============================================*/
	public function ajaxMostrarPoliticaProcedimiento(){
		$item = "cod_politica";
		$valor = $_POST["codPoliticaProcedimiento"];
		$entrada = "detallePoliticaProcedimiento";
		$respuesta = ControladorPoliticaProcedimiento::ctrMostrarPoliticaProcedimiento($item,$valor,$entrada);
		echo json_encode(trimForeach($respuesta));
	}//function ajaxMostrarPoliticaProcedimiento
	/*=============================================
	CREAR POLITICA/PROCEDIMIENTO
	=============================================*/
	public function ajaxCrearPoliticaProcedimiento(){
		$respuesta = ControladorPoliticaProcedimiento::ctrCrearPoliticaProcedimiento();
		echo $respuesta;
	}//function ajaxCrearPoliticaProcedimiento
	/*=============================================
	EDITAR POLITICA/PROCEDIMIENTO
	=============================================*/
	public function ajaxEditarPoliticaProcedimiento(){
		$respuesta = ControladorPoliticaProcedimiento::ctrEditarPoliticaProcedimiento();
		echo $respuesta;
	}//function ajaxEditarPoliticaProcedimiento
	/*=============================================
	ELIMINAR POLITICA/PROCEDIMIENTO
	=============================================*/
	public function ajaxEliminarPoliticaProcedimiento(){
		$respuesta = ControladorPoliticaProcedimiento::ctrEliminarPoliticaProcedimiento();
		echo $respuesta;
	}//function ajaxEliminarPoliticaProcedimiento
	/*=============================================
	ELIMINAR POLITICA/PROCEDIMIENTO DETALLE
	=============================================*/
	public function ajaxEliminarPoliticaProcedimientoDetalle(){
		$respuesta = ControladorPoliticaProcedimiento::ctrEliminarPoliticaProcedimientoDetalle();
		echo $respuesta;
	}//function ajaxEliminarPoliticaProcedimiento
}//class AjaxPoliticaProcedimiento
/*=============================================
ACCIONES GALERIA
=============================================*/
if(isset($_POST["accionPoliticaProcedimiento"]) && $_POST["accionPoliticaProcedimiento"] == 'mostrar'){
	$politicaProcedimiento = new AjaxPoliticaProcedimiento();
	$politicaProcedimiento -> ajaxMostrarPoliticaProcedimiento();
}else if(isset($_POST["accionPoliticaProcedimiento"]) && $_POST["accionPoliticaProcedimiento"] == 'crear'){
	$politicaProcedimiento = new AjaxPoliticaProcedimiento();
	$politicaProcedimiento -> ajaxCrearPoliticaProcedimiento();
}else if(isset($_POST["accionPoliticaProcedimiento"]) && $_POST["accionPoliticaProcedimiento"] == 'editar'){
	$politicaProcedimiento = new AjaxPoliticaProcedimiento();
	$politicaProcedimiento -> ajaxEditarPoliticaProcedimiento();
}else if(isset($_POST["accionPoliticaProcedimiento"]) && $_POST["accionPoliticaProcedimiento"] == 'eliminar'){
	$politicaProcedimiento = new AjaxPoliticaProcedimiento();
	$politicaProcedimiento -> ajaxEliminarPoliticaProcedimiento();
}else if(isset($_POST["accionPoliticaProcedimientoDetalle"]) && $_POST["accionPoliticaProcedimientoDetalle"] == 'eliminar'){
	$politicaProcedimiento = new AjaxPoliticaProcedimiento();
	$politicaProcedimiento -> ajaxEliminarPoliticaProcedimientoDetalle();
}