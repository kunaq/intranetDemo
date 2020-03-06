<?php
class ControladorPais{
	/*=============================================
	MOSTRAR PAÍSES
	=============================================*/
	static public function ctrMostrarPaises($item,$valor){
		$tabla = "vtama_pais";
		$respuesta = ModeloPaises::mdlMostrarPaises($tabla,$item,$valor);
		return $respuesta;
	}//function ctrMostrarPaises
	/*=============================================
	CREAR PAIS
	=============================================*/
	static public function ctrCrearPais(){
		if(isset($_POST["accionPais"]) && $_POST["accionPais"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_pais';
			$codPais = maximoCodigoTabla($tabla,'cod_pais','PAIS');
			$datos = array("cod_pais" => $codPais,
						   "dsc_pais" => ms_escape_string(trim($_POST["nombrePais"])),
						   "cod_usr_registro" => $_SESSION["cod_trabajador"],
						   "fch_registro" => $fechaActual);
			$respuesta = ModeloPaises::mdlIngresarPais($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrCrearPais
	/*=============================================
	EDITAR PAIS
	=============================================*/
	static public function ctrEditarPais(){
		if(isset($_POST["accionPais"]) && $_POST["accionPais"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_pais';		
			$datos = array("cod_pais" => $_POST["codigoPais"],
						   "dsc_pais" => ms_escape_string(trim($_POST["nombrePais"])),
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual);
			$respuesta = ModeloPaises::mdlEditarPais($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEditarPais
	static public function ctrEliminarPais(){
		if(isset($_POST["accionPais"]) && $_POST["accionPais"] == "eliminar"){
			$tabla ="vtama_pais";
			$datos = $_POST["codigoPais"];
			$respuesta = ModeloPaises::mdlEliminarPais($tabla, $datos);
			return $respuesta;
		}//if
	}//function ctrEliminarPais
}//class ControladorPais