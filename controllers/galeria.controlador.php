<?php
class ControladorGaleria{
	/*=============================================
	MOSTRAR GALERIA
	=============================================*/
	static public function ctrMostrarGaleria($item,$valor,$entrada){
		$tabla = "vtaca_galeria";
		$respuesta = ModeloGaleria::mdlMostrarGaleria($tabla,$item,$valor,$entrada);
		return $respuesta;
	}//function ctrMostrarGaleria
	/*=============================================
	MOSTRAR GALERIA DETALLE
	=============================================*/
	static public function ctrMostrarGaleriaDetalle($item,$valor,$entrada){
		$tabla = "vtade_galeria";
		$respuesta = ModeloGaleria::mdlMostrarGaleriaDetalle($tabla,$item,$valor,$entrada);
		return $respuesta;
	}//function ctrMostrarGaleriaDetalle
	/*=============================================
	CREAR GALERIA
	=============================================*/
	static public function ctrCrearGaleria(){
		if(isset($_POST["accionGaleria"]) && $_POST["accionGaleria"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;			
			$tabla = 'vtaca_galeria';
			$codGaleria = maximoCodigoTabla($tabla,'cod_galeria','');
			$item = "dsc_galeria";
			$valor = ms_escape_string(trim($_POST["nombreGaleria"]));
			$entrada = "validarNombreRepetido";
			$nombre = ModeloGaleria::mdlMostrarGaleria($tabla,$item,$valor,$entrada);
			if($nombre['contador'] == 0){
				$datos = array("cod_galeria" => $codGaleria,
						   	   "dsc_galeria" => ms_escape_string(trim($_POST["nombreGaleria"])),
						       "cod_usr_registro" => $_SESSION["cod_trabajador"],
						       "fch_registro" => $fechaActual
						);
				$respuesta = ModeloGaleria::mdlIngresarGaleria($tabla,$datos);
			}else{
				$respuesta = "nombreRepetido";
			}
			return $respuesta;
		}//if
	}//function ctrCrearGaleria
	/*=============================================
	EDITAR GALERIA
	=============================================*/
	static public function ctrEditarGaleria(){
		if(isset($_POST["accionGaleria"]) && $_POST["accionGaleria"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;			
			$tabla = 'vtaca_galeria';
			$item1 = "dsc_galeria";
			$valor1 = ms_escape_string(trim($_POST["nombreGaleria"]));
			$entrada1 = "validarNombreRepetido";
			$nombre = ModeloGaleria::mdlMostrarGaleria($tabla,$item1,$valor1,$entrada1);
			$item2 = "cod_galeria";
			$valor2 = $_POST["codigoGaleria"];
			$entrada2 = "capturarNombreGaleria";
			$nombre2 = ModeloGaleria::mdlMostrarGaleria($tabla,$item2,$valor2,$entrada2);
			if($nombre['contador'] == 0 || trim($_POST["nombreGaleria"]) == $nombre2["dsc_galeria"]){
				$datos = array("cod_galeria" => $_POST["codigoGaleria"],
						   "dsc_galeria" => ms_escape_string(trim($_POST["nombreGaleria"])),
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual
						);
				$respuesta = ModeloGaleria::mdlEditarGaleria($tabla,$datos);
			}else{
				$respuesta = "nombreRepetido";
			}
			return $respuesta;
		}//if
	}//function ctrEditarGaleria
	/*=============================================
	ELIMINAR GALERIA
	=============================================*/
	static public function ctrEliminarGaleria(){
		if(isset($_POST["accionGaleria"]) && $_POST["accionGaleria"] == "eliminar"){			
			$tabla1 = "vtaca_galeria";
			$tabla2 = "vtade_galeria";
			$codigo = $_POST["codigoGaleria"];			
			//OBTENER IMAGENES
			$item = "cod_galeria";
			$entrada = "imagenTipoGaleria";
			$imagenes = ModeloGaleria::mdlMostrarGaleriaDetalle($tabla2,$item,$codigo,$entrada);
			//ELIMINAR GALERIA
			$respuesta = ModeloGaleria::mdlEliminarGaleria($tabla1,$tabla2,$codigo);			
			if($respuesta == "ok"){
				$rutaGlobal = realpath(dirname(__FILE__));
				$rutaGlobal = rutaGlobal($rutaGlobal);
				foreach ($imagenes as $key => $value) {
					$rutaEliminarImagen = $rutaGlobal."/archivos/galeria/".utf8_decode($value["imagen"]);
					unlink($rutaEliminarImagen);
				}
			}
			return $respuesta;
		}//if
	}//function ctrEliminarGaleria
	/*=============================================
	CREAR TIPO GALERIA
	=============================================*/
	static public function ctrCrearTipoGaleria(){
		if(isset($_POST["accionTipoGaleria"]) && $_POST["accionTipoGaleria"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;			
			$tabla = 'vtade_galeria';
			$codGaleria = $_POST["codigoGaleria"];
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);
			$arrayImagen = [];
			$numLineaImagen = [];
			$arrayUsrRegistro = [];
			$arrayFchRegistro = [];
			if($_FILES["imagenTipoGaleria"]["tmp_name"][0] != ''){
				$item = "cod_galeria";
				$valor = $codGaleria;
				$entrada = "maximoNumLineaXGaleria";
				$maxNumLinea = ControladorGaleria::ctrMostrarGaleriaDetalle($item,$valor,$entrada);
				for ($i=0; $i < count($_FILES["imagenTipoGaleria"]["tmp_name"]) ; $i++) {
					$fileImagen = $_FILES["imagenTipoGaleria"];
					$nombreImagen = $codGaleria."-".($i+1+(int)$maxNumLinea["maximo"])."-".ms_escape_string(trim($fileImagen["name"][$i]));
					array_push($arrayImagen,$nombreImagen);
					array_push($numLineaImagen, $i+1+(int)$maxNumLinea["maximo"]);
					array_push($arrayUsrRegistro,$_SESSION["cod_trabajador"]);
					array_push($arrayFchRegistro,$fechaActual);
				}//for
				$respuesta = ModeloGaleria::mdlIngresarTipoGaleria($tabla,$numLineaImagen,$arrayImagen,$arrayUsrRegistro,$arrayFchRegistro,$codGaleria);
				if($respuesta == "ok"){
					for ($i=0; $i < count($_FILES["imagenTipoGaleria"]["tmp_name"]) ; $i++) {
						$nombreImagen = $codGaleria."-".($i+1+(int)$maxNumLinea["maximo"])."-".trim(utf8_decode($fileImagen["name"][$i]));
						$ruta = $rutaGlobal."/archivos/galeria/".$nombreImagen;
						move_uploaded_file($fileImagen["tmp_name"][$i], $ruta);
					}//for
				}
				return $respuesta;
			}//if			
		}//if
	}//function ctrCrearTipoGaleria
	static public function ctrEliminarTipoGaleria(){
		if(isset($_POST["accionTipoGaleria"]) && ($_POST["accionTipoGaleria"] == "eliminar")){
			$tabla = 'vtade_galeria';
			$imagen = ms_escape_string(arrayMapUtf8Decode($_POST["imagen"]));
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);
			$respuesta = ModeloGaleria::mdlEliminarTipoGaleria($tabla,$imagen);
			if($respuesta == "ok"){
				$rutaEliminarImagen = $rutaGlobal."/archivos/galeria/".utf8_decode($_POST["imagen"]);
				unlink($rutaEliminarImagen);
			}//if
			return $respuesta;
		}//if
	}//function ctrEliminarTipoGaleria
}//class ControladorGaleria