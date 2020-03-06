<?php
class ControladorPoliticaProcedimiento{
	/*=============================================
	MOSTRAR POLITICA/PROCEDIMIENTO
	=============================================*/
	static public function ctrMostrarPoliticaProcedimiento($item,$valor,$entrada){
		$tabla = "vtaca_politica_procedimiento";
		$respuesta = ModeloPoliticaProcedimiento::mdlMostrarPoliticaProcedimiento($tabla,$item,$valor,$entrada);
		return $respuesta;
	}//function ctrMostrarPoliticaProcedimiento
	/*=============================================
	MOSTRAR POLITICA/PROCEDIMIENTO DETALLE
	=============================================*/
	static public function ctrMostrarPoliticaProcedimientoDetalle($item,$valor,$entrada){
		$tabla = "vtade_politica_procedimiento";
		$respuesta = ModeloPoliticaProcedimiento::mdlMostrarPoliticaProcedimientoDetalle($tabla,$item,$valor,$entrada);
		return $respuesta;
	}//function ctrMostrarPoliticaProcedimientoDetalle
	/*=============================================
	CREAR POLITICA/PROCEDIMIENTO
	=============================================*/
	static public function ctrCrearPoliticaProcedimiento(){
		if(isset($_POST["accionPoliticaProcedimiento"]) && $_POST["accionPoliticaProcedimiento"] == "crear"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;			
			$tabla1 = 'vtaca_politica_procedimiento';
			$tabla2 = 'vtade_politica_procedimiento';
			$codPoliticaProcedimiento = maximoCodigoTabla($tabla1,'cod_politica','');
			$datos = array("cod_politica" => $codPoliticaProcedimiento,
						   "dsc_politica" => ms_escape_string(trim($_POST["nombrePoliticaProcedimiento"])),
						   "cod_usr_registro" => $_SESSION["cod_trabajador"],
						   "fch_registro" => $fechaActual);
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);
			$arrayArchivo = [];
			$arrayNombreArchivo = [];
			$numLineaArchivo = [];
			$arrayUsrRegistro = [];
			$arrayFchRegistro = [];
			$item = "dsc_politica";
			$valor = ms_escape_string(trim($_POST["nombrePoliticaProcedimiento"]));
			$entrada = "validarNombreRepetido";
			$nombre = ModeloPoliticaProcedimiento::mdlMostrarPoliticaProcedimiento($tabla1,$item,$valor,$entrada);
			if($nombre['contador'] == 0){
				if($_FILES["archivoPoliticaProcedimiento"]["tmp_name"][0] != ''){
					for ($i=0; $i < count($_FILES["archivoPoliticaProcedimiento"]["tmp_name"]) ; $i++) {
						$fileArchivo = $_FILES["archivoPoliticaProcedimiento"];
						$nombreRutaArchivo = $codPoliticaProcedimiento."-".($i+1)."-".ms_escape_string(trim($fileArchivo["name"][$i]));
						array_push($arrayArchivo,$nombreRutaArchivo);
						array_push($arrayNombreArchivo,ms_escape_string(trim($fileArchivo["name"][$i])));
						array_push($numLineaArchivo, $i+1);
						array_push($arrayUsrRegistro,$_SESSION["cod_trabajador"]);
						array_push($arrayFchRegistro,$fechaActual);
					}//for				
				}//if
				$respuesta = ModeloPoliticaProcedimiento::mdlIngresarPoliticaProcedimiento($tabla1,$tabla2,$datos,$numLineaArchivo,$arrayArchivo,$arrayNombreArchivo,$arrayUsrRegistro,$arrayFchRegistro,$codPoliticaProcedimiento);
				if($respuesta == "ok"){
					if($_FILES["archivoPoliticaProcedimiento"]["tmp_name"][0] != ''){
						for ($i=0; $i < count($_FILES["archivoPoliticaProcedimiento"]["tmp_name"]) ; $i++) {
							$nombreRutaArchivo = $codPoliticaProcedimiento."-".($i+1)."-".trim(utf8_decode($fileArchivo["name"][$i]));
							$ruta = $rutaGlobal."/archivos/politica-procedimiento/".$nombreRutaArchivo;
							move_uploaded_file($fileArchivo["tmp_name"][$i], $ruta);
						}
					}
				}
			}else{
				$respuesta = "nombreRepetido";
			}
			return $respuesta;
		}//if
	}//function ctrCrearPoliticaProcedimiento
	/*=============================================
	EDITAR POLITICA/PROCEDIMIENTO
	=============================================*/
	static public function ctrEditarPoliticaProcedimiento(){
		if(isset($_POST["accionPoliticaProcedimiento"]) && $_POST["accionPoliticaProcedimiento"] == "editar"){
			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$fechaActual = $fecha.' '.$hora;			
			$tabla1 = 'vtaca_politica_procedimiento';
			$tabla2 = "vtade_politica_procedimiento";
			$codPoliticaProcedimiento = $_POST["codigoPoliticaProcedimiento"];
			$datos = array("cod_politica" => $codPoliticaProcedimiento,
						   "dsc_politica" => ms_escape_string(trim($_POST["nombrePoliticaProcedimiento"])),
						   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
						   "fch_modifica" => $fechaActual);
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);
			$arrayArchivo = [];
			$arrayNombreArchivo = [];
			$numLineaArchivo = [];
			$arrayUsrRegistro = [];
			$arrayFchRegistro = [];
			$item = "dsc_politica";
			$valor = ms_escape_string(trim($_POST["nombrePoliticaProcedimiento"]));
			$entrada = "validarNombreRepetido";
			$nombre = ModeloPoliticaProcedimiento::mdlMostrarPoliticaProcedimiento($tabla1,$item,$valor,$entrada);
			$item2 = "cod_politica";
			$valor2 = $codPoliticaProcedimiento;
			$entrada2 = "capturarNombrePolitica";
			$nombre2 = ModeloPoliticaProcedimiento::mdlMostrarPoliticaProcedimiento($tabla1,$item2,$valor2,$entrada2);
			if($nombre['contador'] == 0 || trim($_POST["nombrePoliticaProcedimiento"]) == $nombre2["dsc_politica"]){
				if($_FILES["archivoPoliticaProcedimiento"]["tmp_name"][0] != ''){				
					$item = "cod_politica";
					$valor = $codPoliticaProcedimiento;
					$entrada = "maximoNumLineaXPoliticaProcedimiento";
					$maximoNumLineaPoliticaProcedimiento = ModeloPoliticaProcedimiento::mdlMostrarPoliticaProcedimientoDetalle($tabla2,$item,$valor,$entrada);
					for ($i=0; $i < count($_FILES["archivoPoliticaProcedimiento"]["tmp_name"]) ; $i++) {
						$fileArchivo = $_FILES["archivoPoliticaProcedimiento"];
						$nombreRutaArchivo = $codPoliticaProcedimiento."-".($i+1+(int)$maximoNumLineaPoliticaProcedimiento["maximo"])."-".ms_escape_string(trim($fileArchivo["name"][$i]));
						array_push($arrayArchivo,$nombreRutaArchivo);
						array_push($arrayNombreArchivo,ms_escape_string(trim($fileArchivo["name"][$i])));
						array_push($numLineaArchivo, $i+1+(int)$maximoNumLineaPoliticaProcedimiento["maximo"]);
						array_push($arrayUsrRegistro,$_SESSION["cod_trabajador"]);
						array_push($arrayFchRegistro,$fechaActual);
					}//for	
				}
				$respuesta = ModeloPoliticaProcedimiento::mdlEditarPoliticaProcedimiento($tabla1,$tabla2,$datos,$numLineaArchivo,$arrayArchivo,$arrayNombreArchivo,$arrayUsrRegistro,$arrayFchRegistro,$codPoliticaProcedimiento);
				if($respuesta == "ok"){
					if($_FILES["archivoPoliticaProcedimiento"]["tmp_name"][0] != ''){
						for ($i=0; $i < count($_FILES["archivoPoliticaProcedimiento"]["tmp_name"]) ; $i++) {
							$nombreRutaArchivo = $codPoliticaProcedimiento."-".($i+1+(int)$maximoNumLineaPoliticaProcedimiento["maximo"])."-".trim(utf8_decode($fileArchivo["name"][$i]));
							$ruta = $rutaGlobal."/archivos/politica-procedimiento/".$nombreRutaArchivo;
							move_uploaded_file($fileArchivo["tmp_name"][$i], $ruta);
						}
					}
				}
			}else{
				$respuesta = "nombreRepetido";
			}
			return $respuesta;
		}//if
	}//function ctrEditarPoliticaProcedimiento
	/*=============================================
	ELIMINAR POLITICA/PROCEDIMIENTO
	=============================================*/
	static public function ctrEliminarPoliticaProcedimiento(){
		if(isset($_POST["accionPoliticaProcedimiento"]) && $_POST["accionPoliticaProcedimiento"] == "eliminar"){			
			$tabla1 = "vtaca_politica_procedimiento";
			$tabla2 = "vtade_politica_procedimiento";
			$codigo = $_POST["codigoPoliticaProcedimiento"];			
			//OBTENER ARCHIVOS
			$item = "cod_politica";
			$valor = $codigo;
			$entrada = "archivosPoliticaProcedimiento";
			$archivos = ModeloPoliticaProcedimiento::mdlMostrarPoliticaProcedimientoDetalle($tabla2,$item,$valor,$entrada);
			//ELIMINAR POLITICA/PROCEDIMIENTO
			$respuesta = ModeloPoliticaProcedimiento::mdlEliminarPoliticaProcedimiento($tabla1,$tabla2,$codigo);
			if($respuesta == "ok"){
				$rutaGlobal = realpath(dirname(__FILE__));
				$rutaGlobal = rutaGlobal($rutaGlobal);
				foreach ($archivos as $key => $value) {
					$rutaEliminarArchivo = $rutaGlobal."/archivos/politica-procedimiento/".trim(utf8_decode($value["dsc_ruta_archivo"]));
					unlink($rutaEliminarArchivo);
				}
			}//if
			return $respuesta;
		}//if
	}//function ctrEliminarPoliticaProcedimiento
	/*=============================================
	ELIMINAR POLITICA/PROCEDIMIENTO DETALLE
	=============================================*/
	static public function ctrEliminarPoliticaProcedimientoDetalle(){
		if(isset($_POST["accionPoliticaProcedimientoDetalle"]) && ($_POST["accionPoliticaProcedimientoDetalle"] == "eliminar")){
			$tabla = 'vtade_politica_procedimiento';
			$codigo = $_POST["codigoPoliticaProcedimiento"];
			$numLinea = $_POST["numLineaPoliticaProcedimiento"];
			$archivo = $_POST["archivoPoliticaProcedimiento"];
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);
			$respuesta = ModeloPoliticaProcedimiento::mdlEliminarPoliticaProcedimientoDetalle($tabla,$codigo,$numLinea);
			if($respuesta == "ok"){
				$rutaEliminarArchivo = $rutaGlobal."/archivos/politica-procedimiento/".trim(utf8_decode($archivo));
				unlink($rutaEliminarArchivo);
			}
			return $respuesta;
		}//if
	}//function ctrEliminarPoliticaProcedimientoDetalle
}//class ControladorPoliticaProcedimiento