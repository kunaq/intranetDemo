<?php
require_once "conexion.php";
class ModeloDistrito{
	/*=============================================
	MOSTRAR DISTRITOS
	=============================================*/
	static public function mdlMostrarDistritos($tabla,$item1,$valor1,$item2,$valor2,$item3,$valor3,$item4,$valor4){
		$db = new Conexion();
		if($item4 != null){
			$sql = $db->consulta("SELECT * FROM $tabla WHERE $item1 = '$valor1' AND $item2 = '$valor2' AND $item3 = '$valor3' AND $item4 = '$valor4'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			if($item3 != null){
				$sql = $db->consulta("SELECT * FROM $tabla WHERE $item1 = '$valor1' AND $item2 = '$valor2' AND $item3 = '$valor3'");
				$datos = array();
				while($key = $db->recorrer($sql)){
			    	$datos[] = arrayMapUtf8Encode($key);
			    }
			}else{
				$sql = $db->consulta("SELECT * FROM $tabla WHERE flg_activo = 'SI'");
				$datos = array();
			    while($key = $db->recorrer($sql)){
			    	$datos[] = arrayMapUtf8Encode($key);
			    }
			}
		}
		$db->liberar($sql);
        $db->cerrar();
	    return $datos;
	}// function mdlMostrarDistritos
}//class ModeloDistrito