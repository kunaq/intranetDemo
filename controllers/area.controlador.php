<?php
class ControladorArea{
	/*=============================================
	MOSTRAR AREA
	=============================================*/
	static public function ctrMostrarArea($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$item5,$valor5,$entrada){
		$tabla1 = 'rhuma_area';
		$tabla2 = 'feivi_orden_produccion_area';
		$tabla3 = 'vtama_estado_area_ordenProd';
		$respuesta = ModeloArea::mdlMostrarArea($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$item5,$valor5,$entrada,$tabla1,$tabla2,$tabla3);
		return $respuesta;
	}//function ctrMostrarArea

	static public function ctrMostrarResumenArea($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$item5,$valor5,$entrada){
		$tabla1 = 'rhuma_area';
		$tabla2 = 'feivi_orden_produccion_area';
		$tabla3 = 'vtama_estado_area_ordenProd';
		$respuesta = ModeloArea::mdlMostrarResumenArea($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4,$item5,$valor5,$entrada,$tabla1,$tabla2,$tabla3);
		return $respuesta;
	}//function ctrMostrarResumenArea
}//class ControladorArea