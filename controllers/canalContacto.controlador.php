<?php
class ControladorCanalContacto{
	/*=============================================
	MOSTRAR CANAL CONTACTO
	=============================================*/
	static public function ctrMostrarCanalContacto($item,$valor){
		$tabla = "vtama_canal_contacto";
		$respuesta = ModeloCanalContacto::mdlMostrarCanalContacto($tabla,$item,$valor);
		return $respuesta;
	}//function ctrMostrarCanalContacto
	/*=============================================
	CREAR CANAL CONTACTO
	=============================================*/
	static public function ctrCrearCanalContacto(){
		if(isset($_POST["accionCanalContacto"]) && $_POST["accionCanalContacto"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_canal_contacto';
			$codCanalContacto = maximoCodigoTabla($tabla,'cod_canal_contacto','');
			$datos = array("cod_canal_contacto" => $codCanalContacto,
						   "dsc_canal_contacto" => ms_escape_string(trim($_POST["nombreCanalContacto"])),
						   "cod_usr_registro" => $_SESSION["cod_trabajador"],
						   "fch_registro" => $fechaActual
						);
			$respuesta = ModeloCanalContacto::mdlIngresarCanalContacto($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrCrearCanalContacto	
	/*=============================================
	EDITAR CANAL CONTACTO
	=============================================*/
	static public function ctrEditarCanalContacto(){
		if(isset($_POST["accionCanalContacto"]) && $_POST["accionCanalContacto"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_canal_contacto';
			$datos = array("cod_canal_contacto" => $_POST["codigoCanalContacto"],
						   "dsc_canal_contacto" => ms_escape_string(trim($_POST["nombreCanalContacto"])),
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual);
			$respuesta = ModeloCanalContacto::mdlEditarCanalContacto($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEditarCanalContacto
	/*=============================================
	ELIMINAR CANAL CONTACTO
	=============================================*/
	static public function ctrEliminarCanalContacto(){
		if(isset($_POST["accionCanalContacto"]) && $_POST["accionCanalContacto"] == "eliminar"){
			$tabla ="vtama_canal_contacto";
			$datos = $_POST["codigoCanalContacto"];
			$respuesta = ModeloCanalContacto::mdlEliminarCanalContacto($tabla, $datos);
			return $respuesta;
		}//if
	}//function ctrEliminarCanalContacto
}//class ControladorCanalContacto