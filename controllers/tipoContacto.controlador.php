<?php
class ControladorTipoContacto{
	/*=============================================
	CREAR TIPO CONTACTO
	=============================================*/
	static public function ctrCrearTipoContacto(){
		if(isset($_POST["accionTipoContacto"]) && $_POST["accionTipoContacto"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_tipo_contacto';
			$codTipoContacto = maximoCodigoTabla($tabla,'cod_tipo_contacto','');
			$datos = array("cod_tipo_contacto" => $codTipoContacto,
						   "dsc_tipo_contacto" => ms_escape_string(trim($_POST["nombreTipoContacto"])),
						   "cod_usr_registro" => $_SESSION["cod_trabajador"],
						   "fch_registro" => $fechaActual
						);
			$respuesta = ModeloTipoContacto::mdlIngresarTipoContacto($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrCrearTipoContacto
	/*=============================================
	MOSTRAR TIPO CONTACTO
	=============================================*/
	static public function ctrMostrarTipoContacto($item,$valor){
		$tabla = "vtama_tipo_contacto";
		$respuesta = ModeloTipoContacto::mdlMostrarTipoContacto($tabla,$item,$valor);
		return $respuesta;
	}//function ctrMostrarTipoContactos
	/*=============================================
	EDITAR TIPO CONTACTO
	=============================================*/
	static public function ctrEditarTipoContacto(){
		if(isset($_POST["accionTipoContacto"]) && $_POST["accionTipoContacto"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_tipo_contacto';
			$datos = array("cod_tipo_contacto" => $_POST["codigoTipoContacto"],
						   "dsc_tipo_contacto" => ms_escape_string(trim($_POST["nombreTipoContacto"])),
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual);
			$respuesta = ModeloTipoContacto::mdlEditarTipoContacto($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEditarTipoContacto
	/*=============================================
	ELIMINAR TIPO CONTACTO
	=============================================*/
	static public function ctrEliminarTipoContacto(){
		if(isset($_POST["accionTipoContacto"]) && $_POST["accionTipoContacto"] == "eliminar"){
			$tabla ="vtama_tipo_contacto";
			$datos = $_POST["codigoTipoContacto"];
			$respuesta = ModeloTipoContacto::mdlEliminarTipoContacto($tabla, $datos);
			return $respuesta;
		}//if
	}//function ctrEliminarTipoContacto
}//class ControladorTipoContacto