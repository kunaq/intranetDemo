<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/galeria.controlador.php";
require_once "../models/galeria.modelo.php";
class AjaxGaleria{
	/*=============================================
	MOSTRAR GALERIA
	=============================================*/
	public function ajaxMostrarGaleria(){
		$item = "cod_galeria";
		$valor = $_POST["codGaleria"];
		$entrada = "obtenerTotalDatos";
		$respuesta = ControladorGaleria::ctrMostrarGaleria($item,$valor,$entrada);
		echo json_encode(trimForeach($respuesta));
	}//function ajaxCrearGaleria
	/*=============================================
	CREAR GALERIA
	=============================================*/
	public function ajaxCrearGaleria(){
		$respuesta = ControladorGaleria::ctrCrearGaleria();
		echo $respuesta;
	}//function ajaxCrearGaleria
	/*=============================================
	EDITAR GALERIA
	=============================================*/
	public function ajaxEditarGaleria(){
		$respuesta = ControladorGaleria::ctrEditarGaleria();
		echo $respuesta;
	}//function ajaxEditarGaleria
	/*=============================================
	ELIMINAR GALERIA
	=============================================*/
	public function ajaxEliminarGaleria(){
		$respuesta = ControladorGaleria::ctrEliminarGaleria();
		echo $respuesta;
	}//function ajaxEliminarGaleria
	/*=============================================
	CREAR TIPO GALERIA
	=============================================*/
	public function ajaxCrearTipoGaleria(){
		$respuesta = ControladorGaleria::ctrCrearTipoGaleria();
		echo $respuesta;
	}//function ajaxCrearTipoGaleria
	/*=============================================
	ELIMINAR TIPO GALERIA
	=============================================*/
	public function ajaxEliminarTipoGaleria(){
		$respuesta = ControladorGaleria::ctrEliminarTipoGaleria();
		echo $respuesta;
	}//function ajaxEliminarTipoGaleria
}//class AjaxGaleria
/*=============================================
ACCIONES GALERIA
=============================================*/
if(isset($_POST["accionGaleria"]) && $_POST["accionGaleria"] == 'mostrar'){
	$galeria = new AjaxGaleria();
	$galeria -> ajaxMostrarGaleria();
}else if(isset($_POST["accionGaleria"]) && $_POST["accionGaleria"] == 'crear'){
	$galeria = new AjaxGaleria();
	$galeria -> ajaxCrearGaleria();
}else if(isset($_POST["accionGaleria"]) && $_POST["accionGaleria"] == 'editar'){
	$galeria = new AjaxGaleria();
	$galeria -> ajaxEditarGaleria();
}else if(isset($_POST["accionGaleria"]) && $_POST["accionGaleria"] == 'eliminar'){
	$galeria = new AjaxGaleria();
	$galeria -> ajaxEliminarGaleria();
}else if(isset($_POST["accionTipoGaleria"]) && $_POST["accionTipoGaleria"] == 'crear'){
	$galeria = new AjaxGaleria();
	$galeria -> ajaxCrearTipoGaleria();
}else if(isset($_POST["accionTipoGaleria"]) && $_POST["accionTipoGaleria"] == 'eliminar'){
	$galeria = new AjaxGaleria();
	$galeria -> ajaxEliminarTipoGaleria();
}