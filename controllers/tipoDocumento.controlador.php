<?php
class ControladorTipoDocumento{
	/*=============================================
	MOSTRAR TIPO DE DOCUMENTOS
	=============================================*/
	static public function ctrMostrarTipoDocumento($item,$valor){
		$tabla = "vtama_tipo_documento";
		$respuesta = ModeloTipoDocumento::mdlMostrarTipoDocumento($tabla,$item,$valor);
		return $respuesta;
	}//function ctrMostrarTipoDocumento
	/*=============================================
	CREAR TIPO DE DOCUMENTO
	=============================================*/
	static public function ctrCrearTipoDocumento(){
		if(isset($_POST["accionTipoDocumento"]) && $_POST["accionTipoDocumento"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_tipo_documento';
			$codTipoDocumento = maximoCodigoTabla($tabla,'cod_tipo_documento','DI');
			$datos = array("cod_tipo_documento" => $codTipoDocumento,
						   "dsc_tipo_documento" => ms_escape_string(trim($_POST["nombreTipoDocumento"])),
						   "cod_usr_registro" => $_SESSION["cod_trabajador"],
						   "fch_registro" => $fechaActual);
			$respuesta = ModeloTipoDocumento::mdlIngresarTipoDocumento($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrCrearTipoDocumento
	/*=============================================
	EDITAR TIPO DE DOCUMENTO
	=============================================*/
	static public function ctrEditarTipoDocumento(){
		if(isset($_POST["accionTipoDocumento"]) && $_POST["accionTipoDocumento"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_tipo_documento';
			$datos = array("cod_tipo_documento" => $_POST["codigoTipoDocumento"],
						   "dsc_tipo_documento" => ms_escape_string(trim($_POST["nombreTipoDocumento"])),
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual);
			$respuesta = ModeloTipoDocumento::mdlEditarTipoDocumento($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrCrearTipoDocumento
	/*=============================================
	ELIMINAR TIPO DE DOCUMENTO
	=============================================*/
	static public function ctrEliminarTipoDocumento(){
		if(isset($_POST["accionTipoDocumento"]) && $_POST["accionTipoDocumento"] == "eliminar"){
			$tabla ="vtama_tipo_documento";
			$datos = $_POST["codigoTipoDocumento"];
			$respuesta = ModeloTipoDocumento::mdlEliminarTipoDocumento($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEliminarTipoDocumento
}//class ControladorTipoDocumento