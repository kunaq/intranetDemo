<?php
class ControladorMoneda{
	/*=============================================
	MOSTRAR MONEDA
	=============================================*/
	static public function ctrMostrarMoneda($item,$valor){
		$tabla = "vtama_moneda";
		$respuesta = ModeloMoneda::mdlMostrarMoneda($tabla,$item,$valor);
		return $respuesta;
	}//function ctrMostrarMoneda
	/*=============================================
	CREAR MONEDA
	=============================================*/
	static public function ctrCrearMoneda(){
		if(isset($_POST["accionMoneda"]) && $_POST["accionMoneda"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_moneda';
			$codMoneda = maximoCodigoTabla($tabla,'cod_moneda','');
			$datos = array("cod_moneda" => $codMoneda,
						   "dsc_moneda" => ms_escape_string(trim($_POST["nombreMoneda"])),
						   "dsc_simbolo" => ms_escape_string(trim($_POST["simboloMoneda"])),
						   "cod_usr_registro" => $_SESSION["cod_trabajador"],
						   "fch_registro" => $fechaActual);
			$respuesta = ModeloMoneda::mdlIngresarMoneda($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEditarMoneda
	/*=============================================
	EDITAR MONEDA
	=============================================*/
	static public function ctrEditarMoneda(){
		if(isset($_POST["accionMoneda"]) && $_POST["accionMoneda"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_moneda';
			$datos = array("cod_moneda" => $_POST["codigoMoneda"],
						   "dsc_moneda" => ms_escape_string(trim($_POST["nombreMoneda"])),
						   "dsc_simbolo" => ms_escape_string(trim($_POST["simboloMoneda"])),
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual);
			$respuesta = ModeloMoneda::mdlEditarMoneda($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEditarMoneda
	/*=============================================
	ELIMINAR MONEDA
	=============================================*/
	static public function ctrEliminarMoneda(){
		if(isset($_POST["accionMoneda"]) && $_POST["accionMoneda"] == "eliminar"){
			$tabla ="vtama_moneda";
			$datos = $_POST["codigoMoneda"];
			$respuesta = ModeloMoneda::mdlEliminarMoneda($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEliminarMoneda
}//class ControladorMoneda