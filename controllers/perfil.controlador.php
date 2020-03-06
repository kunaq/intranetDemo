<?php
class ControladorPerfil{
	/*=============================================
	MOSTRAR PERFIL
	=============================================*/
	static public function ctrMostrarPerfil($item,$valor){
		$tabla = "vtama_perfil";
		$respuesta = ModeloPerfil::mdlMostrarPerfil($tabla,$item,$valor);
		return $respuesta;
	}//function ctrMostrarPerfil
	/*=============================================
	EDITAR PERFIL
	=============================================*/
	static public function ctrEditarPerfil(){
		if(isset($_POST["accionPerfil"]) && $_POST["accionPerfil"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_perfil';
			$datos = array("cod_perfil" => $_POST["codigoPerfil"],
						   "dsc_perfil" => ms_escape_string(trim($_POST["nombrePerfil"])),
						   "dsc_detalle" => ms_escape_string(trim($_POST["detallePerfil"])),
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual);
			$respuesta = ModeloPerfil::mdlEditarPerfil($tabla,$datos);
			return $respuesta;
		}//if
	}//function ctrEditarPerfil
}//class ControladorPerfil