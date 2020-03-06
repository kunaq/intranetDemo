<?php
class ControladorEstadoCotizacion{
	/*=============================================
	MOSTRAR ESTADO COTIZACION
	=============================================*/
	static public function ctrMostrarEstadoCotizacion($item,$valor,$entrada){
		$tabla = "vtama_estado_cotizacion";
		$respuesta = ModeloEstadoCotizacion::mdlMostrarEstadoCotizacion($tabla,$item,$valor,$entrada);
		return $respuesta;
	}//function ctrMostrarEstadoCotizacion
	/*=============================================
	EDITAR CATEGORIA CLIENTE
	=============================================*/
	static public function ctrEditarEstadoCotizacion(){
		if(isset($_POST["accionEstadoCotizacion"]) && $_POST["accionEstadoCotizacion"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_estado_cotizacion';
			$datos = array("cod_estado_cotizacion" => $_POST["codigoEstadoCotizacion"],
						   "dsc_estado_cotizacion" => ms_escape_string(trim($_POST["nombreEstadoCotizacion"])),
						   "dsc_color" => $_POST["colorEstadoCotizacion"],
						   "dsc_detalle" => ms_escape_string(trim($_POST["detalleEstadoCotizacion"])),
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual);
			$respuesta = ModeloEstadoCotizacion::mdlEditarEstadoCotizacion($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEditarEstadoCotizacion
}//class ControladorEstadoCotizacion