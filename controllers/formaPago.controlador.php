<?php
class ControladorFormaPago{
	/*=============================================
	MOSTRAR FORMA DE PAGOS
	=============================================*/
	static public function ctrMostrarFormaPago($item,$valor){
		$tabla = "vtama_forma_pago";
		$respuesta = ModeloFormaPago::mdlMostrarFormaPago($tabla,$item,$valor);
		return $respuesta;
	}//function ctrMostrarFormaPago
	/*=============================================
	CREAR FORMA PAGO
	=============================================*/
	static public function ctrCrearFormaPago(){
		if(isset($_POST["accionFormaPago"]) && $_POST["accionFormaPago"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_forma_pago';
			$codFormaPago = maximoCodigoTabla($tabla,'cod_forma_pago','');
			$datos = array("cod_forma_pago" => $codFormaPago,
						   "dsc_forma_pago" => ms_escape_string(trim($_POST["nombreFormaPago"])),
						   "cod_usr_registro" => $_SESSION["cod_trabajador"],
						   "fch_registro" => $fechaActual);
			$respuesta = ModeloFormaPago::mdlIngresarFormaPago($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrCrearFormaPago
	/*=============================================
	EDITAR FORMA PAGO
	=============================================*/
	static public function ctrEditarFormaPago(){
		if(isset($_POST["accionFormaPago"]) && $_POST["accionFormaPago"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_forma_pago';
			$datos = array("cod_forma_pago" => $_POST["codigoFormaPago"],
						   "dsc_forma_pago" => ms_escape_string(trim($_POST["nombreFormaPago"])),
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual);
			$respuesta = ModeloFormaPago::mdlEditarFormaPago($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEditarFormaPago
	/*=============================================
	ELIMINAR FORMA DE PAGO
	=============================================*/
	static public function ctrEliminarFormaPago(){
		if(isset($_POST["accionFormaPago"]) && $_POST["accionFormaPago"] == "eliminar"){
			$tabla ="vtama_forma_pago";
			$datos = $_POST["codigoFormaPago"];
			$respuesta = ModeloFormaPago::mdlEliminarFormaPago($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEliminarFormaPago
}//class ControladorFormaPago