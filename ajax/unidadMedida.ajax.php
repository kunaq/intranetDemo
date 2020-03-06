<?php

require_once "../core.php";
require_once "../funciones.php";

require_once "../controllers/unidadMedida.controlador.php";
require_once "../models/unidadMedida.modelo.php";

class AjaxUnidadMedida{	

	/*=============================================
	MOSTRAR UNIDAD MEDIDA
	=============================================*/

	public function ajaxMostrarUnidadMedida(){

		$item = null;
		$valor = null;
		$entrada = (isset($_POST["entrada"])) ? $_POST["entrada"] : null;

		$respuesta = ControladorUnidadMedida::ctrMostrarUnidadMedida($item,$valor,$entrada);

		echo json_encode($respuesta);

	}//function ajaxMostrarUnidadMedida

}//AjaxUnidadMedida

/*=============================================
ACCIONES UNIDAD MEDIDA
=============================================*/

if(isset($_POST["accionUnidadMedida"]) && ($_POST["accionUnidadMedida"] == 'cotizacion' || $_POST["accionUnidadMedida"] == 'mostrar')){

	$unidadMedida = new AjaxUnidadMedida();
	$unidadMedida -> ajaxMostrarUnidadMedida();

}