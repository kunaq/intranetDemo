<?php
class ControladorDocumento{
	/*=============================================
	MOSTRAR DOCUMENTO
	=============================================*/
	static public function ctrMostrarDocumento($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada){
		$tabla1 = 'rhuma_documento';
		$tabla2 = 'feivi_orden_produccion_documento';
		$respuesta = ModeloDocumento::mdlMostrarDocumento($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada,$tabla1,$tabla2);
		return $respuesta;
	}//function ctrMostrarDocumento
}//class ControladorDocumento