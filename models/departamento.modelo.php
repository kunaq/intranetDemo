<?php
require_once "conexion.php";
class ModeloDepartamento{
	/*=============================================
	MOSTRAR DEPARTAMENTOS
	=============================================*/
	static public function mdlMostrarDepartamentos($tabla,$item1,$valor1,$item2,$valor2,$limite){
		$db = new Conexion();
		if($item2 != null){
			$sql = $db->consulta("SELECT * FROM $tabla WHERE $item1 = '$valor1' AND $item2 = '$valor2'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			if($limite != null){
				$sql = $db->consulta("SELECT TOP($limite) * FROM $tabla WHERE $item1 = '$valor1'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else{
				$sql = $db->consulta("SELECT * FROM $tabla WHERE $item1 = '$valor1'");
				$datos = array();
			    while($key = $db->recorrer($sql)){
			    	$datos[] = arrayMapUtf8Encode($key);
			    }
			}
		}
		$db->liberar($sql);
        $db->cerrar();
		return $datos;
	}//function mdlMostrarDepartamentos
}//class ModeloDepartamento