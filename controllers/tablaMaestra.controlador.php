<?php
class ControladorTablaMaestra{
	/*=============================================
	MOSTRAR TABLA MAESTRA
	=============================================*/
	static public function ctrMostrarTablaMaestra($item,$valor){
		$tabla = "vtama_tabla_maestra";
		$respuesta = ModeloTablaMaestra::mdlMostrarTablaMaestra($tabla,$item,$valor);
		return $respuesta;
	}//function ctrMostrarTablaMaestra
}//class ControladorTablaMaestra