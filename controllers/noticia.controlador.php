<?php
class ControladorNoticia{
	/*=============================================
	MOSTRAR NOTICIAS
	=============================================*/
	static public function ctrMostrarNoticia($item,$valor,$entrada){
		$tabla = "vtama_noticia";
		$respuesta = ModeloNoticia::mdlMostrarNoticia($tabla,$item,$valor,$entrada);
		return $respuesta;
	}//function ctrMostrarNoticia
	/*=============================================
	CREAR NOTICIA
	=============================================*/
	static public function ctrCrearNoticia(){
		if(isset($_POST["accionNoticia"]) && $_POST["accionNoticia"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$fchPublicacion = explode("/", $_POST["fechaPublicacionNoticia"]);
			$tabla = 'vtama_noticia';
			$codNoticia = maximoCodigoTabla($tabla,'cod_noticia','');
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);
			$item = "dsc_titulo";
			$valor = ms_escape_string(trim($_POST["tituloNoticia"]));
			$entrada = "validarNombreRepetido";
			$nombre = ModeloNoticia::mdlMostrarNoticia($tabla,$item,$valor,$entrada);
			if($nombre['contador'] == 0){
				/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				$nombreImagenNoticia = "default-50x50.gif";
				if(isset($_FILES["imagenNoticia"]["tmp_name"]) && $_FILES["imagenNoticia"]["tmp_name"] != ''){
					$nombreImagenNoticia = $codNoticia.'-'.ms_escape_string(trim(Utf8Decode($_FILES["imagenNoticia"]["name"])));
				}//if
				$datos = array("cod_noticia" => $codNoticia,
							   "dsc_titulo" => ms_escape_string(trim($_POST["tituloNoticia"])),
							   "dsc_resumen" => ms_escape_string(trim($_POST["resumenNoticia"])),
							   "fch_publicacion" => $fchPublicacion[2].'-'.$fchPublicacion[1].'-'.$fchPublicacion[0].' '.$hora,
							   "imagen" => $nombreImagenNoticia,
							   "cod_usr_registro" => $_SESSION["cod_trabajador"],
							   "fch_registro" => $fechaActual);
				$respuesta = ModeloNoticia::mdlIngresarNoticia($tabla,$datos);
				if($respuesta == "ok"){
					if(isset($_FILES["imagenNoticia"]["tmp_name"]) && $_FILES["imagenNoticia"]["tmp_name"] != ''){
						$nombreImagenNoticia = $codNoticia.'-'.trim(utf8_decode($_FILES["imagenNoticia"]["name"]));
						$ruta = $rutaGlobal."/archivos/noticia/".$nombreImagenNoticia;
						move_uploaded_file($_FILES["imagenNoticia"]["tmp_name"], $ruta);
					}//if
				}//if
			}else{
				$respuesta = "nombreRepetido";
			}			
			return $respuesta;
		}//if
	}//function ctrCrearNoticia
	/*=============================================
	EDITAR NOTICIA
	=============================================*/
	static public function ctrEditarNoticia(){
		if(isset($_POST["accionNoticia"]) && $_POST["accionNoticia"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;
			$fchPublicacion = explode("/", $_POST["fechaPublicacionNoticia"]);
			$tabla = 'vtama_noticia';
			$codNoticia = $_POST["codigoNoticia"];
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);
			$item1 = "dsc_titulo";
			$valor1 = ms_escape_string(trim($_POST["tituloNoticia"]));
			$entrada1 = "validarNombreRepetido";
			$nombre = ModeloNoticia::mdlMostrarNoticia($tabla,$item1,$valor1,$entrada1);
			$item2 = "cod_noticia";
			$valor2 = $codNoticia;
			$entrada2 = "capturarTituloNoticia";
			$nombre2 = ModeloNoticia::mdlMostrarNoticia($tabla,$item2,$valor2,$entrada2);
			if($nombre['contador'] == 0 || trim($_POST["tituloNoticia"]) == $nombre2["dsc_titulo"]){
				/*=============================================
				VERIFICAR FECHA PUBLICACIÓN
				=============================================*/
				$itemFechaPublicacion = "cod_noticia";
				$valorFechaPublicacion = $codNoticia;
				$entradaFechaPublicacion = "capturarFechaCambiada";
				$resFechaPublicacion = ModeloNoticia::mdlMostrarNoticia($tabla,$itemFechaPublicacion,$valorFechaPublicacion,$entradaFechaPublicacion);
				if(dateFormat($resFechaPublicacion["fch_publicacion"]) == $fchPublicacion[0].'-'.$fchPublicacion[1].'-'.$fchPublicacion[2]){
					$resFinalFchPublicacion = dateTimeFormat2($resFechaPublicacion["fch_publicacion"]);
				}else{
					$resFinalFchPublicacion = $fchPublicacion[2].'-'.$fchPublicacion[1].'-'.$fchPublicacion[0].' '.$hora;
				}
				/*=============================================
				VALIDAR IMAGEN
				=============================================*/
				$nombreImagenNoticia = ms_escape_string(trim(Utf8Decode($_POST["imagenActualNoticia"])));
				if(isset($_FILES["imagenNoticia"]["tmp_name"]) && $_FILES["imagenNoticia"]["tmp_name"] != ''){
					$nombreImagenNoticia = $codNoticia.'-'.ms_escape_string(trim(Utf8Decode($_FILES["imagenNoticia"]["name"])));
				}
				$datos = array("cod_noticia" => $codNoticia,
							   "dsc_titulo" => ms_escape_string(trim($_POST["tituloNoticia"])),
							   "dsc_resumen" => ms_escape_string(trim($_POST["resumenNoticia"])),
							   "fch_publicacion" => $resFinalFchPublicacion,
							   "imagen" => $nombreImagenNoticia,
							   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
							   "fch_modifica" => $fechaActual);
				$respuesta = ModeloNoticia::mdlEditarNoticia($tabla,$datos);
				if($respuesta == "ok"){
					if(isset($_FILES["imagenNoticia"]["tmp_name"]) && $_FILES["imagenNoticia"]["tmp_name"] != ''){
						$nombreImagenNoticia = $codNoticia.'-'.trim(utf8_decode($_FILES["imagenNoticia"]["name"]));
						if($_POST["imagenActualNoticia"] != 'default-50x50.gif'){
							$rutaEliminarNoticia = $rutaGlobal."/archivos/noticia/".trim(utf8_decode($_POST["imagenActualNoticia"]));
							unlink($rutaEliminarNoticia);
						}
						$ruta = $rutaGlobal."/archivos/noticia/".$nombreImagenNoticia;
						move_uploaded_file($_FILES["imagenNoticia"]["tmp_name"], $ruta);
					}//if
				}//if
			}else{
				$respuesta = "nombreRepetido";
			}			
			return $respuesta;
		}//if
	}//function ctrEditarNoticia
	/*=============================================
	ELIMINAR NOTICIA
	=============================================*/
	static public function ctrEliminarNoticia(){
		if(isset($_POST["accionNoticia"]) && $_POST["accionNoticia"] == "eliminar"){			
			$tabla = 'vtama_noticia';
			$codNoticia = $_POST["codigoNoticia"];
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);
			/*=============================================
			VALIDAR IMAGEN
			=============================================*/
			$nombreImagenNoticia = trim(utf8_decode($_POST["imagenNoticia"]));
			if($nombreImagenNoticia != 'default-50x50.gif'){
				$rutaEliminarNoticia = $rutaGlobal."/archivos/noticia/".$nombreImagenNoticia;
				unlink($rutaEliminarNoticia);
			}
			$respuesta = ModeloNoticia::mdlEliminarNoticia($tabla,$codNoticia);
			return $respuesta;
		}//if
	}//function ctrEliminarNoticia
}//class ControladorNoticia