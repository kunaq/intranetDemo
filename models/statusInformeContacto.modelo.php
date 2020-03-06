<?php
require_once "conexion.php";
class ModeloStatusInformeContacto{
	/*=============================================
	MOSTRAR STATUS INFORME CONTACTO
	=============================================*/
	static public function mdlMostrarStatusInformeContacto($tabla,$item,$valor){
		$db = new Conexion();
		if($item != null){			
		}else{
			$sql = $db->consulta("SELECT cod_status,dsc_status FROM $tabla");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}// function mdlMostrarStatusInformeContacto	
}//class ModeloStatusInformeContacto