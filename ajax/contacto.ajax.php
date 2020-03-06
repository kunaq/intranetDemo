<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/contacto.controlador.php";
require_once "../models/contacto.modelo.php";
class AjaxContacto{
	/*=============================================
	CREAR CONTACTO
	=============================================*/
	public function ajaxCrearContacto(){
		$respuesta = ControladorContacto::ctrCrearContacto();
		echo $respuesta;
	}//function ajaxCrearContacto
	/*=============================================
	EDITAR CONTACTO
	=============================================*/
	public function ajaxEditarContacto(){
		$respuesta = ControladorContacto::ctrEditarContacto();
		echo $respuesta;
	}//function ajaxEditarContacto
	/*=============================================
	ELIMINAR CONTACTO
	=============================================*/
	public function ajaxEliminarContacto(){
		$respuesta = ControladorContacto::ctrEliminarContacto();
		echo $respuesta;
	}//function ajaxEliminarContacto
	/*=============================================
	MOSTRAR INFORME CONTACTO
	=============================================*/
	public function ajaxMostrarInformeContacto(){
		$item = "cod_contacto";
		$valor = $_POST["codContacto"];
		$item2 = "num_linea";
		$valor2 = (isset($_POST["numLineaInforme"])) ? $_POST["numLineaInforme"] : null;
		$respuesta = ControladorContacto::ctrMostrarInformeContacto($item,$valor,$item2,$valor2);
		//var_dump($respuesta);
		if($valor2 == null){
			foreach ($respuesta as $key => $value) {
				$respuesta[$key] = trimForeach($value);			
				$respuesta[$key]["fch_informe"] = dateFormat($respuesta[$key]["fch_informe"]);
				$respuesta[$key]["fch_programada"] = dateFormat($respuesta[$key]["fch_programada"]);
				//$respuesta[$key]["dsc_ruta_archivo_adjunto"] = escapeComillasJson2($respuesta[$key]["dsc_ruta_archivo_adjunto"]);
			}//foreach
		}else{
			$respuesta["fch_informe"] = dateFormat($respuesta["fch_informe"]);
			$respuesta["fch_programada"] = dateFormat($respuesta["fch_programada"]);
		}
		
		echo json_encode($respuesta);
	}//function ajaxMostrarInformeContacto
	/*=============================================
	SUBIR ARCHIVO CONTACTO INFORME
	=============================================*/
	public function ajaxSubirArchivoInformeContacto(){
		$respuesta = ControladorContacto::ctrSubirArchivoInformeContacto();
		echo $respuesta;
	}//function ajaxCrearContacto
	/*=============================================
	ELIMINAR CONTACTO INFORME
	=============================================*/
	public function ajaxEliminarInformeContacto(){
		$respuesta = ControladorContacto::ctrEliminarInformeContacto();
		echo $respuesta;
	}//function ajaxCrearContacto
	/*=============================================
	ELIMINAR CONTACTO INFORME
	=============================================*/
	public function ajaxCancelarInformeContacto(){
		$respuesta = ControladorContacto::ctrCancelarInformeContacto();
		echo $respuesta;
	}//function ajaxCrearContacto
	/*=============================================
	EDITAR CONTACTO INFORME
	=============================================*/
	public function ajaxEditarInformeContacto(){
		$respuesta = ControladorContacto::ctrEditarInformeContacto();
		echo $respuesta;
	}//function ajaxCrearContacto
}//class AjaxContacto
/*=============================================
ACCIONES CONTACTO
=============================================*/
if(isset($_POST["accionContacto"]) && $_POST["accionContacto"] == 'crear'){
	$contacto = new AjaxContacto();
	$contacto -> ajaxCrearContacto();
}else if(isset($_POST["accionContacto"]) && $_POST["accionContacto"] == 'editar'){
	$contacto = new AjaxContacto();
	$contacto -> ajaxEditarContacto();
}else if(isset($_POST["accionContacto"]) && $_POST["accionContacto"] == 'eliminar'){
	$contacto = new AjaxContacto();
	$contacto -> ajaxEliminarContacto();
}else if(isset($_POST["accionInformeContacto"]) && $_POST["accionInformeContacto"] == 'mostrar'){
	$contacto = new AjaxContacto();
	$contacto -> ajaxMostrarInformeContacto();
}else if(isset($_POST["accionInformeContacto"]) && $_POST["accionInformeContacto"] == 'subirArchivo'){
	$contacto = new AjaxContacto();
	$contacto -> ajaxSubirArchivoInformeContacto();
}else if(isset($_POST["accionInformeContacto"]) && $_POST["accionInformeContacto"] == 'eliminar'){
	$contacto = new AjaxContacto();
	$contacto -> ajaxEliminarInformeContacto();
}else if(isset($_POST["accionInformeContacto"]) && $_POST["accionInformeContacto"] == 'cancelar'){
	$contacto = new AjaxContacto();
	$contacto -> ajaxCancelarInformeContacto();
}else if(isset($_POST["accionInformeContacto"]) && $_POST["accionInformeContacto"] == 'editar'){
	$contacto = new AjaxContacto();
	$contacto -> ajaxEditarInformeContacto();
}