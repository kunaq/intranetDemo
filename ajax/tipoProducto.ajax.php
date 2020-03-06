<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/tipoProducto.controlador.php";
require_once "../models/tipoProducto.modelo.php";
class AjaxTipoProducto{
	/*=============================================
	MOSTRAR TIPO DE PRODUCTOS
	=============================================*/
	public function ajaxMostrarTipoProducto(){
		$item = (isset($_POST["codTipoProducto"])) ? "cod_tipo_producto" : null;
		$valor = (isset($_POST["codTipoProducto"])) ? $_POST["codTipoProducto"] : null;
		$entrada = (isset($_POST["entrada"])) ? $_POST["entrada"] : null;
		$respuesta = ControladorTipoProducto::ctrMostrarTipoProducto($item,$valor,$entrada);
		echo json_encode($respuesta);
	}//function ajaxMostrarProductos
	/*=============================================
	CREAR TIPO PRODUCTO
	=============================================*/
	public function ajaxCrearTipoProducto(){
		$respuesta = ControladorTipoProducto::ctrCrearTipoProducto();
		echo $respuesta;
	}//function ajaxCrearTipoProducto
	/*=============================================
	EDITAR TIPO PRODUCTO
	=============================================*/
	public function ajaxEditarTipoProducto(){
		$respuesta = ControladorTipoProducto::ctrEditarTipoProducto();
		echo $respuesta;
	}//function ajaxEditarTipoProducto
	/*=============================================
	ELIMINAR TIPO PRODUCTO
	=============================================*/
	public function ajaxEliminarTipoProducto(){
		$respuesta = ControladorTipoProducto::ctrEliminarTipoProducto();
		echo $respuesta;
	}//function ajaxEliminarTipoProducto
}//AjaxTipoProducto
/*=============================================
ACCIONES TIPO DE PRODUCTOS
=============================================*/
if(isset($_POST["accionTipoProducto"]) && $_POST["accionTipoProducto"] == 'cotizacion'){
	$tipoProducto = new AjaxTipoProducto();
	$tipoProducto -> ajaxMostrarTipoProducto();
}else if(isset($_POST["accionTipoProducto"]) && $_POST["accionTipoProducto"] == 'crear'){
	$tipoProducto = new AjaxTipoProducto();
	$tipoProducto -> ajaxCrearTipoProducto();
}else if(isset($_POST["accionTipoProducto"]) && $_POST["accionTipoProducto"] == 'mostrar'){
	$tipoProducto = new AjaxTipoProducto();
	$tipoProducto -> ajaxMostrarTipoProducto();
}else if(isset($_POST["accionTipoProducto"]) && $_POST["accionTipoProducto"] == 'editar'){
	$tipoProducto = new AjaxTipoProducto();
	$tipoProducto -> ajaxEditarTipoProducto();
}else if(isset($_POST["accionTipoProducto"]) && $_POST["accionTipoProducto"] == 'eliminar'){
	$tipoProducto = new AjaxTipoProducto();
	$tipoProducto -> ajaxEliminarTipoProducto();
}