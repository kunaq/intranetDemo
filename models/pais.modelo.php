<?php
require_once "conexion.php";
class ModeloPaises{
	/*=============================================
	MOSTRAR PAISES
	=============================================*/
	static public function mdlMostrarPaises($tabla,$item,$valor){
		$db = new Conexion();
		if($item != null){
			$sql = $db->consulta("SELECT cod_pais,dsc_pais FROM $tabla WHERE $item = '$valor'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			$sql = $db->consulta("SELECT cod_pais,dsc_pais FROM $tabla ORDER BY flg_peru DESC");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
		$db->liberar($sql);
        $db->cerrar();
		return $datos;
	}//function mdlMostrarPaises
	/*=============================================
	CREAR PAIS
	=============================================*/
	static public function mdlIngresarPais($tabla,$datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("INSERT INTO $tabla(cod_pais,dsc_pais,cod_usr_registro,fch_registro) VALUES('".$datos['cod_pais']."','".$datos['dsc_pais']."','".$datos["cod_usr_registro"]."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarPais
	/*=============================================
	EDITAR PAIS
	=============================================*/
	static public function mdlEditarPais($tabla,$datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_pais = '".$datos["dsc_pais"]."', cod_usr_modifica = '".$datos["cod_usr_modifica"]."', fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_pais = '".$datos["cod_pais"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarPais
	/*=============================================
	ELIMINAR PAIS
	=============================================*/
	static public function mdlEliminarPais($tabla,$datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_pais = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarPais
}//class ModeloPaises