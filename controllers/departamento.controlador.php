<?php

class ControladorDepartamento{

	/*=============================================
	MOSTRAR DEPARTAMENTOS
	=============================================*/

	static public function ctrMostrarDepartamentos($item1,$valor1,$item2,$valor2,$limite){

		$tabla = "vtama_departamento";

		$respuesta = ModeloDepartamento::mdlMostrarDepartamentos($tabla,$item1,$valor1,$item2,$valor2,$limite);

		return $respuesta;

	}//function ctrMostrarDepartamentos


}//class ControladorDepartamento