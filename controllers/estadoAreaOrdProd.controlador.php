<?php
class ControladorEstadoAreaOrdProd{
	/*=============================================
	MOSTRAR ESTADO AREA ORDEN DE PRODUCCION
	=============================================*/
	static public function ctrMostrarEstadoAreaOrdProd($item1,$valor1,$item2,$valor2,$entrada){
		$tabla1 = "vtama_estado_area_ordenProd";
		$respuesta = ModeloEstadoAreaOrdProd::mdlMostrarEstadoAreaOrdProd($item1,$valor1,$item2,$valor2,$entrada,$tabla1);
		return $respuesta;
	}//function ctrMostrarEstadoOrdenProduccion
}//class ControladorEstadoAreaOrdProd