<?php
class ControladorAreaInformeContacto{
	/*=============================================
	MOSTRAR AREA INFORME CONTACTO
	=============================================*/
	static public function ctrMostrarAreaInformeContacto($item,$valor){
		$tabla = "vtama_area_informe_contacto";
		$respuesta = ModeloAreaInformeContacto::mdlMostrarAreaInformeContacto($tabla,$item,$valor);
		return $respuesta;
	}//function ctrMostrarAreaInformeContacto
}//class ControladorAreaInformeContacto