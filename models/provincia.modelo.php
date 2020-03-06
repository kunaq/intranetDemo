<?php
require_once "conexion.php";
class ModeloProvincia{
	/*=============================================
	MOSTRAR PROVINCIAS
	=============================================*/
	static public function mdlMostrarProvincias($tabla,$item1,$valor1,$item2,$valor2,$item3,$valor3){
		$db = new Conexion();
		if($item3 != null){
			$sql = $db->consulta("SELECT * FROM $tabla WHERE $item1 = '$valor1' AND $item2 = '$valor2' AND $item3 = '$valor3'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			if($item1 != null){
				$sql = $db->consulta("SELECT * FROM $tabla WHERE $item1 = '$valor1' AND $item2 = '$valor2'");
			}else{
				$sql = $db->consulta("SELECT * FROM $tabla");
			}
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
		$db->liberar($sql);
        $db->cerrar();
		return $datos;
	}//function mdlMostrarProvincias
}//class ModeloProvincia