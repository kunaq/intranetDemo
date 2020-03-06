<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/clientes.controlador.php";
require_once "../controllers/tipoDocumento.controlador.php";
require_once "../models/tipoDocumento.modelo.php";
require_once "../models/clientes.modelo.php";
class AjaxClientes{
	/*=============================================
	EDITAR CLIENTE
	=============================================*/	
	public $codCliente;
	public function ajaxEditarCliente(){
		if($this->codCliente != ""){
			$item = "cod_cliente";
			$valor = $this->codCliente;
			$entrada = (isset($_POST["entrada"])) ? $_POST["entrada"] : null;
			$respuesta = ControladorClientes::ctrMostrarClientes($item,$valor,$entrada);
			if($entrada == "creaCotizacion"){
				echo json_encode(valoresNull(trimForeach($respuesta)));
			}else{
				echo json_encode(trimForeach($respuesta));
			}
			
		}else{
			$respuesta = ControladorClientes::ctrEditarCliente();
			echo json_encode($respuesta);
		}
	}//function ajaxEditarCliente
	public function ajaxCrearCliente(){
		$respuesta = ControladorClientes::ctrCrearCliente();
		echo json_encode($respuesta);
	}//function ajaxCrearCliente
	public function ajaxEliminarCliente(){
		$respuesta = ControladorClientes::ctrEliminarCliente();
		echo $respuesta;
	}//function ajaxEliminarCliente
	public function ajaxMostrarCliente(){
		$item = null;
		$valor = null;
		$entrada = (isset($_POST["entrada"])) ? $_POST["entrada"] : null;
		$respuesta = ControladorClientes::ctrMostrarClientes($item,$valor,$entrada);
		echo json_encode($respuesta);
	}//function ajaxMostrarCliente
}//class AjaxClientes
/*=============================================
EDITAR CLIENTE
=============================================*/
if(isset($_POST["codCliente"])){
	$cliente = new AjaxClientes();
	$cliente -> codCliente = $_POST["codCliente"];
	$cliente -> ajaxEditarCliente();
}
/*=============================================
ACCIONES CLIENTE
=============================================*/
if(isset($_POST["accionCliente"]) && $_POST["accionCliente"] == 'crear'){
	$cliente = new AjaxClientes();
	$cliente -> ajaxCrearCliente();
}else if(isset($_POST["accionCliente"]) && $_POST["accionCliente"] == 'editar'){
	$cliente = new AjaxClientes();
	$cliente -> ajaxEditarCliente();
}else if(isset($_POST["accionCliente"]) && $_POST["accionCliente"] == 'eliminar'){
	$cliente = new AjaxClientes();
	$cliente -> ajaxEliminarCliente();
}else if(isset($_POST["accionCliente"]) && $_POST["accionCliente"] == 'listar'){
	$cliente = new AjaxClientes();
	$cliente -> ajaxMostrarCliente();
}