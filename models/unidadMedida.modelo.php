<?php
require_once "conexion.php";
class ModeloUnidadMedida{
	/*=============================================
	MOSTRAR UNIDAD MEDIDA
	=============================================*/
	static public function mdlMostrarUnidadMedida($tabla,$item,$valor,$entrada){
		$db = new Conexion();
		if($item != null){
			$sql = $db->consulta("SELECT * FROM $tabla WHERE $item = '$valor'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			if($entrada == "detalleCotizacion"){
				$sql = $db->consulta("SELECT cod_unidad,dsc_simbolo FROM $tabla");
			}else if($entrada == "inputSelect"){
				$sql = $db->consulta("SELECT cod_unidad,dsc_simbolo FROM $tabla");
			}else{
				$sql = $db->consulta("SELECT * FROM $tabla");
			}
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}// function mdlMostrarUnidadMedida
}//class ModeloUnidadMedida