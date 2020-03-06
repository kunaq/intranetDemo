<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/empresa.controlador.php";
require_once "../models/empresa.modelo.php";
class AjaxNosotros{
	/*=============================================
	EDITAR HISTORIA
	=============================================*/
	public function ajaxActualizarEmpresa(){
		$item = "dsc_".$_POST["name"];
		$valor = ms_escape_string(trim($_POST["value"]));
		$respuesta = ControladorEmpresa::ctrActualizarEmpresa($item,$valor);
		echo $respuesta;
	}//function ajaxActualizarEmpresa
}//class AjaxNosotros
$nosotros = new AjaxNosotros();
$nosotros -> ajaxActualizarEmpresa();