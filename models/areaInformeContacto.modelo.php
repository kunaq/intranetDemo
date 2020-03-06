<?php
require_once "conexion.php";
class ModeloAreaInformeContacto{
	/*=============================================
	MOSTRAR AREA INFORME CONTACTO
	=============================================*/
	static public function mdlMostrarAreaInformeContacto($tabla,$item,$valor){
		$db = new Conexion();
		if($item != null){			
		}else{
			$sql = $db->consulta("SELECT cod_area,dsc_area FROM $tabla");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}// function mdlMostrarAreaInformeContacto	
}//class ModeloAreaInformeContacto