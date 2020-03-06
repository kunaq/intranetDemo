<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/tipoDocumento.controlador.php";
require_once "../models/tipoDocumento.modelo.php";
class AjaxTipoDocumento{
	/*=============================================
	MOSTRAR TIPO DOCUMENTO
	=============================================*/
	public function ajaxMostrarTipoDocumento(){
		$item = "cod_tipo_documento";
		$valor = $_POST["codTipoDocumento"];
		$respuesta = ControladorTipoDocumento::ctrMostrarTipoDocumento($item, $valor);
		echo json_encode($respuesta);
	}//function ajaxMostrarTipoDocumento
	/*=============================================
	CREAR TIPO DOCUMENTO
	=============================================*/
	public function ajaxCrearTipoDocumento(){
		$respuesta = ControladorTipoDocumento::ctrCrearTipoDocumento();
		echo $respuesta;
	}//function ajaxCrearTipoDocumento
	/*=============================================
	EDITAR TIPO DOCUMENTO
	=============================================*/
	public function ajaxEditarTipoDocumento(){
		$respuesta = ControladorTipoDocumento::ctrEditarTipoDocumento();
		echo $respuesta;
	}//function ajaxEditarTipoDocumento
	/*=============================================
	ELIMINAR TIPO DOCUMENTO
	=============================================*/
	public function ajaxEliminarTipoDocumento(){
		$respuesta = ControladorTipoDocumento::ctrEliminarTipoDocumento();
		echo $respuesta;
	}//function ajaxEditarTipoDocumento
}//AjaxTipoDocumento
/*=============================================
ACCIONES TIPO DOCUMENTO
=============================================*/
if(isset($_POST["accionTipoDocumento"]) && $_POST["accionTipoDocumento"] == 'mostrar'){
	$tipoDocumento = new AjaxTipoDocumento();
	$tipoDocumento -> ajaxMostrarTipoDocumento();
}else if(isset($_POST["accionTipoDocumento"]) && $_POST["accionTipoDocumento"] == 'crear'){
	$tipoDocumento = new AjaxTipoDocumento();
	$tipoDocumento -> ajaxCrearTipoDocumento();
}else if(isset($_POST["accionTipoDocumento"]) && $_POST["accionTipoDocumento"] == 'editar'){
	$tipoDocumento = new AjaxTipoDocumento();
	$tipoDocumento -> ajaxEditarTipoDocumento();
}else if(isset($_POST["accionTipoDocumento"]) && $_POST["accionTipoDocumento"] == 'eliminar'){
	$tipoDocumento = new AjaxTipoDocumento();
	$tipoDocumento -> ajaxEliminarTipoDocumento();
}