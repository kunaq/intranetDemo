<?php

require_once "../core.php";
require_once "../funciones.php";

require_once "../controllers/distrito.controlador.php";
require_once "../models/distrito.modelo.php";

class AjaxDistrito{

	public $codPais;
	public $codDepartamento;
	public $codProvincia;

	public function ajaxMostrarDistritos(){

		$item1 = "cod_pais";
		$valor1 = $this->codPais;

		$item2 = "cod_departamento";
		$valor2 = $this->codDepartamento;

		$item3 = "cod_provincia";
		$valor3 = $this->codProvincia;

		$item4 = null;
		$valor4 = null;

		$respuesta = ControladorDistrito::ctrMostrarDistritos($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4);

		echo json_encode($respuesta);
	
	}//function ajaxMostrarDistritos



}//class AjaxDistrito

/*=============================================
TRAER LOS DISTRITOS DE ACUERDO A LA PROVINCIA SELECICONADA
=============================================*/
if(isset($_POST["codProvincia"])){

	$mostrarDistrito = new AjaxDistrito();
	$mostrarDistrito -> codPais = $_POST["codPais"];
	$mostrarDistrito -> codDepartamento = $_POST["codDepartamento"];
	$mostrarDistrito -> codProvincia = $_POST["codProvincia"];
	$mostrarDistrito -> ajaxMostrarDistritos();

}