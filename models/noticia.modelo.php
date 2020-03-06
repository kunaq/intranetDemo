<?php
require_once "conexion.php";
class ModeloNoticia{	
	/*=============================================
	MOSTRAR NOTICIA
	=============================================*/
	static public function mdlMostrarNoticia($tabla,$item,$valor,$entrada){
		$db = new Conexion();
		if($item != null){
			if($entrada == "modalNoticia"){
				$sql = $db->consulta("SELECT vtama_noticia.cod_noticia,vtama_noticia.dsc_titulo,vtama_noticia.dsc_resumen,vtama_noticia.fch_publicacion,vtama_noticia.imagen,rhuma_trabajador.dsc_nombres,rhuma_trabajador.dsc_apellido_paterno,rhuma_trabajador.dsc_apellido_materno FROM vtama_noticia INNER JOIN rhuma_trabajador ON rhuma_trabajador.cod_trabajador = vtama_noticia.cod_usr_registro WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else if($entrada == "detalleNoticia"){
				$sql = $db->consulta("SELECT vtama_noticia.cod_noticia,vtama_noticia.dsc_titulo,vtama_noticia.dsc_resumen,vtama_noticia.fch_publicacion,vtama_noticia.imagen,rhuma_trabajador.dsc_nombres,rhuma_trabajador.dsc_apellido_paterno,rhuma_trabajador.dsc_apellido_materno,rhuma_trabajador.imagen as imagenTrabajador FROM vtama_noticia INNER JOIN rhuma_trabajador ON rhuma_trabajador.cod_trabajador = vtama_noticia.cod_usr_registro WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else if($entrada == "validarNombreRepetido"){
				$sql = $db->consulta("SELECT COUNT(dsc_titulo) as contador FROM $tabla WHERE $item = '$valor'");
				$datos = $db->recorrer($sql);
			}else if($entrada == "capturarTituloNoticia"){
				$sql = $db->consulta("SELECT dsc_titulo FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else if($entrada == "capturarFechaCambiada"){
				$sql = $db->consulta("SELECT fch_publicacion FROM $tabla WHERE $item = '$valor'");
				$datos = $db->recorrer($sql);
			}
		}else{
			if($entrada == "inicioNoticia"){
				$sql = $db->consulta("SELECT TOP(4) cod_noticia,dsc_titulo,dsc_resumen,fch_publicacion,imagen FROM $tabla ORDER BY fch_publicacion DESC");
			}else{
				$sql = $db->consulta("SELECT cod_noticia,dsc_titulo,dsc_resumen,fch_publicacion,imagen FROM $tabla ORDER BY fch_publicacion DESC");
			}
			$datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
	    return $datos;
	}// function mdlMostrarNoticia
	/*=============================================
	CREAR NOTICIA
	=============================================*/
	static public function mdlIngresarNoticia($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("INSERT INTO $tabla(cod_noticia,dsc_titulo,dsc_resumen,fch_publicacion,imagen, cod_usr_registro, fch_registro) VALUES('".$datos['cod_noticia']."','".$datos['dsc_titulo']."','".$datos['dsc_resumen']."',CONVERT(datetime,'".$datos["fch_publicacion"]."',21),'".$datos['imagen']."','".$datos['cod_usr_registro']."',CONVERT(datetime,'".$datos["fch_registro"]."',21))");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarNoticia
	/*=============================================
	EDITAR NOTICIA
	=============================================*/
	static public function mdlEditarNoticia($tabla, $datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_titulo = '".$datos["dsc_titulo"]."',dsc_resumen = '".$datos["dsc_resumen"]."',fch_publicacion = CONVERT(datetime,'".$datos["fch_publicacion"]."',21),imagen = '".$datos["imagen"]."',cod_usr_modifica = '".$datos["cod_usr_modifica"]."',fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21) WHERE cod_noticia = '".$datos["cod_noticia"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarNoticia
	/*=============================================
	ELIMINAR NOTICIA
	=============================================*/
	static public function mdlEliminarNoticia($tabla,$datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_noticia = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarNoticia
}//class ModeloNoticia