<?php
class ControladorEstadoContacto{
	/*=============================================
	CREAR ESTADO CONTACTO
	=============================================*/
	static public function ctrCrearEstadoContacto(){
		if(isset($_POST["accionEstadoContacto"]) && $_POST["accionEstadoContacto"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_estado_contacto';
			$codEstadoContacto = maximoCodigoTabla($tabla,'cod_estado_contacto','');
			$datos = array("cod_estado_contacto" => $codEstadoContacto,
						   "dsc_estado_contacto" => ms_escape_string(trim($_POST["nombreEstadoContacto"])),
						   "cod_usr_registro" => $_SESSION["cod_trabajador"],
						   "fch_registro" => $fechaActual
						);
			$respuesta = ModeloEstadoContacto::mdlIngresarEstadoContacto($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrCrearEstadoContacto
	/*=============================================
	MOSTRAR ESTADO CONTACTO
	=============================================*/
	static public function ctrMostrarEstadoContacto($item,$valor){
		$tabla = "vtama_estado_contacto";
		$respuesta = ModeloEstadoContacto::mdlMostrarEstadoContacto($tabla,$item,$valor);
		return $respuesta;
	}//function ctrMostrarEstadoContacto
	/*=============================================
	EDITAR ESTADO CONTACTO
	=============================================*/
	static public function ctrEditarEstadoContacto(){
		if(isset($_POST["accionEstadoContacto"]) && $_POST["accionEstadoContacto"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_estado_contacto';
			$datos = array("cod_estado_contacto" => $_POST["codigoEstadoContacto"],
						   "dsc_estado_contacto" => ms_escape_string(trim($_POST["nombreEstadoContacto"])),
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual);
			$respuesta = ModeloEstadoContacto::mdlEditarEstadoContacto($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEditarEstadoContacto
	/*=============================================
	ELIMINAR ESTADO CONTACTO
	=============================================*/
	static public function ctrEliminarEstadoContacto(){
		if(isset($_POST["accionEstadoContacto"]) && $_POST["accionEstadoContacto"] == "eliminar"){
			$tabla ="vtama_estado_contacto";
			$datos = $_POST["codigoEstadoContacto"];
			$respuesta = ModeloEstadoContacto::mdlEliminarEstadoContacto($tabla, $datos);
			return $respuesta;
		}//if
	}//function ctrEliminarEstadoContacto
}//class ControladorEstadoContacto