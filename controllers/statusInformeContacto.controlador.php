<?php
class ControladorStatusInformeContacto{
	/*=============================================
	MOSTRAR STATUS INFORME CONTACTO
	=============================================*/
	static public function ctrMostrarStatusInformeContacto($item,$valor){
		$tabla = "vtama_status_informe_contacto";
		$respuesta = ModeloStatusInformeContacto::mdlMostrarStatusInformeContacto($tabla,$item,$valor);
		return $respuesta;
	}//function ctrMostrarStatusInformeContacto
}//class ControladorStatusInformeContacto