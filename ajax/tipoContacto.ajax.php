<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/tipoContacto.controlador.php";
require_once "../models/tipoContacto.modelo.php";
class AjaxTipoContacto{
	/*=============================================
	MOSTRAR TIPO CONTACTO
	=============================================*/
	public function ajaxMostrarTipoContacto(){
		$item = "cod_tipo_contacto";
		$valor = $_POST["codTipoContacto"];
		$respuesta = ControladorTipoContacto::ctrMostrarTipoContacto($item, $valor);
		echo json_encode($respuesta);
	}//function ajaxEditarTipoContacto
	/*=============================================
	CREAR TIPO CONTACTO
	=============================================*/
	public function ajaxCrearTipoContacto(){
		$respuesta = ControladorTipoContacto::ctrCrearTipoContacto();
		echo $respuesta;
	}//function ajaxCrearTipoContacto
	/*=============================================
	EDITAR TIPO CONTACTO
	=============================================*/
	public function ajaxEditarTipoContacto(){
		$respuesta = ControladorTipoContacto::ctrEditarTipoContacto();
		echo $respuesta;
	}//function ajaxEditarTipoContacto
	/*=============================================
	ELIMINAR TIPO CONTACTO
	=============================================*/
	public function ajaxEliminarTipoContacto(){
		$respuesta = ControladorTipoContacto::ctrEliminarTipoContacto();
		echo $respuesta;
	}//function ajaxEliminarTipoContacto
}//AjaxTipoContacto
/*=============================================
ACCIONES TIPO CONTACTO
=============================================*/
if(isset($_POST["accionTipoContacto"]) && $_POST["accionTipoContacto"] == 'crear'){
	$tipoContacto = new AjaxTipoContacto();
	$tipoContacto -> ajaxCrearTipoContacto();
}else if(isset($_POST["accionTipoContacto"]) && $_POST["accionTipoContacto"] == 'editar'){
	$tipoContacto = new AjaxTipoContacto();
	$tipoContacto -> ajaxEditarTipoContacto();
}else if(isset($_POST["accionTipoContacto"]) && $_POST["accionTipoContacto"] == 'mostrar'){
	$tipoContacto = new AjaxTipoContacto();
	$tipoContacto -> ajaxMostrarTipoContacto();
}else if(isset($_POST["accionTipoContacto"]) && $_POST["accionTipoContacto"] == 'eliminar'){
	$tipoContacto = new AjaxTipoContacto();
	$tipoContacto -> ajaxEliminarTipoContacto();
}