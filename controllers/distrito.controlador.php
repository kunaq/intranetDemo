<?php
class ControladorDistrito{
	/*=============================================
	MOSTRAR DISTRITOS
	=============================================*/
	static public function ctrMostrarDistritos($item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4){
		$tabla = "vtama_distrito";
		$respuesta = ModeloDistrito::mdlMostrarDistritos($tabla,$item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4);
		return $respuesta;
	}//function ctrMostrarDistritos
}//class ControladorDistrito