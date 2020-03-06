<?php
class ControladorTipoDescuento{
	/*=============================================
	MOSTRAR TIPO DE DESCUENTOS
	=============================================*/
	static public function ctrMostrarTipoDescuento($item,$valor){
		$tabla = "vtama_tipo_descuento";
		$respuesta = ModeloTipoDescuento::mdlMostrarTipoDescuento($tabla,$item,$valor);
		return $respuesta;
	}//function ctrMostrarTipoDescuento
}//class ControladorTipoDescuento