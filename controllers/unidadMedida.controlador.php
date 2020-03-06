<?php

class ControladorUnidadMedida{

	/*=============================================
	MOSTRAR UNIDAD MEDIDA
	=============================================*/

	static public function ctrMostrarUnidadMedida($item,$valor,$entrada){

		$tabla = "vtama_unidad_medida";

		$respuesta = ModeloUnidadMedida::mdlMostrarUnidadMedida($tabla,$item,$valor,$entrada);

		return $respuesta;

	}//function ctrMostrarUnidadMedida

}//class ControladorUnidadMedida