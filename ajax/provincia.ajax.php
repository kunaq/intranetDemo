<?php

require_once "../core.php";
require_once "../funciones.php";

require_once "../controllers/departamento.controlador.php";
require_once "../models/departamento.modelo.php";

require_once "../controllers/provincia.controlador.php";
require_once "../models/provincia.modelo.php";

class AjaxProvincia{

	public $codPais;
	public $codDepartamento;

	public function ajaxMostrarProvincias(){

		if($this->codDepartamento != null){

			$item1 = "cod_pais";
			$valor1 = $this->codPais;

			$item2 = "cod_departamento";
			$valor2 = $this->codDepartamento;

			$item3 = null;
			$valor3 = null;

			$respuesta = ControladorProvincia::ctrMostrarProvincias($item1,$valor1,$item2,$valor2,$item3,$valor3);

			echo json_encode($respuesta);


		}else{

			$item1 = "cod_pais";
			$valor1 = $this->codPais;

			$itemDepartamento2 = null;
			$valorDepartamento2 = null;

			$item2 = "cod_departamento";
			$limite = 1;
			$valor2 = ControladorDepartamento::ctrMostrarDepartamentos($item1,$valor1,$itemDepartamento2,$valorDepartamento2,$limite);

			$item3 = null;
			$valor3 = null;

			$respuesta = ControladorProvincia::ctrMostrarProvincias($item1,$valor1,$item2,$valor2["cod_departamento"],$item3,$valor3);

			echo json_encode($respuesta);

		}

	}//function ajaxMostrarProvincias

}//class AjaxProvincia

/*=============================================
TRAER LAS PROVINCIAS DE ACUERDO AL PAIS
SELECCIONADO
=============================================*/

if(isset($_POST["codPais"])){

	if(isset($_POST["codDepartamento"])){

		$mostrarProvincia = new AjaxProvincia();
		$mostrarProvincia -> codPais = $_POST["codPais"];
		$mostrarProvincia -> codDepartamento = $_POST["codDepartamento"];
		$mostrarProvincia -> ajaxMostrarProvincias();

	}else{

		$mostrarProvincia = new AjaxProvincia();
		$mostrarProvincia -> codPais = $_POST["codPais"];
		$mostrarProvincia -> ajaxMostrarProvincias();

	}


}

/*=============================================
TRAER LAS PROVINCIAS DE ACUERDO AL PAIS Y DEPARTAMENTO
SELECCIONADO
=============================================*/

if(isset($_POST["codDepartamento"])){

	

}
