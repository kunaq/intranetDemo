<?php
require_once "conexion.php";
class ModeloFormaPago{
	/*=============================================
	MOSTRAR FORMA DE PAGO
	=============================================*/
	static public function mdlMostrarFormaPago($tabla,$item,$valor){
		$db = new Conexion();
		if($item != null){
			$sql = $db->consulta("SELECT cod_forma_pago,dsc_forma_pago FROM $tabla WHERE $item = '$valor'");
			$datos = arrayMapUtf8Encode($db->recorrer($sql));
		}else{
			$sql = $db->consulta("SELECT cod_forma_pago,dsc_forma_pago FROM $tabla");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}// function mdlMostrarFormaPago
	/*=============================================
	INGRESA FORMA DE PAGO
	=============================================*/
	static public function mdlIngresarFormaPago($tabla,$datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("INSERT INTO $tabla(cod_forma_pago,dsc_forma_pago,cod_usr_registro,fch_registro) VALUES('".$datos['cod_forma_pago']."','".$datos['dsc_forma_pago']."','".$datos["cod_usr_registro"]."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarFormaPago
	/*=============================================
	EDITAR FORMA PAGO
	=============================================*/
	static public function mdlEditarFormaPago($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_forma_pago = '".$datos["dsc_forma_pago"]."',cod_usr_modifica = '".$datos["cod_usr_modifica"]."', fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_forma_pago = '".$datos["cod_forma_pago"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarFormaPago
	/*=============================================
	ELIMINAR FORMA PAGO
	=============================================*/
	static public function mdlEliminarFormaPago($tabla,$datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_forma_pago = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarFormaPago
}//class ModeloFormaPago