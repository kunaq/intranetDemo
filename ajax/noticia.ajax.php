<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/noticia.controlador.php";
require_once "../models/noticia.modelo.php";
class AjaxNoticia{
	public function ajaxMostrarNoticia(){
		$item = "cod_noticia";
		$valor = $_POST["codNoticia"];
		$entrada = "modalNoticia";
		$respuesta = ControladorNoticia::ctrMostrarNoticia($item,$valor,$entrada);
		$respuesta["fch_publicacion"] = dateFormat($respuesta["fch_publicacion"]);
		echo json_encode(trimForeach($respuesta));
	}//function ajaxEditarNoticia
	public function ajaxCrearNoticia(){
		$respuesta = ControladorNoticia::ctrCrearNoticia();
		echo $respuesta;
	}//function ajaxEditarNoticia
	public function ajaxEditarNoticia(){
		$respuesta = ControladorNoticia::ctrEditarNoticia();
		echo $respuesta;
	}//function ajaxEditarNoticia
	public function ajaxEliminarNoticia(){
		$respuesta = ControladorNoticia::ctrEliminarNoticia();
		echo $respuesta;
	}//function ajaxEliminarNoticia
}//class AjaxNoticia
/*=============================================
ACCIONES NOTICIA
=============================================*/
if(isset($_POST["accionNoticia"]) && $_POST["accionNoticia"] == 'mostrar'){
	$noticia = new AjaxNoticia();
	$noticia -> ajaxMostrarNoticia();
}else if(isset($_POST["accionNoticia"]) && $_POST["accionNoticia"] == 'crear'){
	$noticia = new AjaxNoticia();
	$noticia -> ajaxCrearNoticia();
}else if(isset($_POST["accionNoticia"]) && $_POST["accionNoticia"] == 'editar'){
	$noticia = new AjaxNoticia();
	$noticia -> ajaxEditarNoticia();
}else if(isset($_POST["accionNoticia"]) && $_POST["accionNoticia"] == 'eliminar'){
	$noticia = new AjaxNoticia();
	$noticia -> ajaxEliminarNoticia();
}