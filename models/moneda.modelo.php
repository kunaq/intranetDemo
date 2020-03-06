<?php
require_once "conexion.php";
class ModeloMoneda{
	/*=============================================
	MOSTRAR MONEDAS
	=============================================*/
	static public function mdlMostrarMoneda($tabla,$item,$valor){
		$db = new Conexion();
		if($item != null){
			$sql = $db->consulta("SELECT cod_moneda,dsc_moneda,dsc_simbolo FROM $tabla WHERE $item = '$valor'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			$sql = $db->consulta("SELECT cod_moneda,dsc_moneda,dsc_simbolo FROM $tabla ORDER BY flg_default DESC");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}// function mdlMostrarMoneda
	/*=============================================
	CREAR MONEDA
	=============================================*/
	static public function mdlIngresarMoneda($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("INSERT INTO $tabla(cod_moneda,dsc_moneda,dsc_simbolo,cod_usr_registro,fch_registro) VALUES('".$datos['cod_moneda']."','".$datos['dsc_moneda']."','".$datos['dsc_simbolo']."','".$datos['cod_usr_registro']."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarMoneda
	/*=============================================
	EDITAR MONEDA
	=============================================*/
	static public function mdlEditarMoneda($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_moneda = '".$datos["dsc_moneda"]."',dsc_simbolo = '".$datos["dsc_simbolo"]."',cod_usr_modifica = '".$datos["cod_usr_modifica"]."', fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_moneda = '".$datos["cod_moneda"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarMoneda
	/*=============================================
	ELIMINAR MONEDA
	=============================================*/
	static public function mdlEliminarMoneda($tabla,$datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_moneda = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarMoneda
}//class ModeloMoneda