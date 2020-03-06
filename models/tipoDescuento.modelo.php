<?php
require_once "conexion.php";
class ModeloTipoDescuento{
	/*=============================================
	MOSTRAR TIPOS DE DESCUENTO
	=============================================*/
	static public function mdlMostrarTipoDescuento($tabla,$item,$valor){
		$db = new Conexion();
		if($item != null){
			$sql = $db->consulta("SELECT * FROM $tabla WHERE $item = '$valor'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			$sql = $db->consulta("SELECT * FROM $tabla");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}//function mdlMostrarTipoDescuento
}//class ModeloTipoDescuento