<?php

class ControladorProvincia{

	/*=============================================
	MOSTRAR PROVINCIAS
	=============================================*/

	static public function ctrMostrarProvincias($item1,$valor1,$item2,$valor2,$item3,$valor3){

		$tabla = "vtama_provincia";

		$respuesta = ModeloProvincia::mdlMostrarProvincias($tabla,$item1,$valor1,$item2,$valor2,$item3,$valor3);

		return $respuesta;

	}//function ctrMostrarProvincias


}//class ControladorProvincia