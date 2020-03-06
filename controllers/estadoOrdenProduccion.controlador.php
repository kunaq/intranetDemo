<?php
class ControladorEstadoOrdenProduccion{
	/*=============================================
	MOSTRAR ESTADO ORDEN DE PRODUCCION
	=============================================*/
	static public function ctrMostrarEstadoOrdenProduccion($item1,$valor1,$item2,$valor2,$entrada){
		$tabla1 = "vtama_estado_orden_produccion";
		$respuesta = ModeloEstadoOrdenProduccion::mdlMostrarEstadoOrdenProduccion($item1,$valor1,$item2,$valor2,$entrada,$tabla1);
		return $respuesta;
	}//function ctrMostrarEstadoOrdenProduccion
}//class ControladorEstadoOrdeProduccion