<?php
require_once "conexion.php";
class ModeloCargoTrabajador{
	/*=============================================
	MOSTRAR CARGO TRABAJADOR
	=============================================*/
	static public function ctrMostrarCargoTrabajador($tabla,$item,$valor){
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
	}//function ctrMostrarCargoTrabajador
}//class ModeloCargoTrabajador