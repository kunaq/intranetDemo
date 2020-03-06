<?php
require_once "conexion.php";
class ModeloTablaMaestra{
	/*=============================================
	MOSTRAR TABLA MAESTRA
	=============================================*/
	static public function mdlMostrarTablaMaestra($tabla,$item,$valor){
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
		$db->liberar($sql);
        $db->cerrar();
		return $datos;
	}//function mdlMostrarTablaMaestra
}//class ModeloTablaMaestra