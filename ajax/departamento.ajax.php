<?php

require_once "../core.php";
require_once "../funciones.php";

require_once "../controllers/departamento.controlador.php";
require_once "../models/departamento.modelo.php";

class AjaxDepartamentos{

	public $codPais;

	public function ajaxMostrarDepartamentos(){

		$item1 = "cod_pais";
		$valor1 = $this->codPais;

		$item2 = null;
		$valor2 = null;

		$limite = null;

		$respuesta = ControladorDepartamento::ctrMostrarDepartamentos($item1,$valor1,$item2,$valor2,$limite);

		echo json_encode($respuesta);

	}//function ajaxMostrarDepartamentos

}//class AjaxClientes

/*=============================================
TRAER LOS DEPARTAMENTOS DE ACUERDO AL PAIS 
SELECCIONADO
=============================================*/

if(isset($_POST["codPais"])){

	$mostrarDepartamentos = new AjaxDepartamentos();
	$mostrarDepartamentos -> codPais = $_POST["codPais"];
	$mostrarDepartamentos -> ajaxMostrarDepartamentos();


}
