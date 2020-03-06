<?php
class ControladorEmpresaValores{
	/*=============================================
	MOSTRAR EMPRESA VALORES
	=============================================*/
	static public function ctrMostrarEmpresaValores(){
		$tabla = "scfma_empresa_valores";
		$respuesta = ModeloEmpresaValores::mdlMostrarEmpresaValores($tabla);
		return $respuesta;
	}//function ctrMostrarEmpresaValores
}//class ControladorEmpresaValores