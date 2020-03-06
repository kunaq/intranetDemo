<?php
class ControladorEmpresa{
	/*=============================================
	MOSTRAR EMPRESA
	=============================================*/
	static public function ctrMostrarEmpresa($entrada){
		$tabla = "scfma_empresa";
		$respuesta = ModeloEmpresa::mdlMostrarEmpresa($tabla,$entrada);
		return $respuesta;
	}//function ctrMostrarEmpresa
	/*=============================================
	EDITAR HISTORIA
	=============================================*/
	static public function ctrActualizarEmpresa($item,$valor){
		$tabla = "scfma_empresa";
		$respuesta = ModeloEmpresa::mdlActualizarEmpresa($tabla,$item,$valor);
		return $respuesta;
	}//function ctrActualizarEmpresa
}//class ControladorEmpresa