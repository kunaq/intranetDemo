<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/productos.controlador.php";
require_once "../models/productos.modelo.php";
class AjaxProductos{
	/*=============================================
	EDITAR PRODUCTO
	=============================================*/
	public $codProducto;
	public function ajaxEditarProducto(){
		if($this->codProducto != ""){
			$item = "cod_producto";
			$valor = $this->codProducto;
			$entrada = "modalProducto";
			$respuesta = ControladorProductos::ctrMostrarProductos($item,$valor,$entrada);
			echo json_encode(trimForeach($respuesta));
		}else{
			$respuesta = ControladorProductos::ctrEditarProducto();
			echo $respuesta;
		}
	}//function ajaxEditarProducto
	/*=============================================
	MOSTRAR PRODUCTOS
	=============================================*/
	public function ajaxMostrarProductos(){
		$item = null;
		$valor = null;
		$entrada = (isset($_POST["entrada"])) ? $_POST["entrada"] : null;
		$respuesta = ControladorProductos::ctrMostrarProductos($item,$valor,$entrada);
		echo json_encode($respuesta);
	}//function ajaxMostrarProductos
	/*=============================================
	CREAR PRODUCTO
	=============================================*/
	public function ajaxCrearProducto(){
		$respuesta = ControladorProductos::ctrCrearProducto();
		echo $respuesta;
	}//function ajaxCrearProducto
	/*=============================================
	ELIMINAR PRODUCTO
	=============================================*/
	public function ajaxEliminarProducto(){
		$respuesta = ControladorProductos::ctrEliminarProducto();
		echo $respuesta;
	}//function ajaxEditarProducto
}//AjaxProductos
/*=============================================
EDITAR PRODUCTO
=============================================*/
if(isset($_POST["codProducto"])){
	$producto = new AjaxProductos();
	$producto -> codProducto = $_POST["codProducto"];
	$producto -> ajaxEditarProducto();
}
/*=============================================
ACCIONES PRODUCTO
=============================================*/
if(isset($_POST["accionProducto"]) && $_POST["accionProducto"] == 'crear'){
	$producto = new AjaxProductos();
	$producto -> ajaxCrearProducto();
}else if(isset($_POST["accionProducto"]) && $_POST["accionProducto"] == 'editar'){
	$producto = new AjaxProductos();
	$producto -> ajaxEditarProducto();
}else if(isset($_POST["accionProducto"]) && $_POST["accionProducto"] == 'eliminar'){
	$producto = new AjaxProductos();
	$producto -> ajaxEliminarProducto();
}else if(isset($_POST["accionProducto"]) && $_POST["accionProducto"] == 'listar'){
	$producto = new AjaxProductos();
	$producto -> ajaxMostrarProductos();
}