<?php
class ControladorCategoriaCliente{
	/*=============================================
	CREAR CATEGORIA CLIENTE
	=============================================*/
	static public function ctrCrearCategoriaCliente(){
		if(isset($_POST["accionCategoriaCliente"]) && $_POST["accionCategoriaCliente"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_categoria_cliente';
			$codCategoriaCliente = maximoCodigoTabla($tabla,'cod_categoria_cliente','');
			$datos = array("cod_categoria_cliente" => $codCategoriaCliente,
						   "dsc_categoria_cliente" => ms_escape_string(trim($_POST["nombreCategoriaCliente"])),
						   "cod_usr_registro" => $_SESSION["cod_trabajador"],
						   "fch_registro" => $fechaActual
						);
			$respuesta = ModeloCategoriaCliente::mdlIngresarCategoriaCliente($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrCrearCategoriaCliente
	/*=============================================
	MOSTRAR CATEGORIA DE CLIENTES
	=============================================*/
	static public function ctrMostrarCategoriaClientes($item,$valor){
		$tabla = "vtama_categoria_cliente";
		$respuesta = ModeloCategoriaCliente::mdlMostrarCategoriaClientes($tabla,$item,$valor);
		return $respuesta;
	}//function ctrMostrarCategoriaClientes
	/*=============================================
	EDITAR CATEGORIA CLIENTE
	=============================================*/
	static public function ctrEditarCategoriaCliente(){
		if(isset($_POST["accionCategoriaCliente"]) && $_POST["accionCategoriaCliente"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_categoria_cliente';
			$datos = array("cod_categoria_cliente" => $_POST["codigoCategoriaCliente"],
						   "dsc_categoria_cliente" => ms_escape_string(trim($_POST["nombreCategoriaCliente"])),
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual);
			$respuesta = ModeloCategoriaCliente::mdlEditarCategoriaCliente($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEditarCategoriaCliente
	/*=============================================
	ELIMINAR CATEGORIA CLIENTE
	=============================================*/
	static public function ctrEliminarCategoriaCliente(){
		if(isset($_POST["accionCategoriaCliente"]) && $_POST["accionCategoriaCliente"] == "eliminar"){
			$tabla ="vtama_categoria_cliente";
			$datos = $_POST["codigoCategoriaCliente"];
			$respuesta = ModeloCategoriaCliente::mdlEliminarCategoriaCliente($tabla, $datos);
			return $respuesta;
		}//if
	}//function ctrEliminarCategoriaCliente
}//class ControladorCategoriaCliente