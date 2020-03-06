<?php

class ControladorCargoTrabajador{

	/*=============================================
	MOSTRAR CARGO TRABAJADOR
	=============================================*/

	static public function ctrMostrarCargoTrabajador($item,$valor){

		$tabla = "rhuma_cargo_trabajador";

		$respuesta = ModeloCargoTrabajador::ctrMostrarCargoTrabajador($tabla,$item,$valor);

		return $respuesta;

	}//function ctrMostrarCargoTrabajador


}//class ControladorCargoTrabajador