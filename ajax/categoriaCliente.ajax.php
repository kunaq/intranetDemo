<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/categoriaCliente.controlador.php";
require_once "../models/categoriaCliente.modelo.php";
class AjaxCategoriaCliente{
	/*=============================================
	MOSTRAR CATEGORIA CLIENTE
	=============================================*/
	public function ajaxMostrarCategoriaCliente(){
		$item = "cod_categoria_cliente";
		$valor = $_POST["codCategoriaCliente"];
		$respuesta = ControladorCategoriaCliente::ctrMostrarCategoriaClientes($item, $valor);
		echo json_encode($respuesta);
	}//function ajaxEditarCategoriaCliente
	/*=============================================
	CREAR CATEGORIA CLIENTE
	=============================================*/
	public function ajaxCrearCategoriaCliente(){
		$respuesta = ControladorCategoriaCliente::ctrCrearCategoriaCliente();
		echo $respuesta;
	}//function ajaxCrearCategoriaCliente
	/*=============================================
	EDITAR CATEGORIA CLIENTE
	=============================================*/
	public function ajaxEditarCategoriaCliente(){
		$respuesta = ControladorCategoriaCliente::ctrEditarCategoriaCliente();
		echo $respuesta;
	}//function ajaxEditarCategoriaCliente
	/*=============================================
	ELIMINAR CATEGORIA CLIENTE
	=============================================*/
	public function ajaxEliminarCategoriaCliente(){
		$respuesta = ControladorCategoriaCliente::ctrEliminarCategoriaCliente();
		echo $respuesta;
	}//function ajaxEliminarCategoriaCliente
}//AjaxCategoriaCliente
/*=============================================
ACCIONES CATEGORÍAS CLIENTE
=============================================*/
if(isset($_POST["accionCategoriaCliente"]) && $_POST["accionCategoriaCliente"] == 'crear'){
	$categoriaCliente = new AjaxCategoriaCliente();
	$categoriaCliente -> ajaxCrearCategoriaCliente();
}else if(isset($_POST["accionCategoriaCliente"]) && $_POST["accionCategoriaCliente"] == 'editar'){
	$categoriaCliente = new AjaxCategoriaCliente();
	$categoriaCliente -> ajaxEditarCategoriaCliente();
}else if(isset($_POST["accionCategoriaCliente"]) && $_POST["accionCategoriaCliente"] == 'mostrar'){
	$categoriaCliente = new AjaxCategoriaCliente();
	$categoriaCliente -> ajaxMostrarCategoriaCliente();
}else if(isset($_POST["accionCategoriaCliente"]) && $_POST["accionCategoriaCliente"] == 'eliminar'){
	$categoriaCliente = new AjaxCategoriaCliente();
	$categoriaCliente -> ajaxEliminarCategoriaCliente();
}