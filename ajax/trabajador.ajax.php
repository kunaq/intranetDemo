<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/trabajador.controlador.php";
require_once "../models/trabajador.modelo.php";
class AjaxTrabajador{
	/*=============================================
	MOSTRAR TRABAJADOR
	=============================================*/
	public $codTrabajador;
	public function ajaxMostrarTrabajador(){
		$item1 = (isset($_POST["codTrabajador"])) ? "cod_trabajador" : null;
		$valor1 = (isset($_POST["codTrabajador"])) ? $_POST["codTrabajador"] : null;
		$item2 = $valor2 = $item3 = $valor3 = null;
		$entrada = (isset($_POST["entrada"])) ? $_POST["entrada"] : "modalTrabajador";
		$respuesta = ControladorTrabajador::ctrMostrarTrabajador($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada);
		echo json_encode(trimForeach($respuesta));
	}//function ajaxMostrarTrabajador
	/*=============================================
	EDITAR TRABAJADOR
	=============================================*/	
	public function ajaxEditarTrabajador(){
		$respuesta = ControladorTrabajador::ctrEditarTrabajador();
		echo $respuesta;
	}//function ajaxEditarTrabajador
	public function ajaxCrearTrabajador(){
		$respuesta = ControladorTrabajador::ctrIngresoTrabajador();
		echo $respuesta;
	}//function ajaxCrearTrabajador
}//AjaxTrabajador
/*=============================================
ACCIONES TRABAJADOR
=============================================*/
if(isset($_POST["accionTrabajador"]) && $_POST["accionTrabajador"] == 'mostrar'){
	$trabajador = new AjaxTrabajador();
	$trabajador -> ajaxMostrarTrabajador();
}else if(isset($_POST["accionTrabajador"]) && $_POST["accionTrabajador"] == 'editar'){
	$trabajador = new AjaxTrabajador();
	$trabajador -> ajaxEditarTrabajador();
}else if(isset($_POST["accionTrabajador"]) && $_POST["accionTrabajador"] == 'ingreso'){
	$trabajador = new AjaxTrabajador();
	$trabajador -> ajaxCrearTrabajador();
}