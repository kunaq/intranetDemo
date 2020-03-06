<?php
require_once "conexion.php";
class ModeloGaleria{
	/*=============================================
	MOSTRAR GALERIA
	=============================================*/
	static public function mdlMostrarGaleria($tabla,$item,$valor,$entrada){
		$db = new Conexion();
		if($item != null){
			if($entrada == "validarNombreRepetido"){
				$sql = $db->consulta("SELECT COUNT(dsc_galeria) as contador FROM $tabla WHERE $item = '$valor'");	
				$datos = $db->recorrer($sql);			
			}else if($entrada == "obtenerTotalDatos"){
				$sql = $db->consulta("SELECT cod_galeria,dsc_galeria FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else if($entrada == "obtenerDatosDesdeTipoGaleria"){
				$sql = $db->consulta("SELECT dsc_galeria FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else if($entrada == "capturarNombreGaleria"){
				$sql = $db->consulta("SELECT dsc_galeria FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}
		}else{
			$sql = $db->consulta("SELECT cod_galeria,dsc_galeria FROM $tabla");
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}// function mdlMostrarGaleria
	/*=============================================
	MOSTRAR GALERIA DETALLE
	=============================================*/
	static public function mdlMostrarGaleriaDetalle($tabla,$item,$valor,$entrada){
		$db = new Conexion();
		if($item != null){
			if($entrada == "cantidadFotosXGaleria"){
				$sql = $db->consulta("SELECT COUNT(cod_galeria) as cantidad FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else if($entrada == "maximoNumLineaXGaleria"){
				$sql = $db->consulta("SELECT MAX(num_linea) as maximo FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else if($entrada == "listaTipoGaleria"){
				$sql = $db->consulta("SELECT cod_galeria,num_linea,imagen FROM $tabla WHERE $item = '$valor'");
				$datos = array();
				while($key = $db->recorrer($sql)){
			    	$datos[] = arrayMapUtf8Encode($key);
			    }
			}else if($entrada == "imagenTipoGaleria"){
				$sql = $db->consulta("SELECT imagen FROM $tabla WHERE $item = '$valor'");
				$datos = array();
				while($key = $db->recorrer($sql)){
			    	$datos[] = arrayMapUtf8Encode($key);
			    }
			}
		}
	    return $datos;
	}// function mdlMostrarGaleriaDetalle
	/*=============================================
	CREAR GALERIA
	=============================================*/
	static public function mdlIngresarGaleria($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("INSERT INTO $tabla(cod_galeria,dsc_galeria,cod_usr_registro,fch_registro) VALUES('".$datos['cod_galeria']."','".$datos['dsc_galeria']."','".$datos['cod_usr_registro']."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarGaleria
	/*=============================================
	EDITAR GALERIA
	=============================================*/
	static public function mdlEditarGaleria($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_galeria = '".$datos["dsc_galeria"]."',cod_usr_modifica ='".$datos["cod_usr_modifica"]."',fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_galeria = '".$datos["cod_galeria"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarGaleria
	/*=============================================
	ELIMINAR GALERIA
	=============================================*/
	static public function mdlEliminarGaleria($tabla1,$tabla2,$codigo){
		$db = new Conexion();
		$db->beginTransaction();
		$sql1 = $db->consulta("DELETE FROM $tabla1 WHERE cod_galeria = '".$codigo."'");
		$sql2 = $db->consulta("DELETE FROM $tabla2 WHERE cod_galeria = '".$codigo."'");
		if($sql1 && $sql2){
			$db->commit();
			return "ok";
		}else{
			$db->rollback();
			return "error";
		}
		$db->liberar($sql1);
		$db->liberar($sql2);
        $db->cerrar();
	}//function mdlEliminarGaleria
	/*=============================================
	CREAR TIPO GALERIA
	=============================================*/
	static public function mdlIngresarTipoGaleria($tabla,$numLinea,$imagen,$usrRegistro,$fchRegistro,$codGaleria){
		$db = new Conexion();
		foreach ($imagen as $key => $value) {
			$sql = $db->consulta("INSERT INTO $tabla(cod_galeria,num_linea,imagen,cod_usr_registro,fch_registro) VALUES('".$codGaleria."',".$numLinea[$key].",'".Utf8Decode($value)."','".$usrRegistro[$key]."',CONVERT(datetime,'".$fchRegistro[$key]."',21))");
		}
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarTipoGaleria
	/*=============================================
	ELIMINAR GALERIA
	=============================================*/
	static public function mdlEliminarTipoGaleria($tabla,$imagen){
		$db = new Conexion();
		//echo "DELETE FROM $tabla WHERE imagen = '".$imagen."'";
		$sql = $db->consulta("DELETE FROM $tabla WHERE imagen = '".$imagen."'");				
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarTipoGaleria
}//class ModeloGaleria