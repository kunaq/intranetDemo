<?php
class ControladorConsultaFrecuente{
	/*=============================================
	MOSTRAR CONSULTA FRECUENTE
	=============================================*/
	static public function ctrMostrarConsultaFrecuente($item,$valor,$entrada){
		$tabla = "vtama_consulta_frecuente";
		$respuesta = ModeloConsultaFrecuente::mdlMostrarConsultaFrecuente($tabla,$item,$valor,$entrada);
		return $respuesta;
	}//function ctrMostrarConsultaFrecuente
	/*=============================================
	CREAR CONSULTA FRECUENTE
	=============================================*/
	static public function ctrCrearConsultaFrecuente(){
		if(isset($_POST["accionConsultaFrecuente"]) && $_POST["accionConsultaFrecuente"] == "crear"){
			$fecha = date("Y-m-d");
			$hora = date("H:i:s");
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_consulta_frecuente';
			$codConsultaFrecuente = maximoCodigoTabla($tabla,'cod_consulta','');
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);
			$nombreImagen = '';
			$item = "dsc_consulta";
			$valor = ms_escape_string(trim($_POST["nombreConsultaFrecuente"]));
			$entrada = "validarNombreRepetido";
			$nombre = ModeloConsultaFrecuente::mdlMostrarConsultaFrecuente($tabla,$item,$valor,$entrada);
			if($nombre['contador'] == 0){			
				if($_FILES["archivoConsultaFrecuente"]["tmp_name"] != ''){
					$fileImagen = $_FILES["archivoConsultaFrecuente"];
					$nombreImagen = $codConsultaFrecuente."-".$fileImagen["name"];
				}
				$datos = array("cod_consulta" => $codConsultaFrecuente,
							   "dsc_consulta" => ms_escape_string(trim($_POST["nombreConsultaFrecuente"])),
							   "dsc_respuesta" => ms_escape_string(trim($_POST["respuestaConsultaFrecuente"])),
							   "dsc_ruta_archivo" => ms_escape_string(trim($nombreImagen)),
							   "cod_usr_registro" => $_SESSION["cod_trabajador"],
							   "fch_registro" => $fechaActual
							);
				$respuesta = ModeloConsultaFrecuente::mdlCrearConsultaFrecuente($tabla,$datos);
				if($respuesta == "ok"){
					if($_FILES["archivoConsultaFrecuente"]["tmp_name"] != ''){
						$ruta = $rutaGlobal."/archivos/consulta-frecuente/".trim(utf8_decode($nombreImagen));
						move_uploaded_file($fileImagen["tmp_name"], $ruta);
					}//if
				}//if
			}else{
				$respuesta = "nombreRepetido";
			}//else
			return $respuesta;
		}//if
	}//function ctrCrearConsultaFrecuente
	/*=============================================
	EDITAR CONSULTA FRECUENTE
	=============================================*/
	static public function ctrEditarConsultaFrecuente(){
		if(isset($_POST["accionConsultaFrecuente"]) && $_POST["accionConsultaFrecuente"] == "editar"){
			$fecha = date("Y-m-d");
			$hora = date("H:i:s");
			$fechaActual = $fecha.' '.$hora;
			$tabla = 'vtama_consulta_frecuente';
			$codConsultaFrecuente = $_POST["codigoConsultaFrecuente"];
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);
			$nombreImagen = '';
			$item = "dsc_consulta";
			$valor = ms_escape_string(trim($_POST["nombreConsultaFrecuente"]));
			$entrada = "validarNombreRepetido";
			$nombre = ModeloConsultaFrecuente::mdlMostrarConsultaFrecuente($tabla,$item,$valor,$entrada);
			$item2 = "cod_consulta";
			$valor2 = $codConsultaFrecuente;
			$entrada2 = "capturarTituloConsulta";
			$nombre2 = ModeloConsultaFrecuente::mdlMostrarConsultaFrecuente($tabla,$item2,$valor2,$entrada2);
			if($nombre['contador'] == 0 || trim($_POST["nombreConsultaFrecuente"]) == $nombre2["dsc_consulta"]){
				if($_FILES["archivoConsultaFrecuente"]["tmp_name"] != ''){
					$fileImagen = $_FILES["archivoConsultaFrecuente"];
					$nombreImagen = $codConsultaFrecuente."-".$fileImagen["name"];
				}
				$datos = array("cod_consulta" => $codConsultaFrecuente,
							   "dsc_consulta" => ms_escape_string(trim($_POST["nombreConsultaFrecuente"])),
							   "dsc_respuesta" => ms_escape_string(trim($_POST["respuestaConsultaFrecuente"])),
							   "dsc_ruta_archivo" => ms_escape_string(trim($nombreImagen)),
							   "cod_usr_modifica" => $_SESSION["cod_trabajador"],
							   "fch_modifica" => $fechaActual
							);
				$respuesta = ModeloConsultaFrecuente::mdlEditarConsultaFrecuente($tabla,$datos);
				if($respuesta == "ok"){
					if($_POST["archivoOriginalConsultaFrecuente"] != ''){
						$rutaEliminar = $rutaGlobal."/archivos/consulta-frecuente/".trim(utf8_decode($_POST["archivoOriginalConsultaFrecuente"]));
						unlink($rutaEliminar);
					}
					if($_FILES["archivoConsultaFrecuente"]["tmp_name"] != ''){
						$ruta = $rutaGlobal."/archivos/consulta-frecuente/".trim(utf8_decode($nombreImagen));
						move_uploaded_file($fileImagen["tmp_name"], $ruta);
					}				
				}
			}else{
				$respuesta = "nombreRepetido";
			}
			return $respuesta;
		}//if
	}//function ctrEditarConsultaFrecuente
	/*=============================================
	ELIMINAR CONSULTA FRECUENTE
	=============================================*/
	static public function ctrEliminarConsultaFrecuente(){
		if(isset($_POST["accionConsultaFrecuente"]) && $_POST["accionConsultaFrecuente"] == "eliminar"){
			$tabla = 'vtama_consulta_frecuente';
			$codConsultaFrecuente = $_POST["codigoConsultaFrecuente"];
			$rutaGlobal = realpath(dirname(__FILE__));
			$rutaGlobal = rutaGlobal($rutaGlobal);						
			$respuesta = ModeloConsultaFrecuente::mdlEliminarConsultaFrecuente($tabla,$codConsultaFrecuente);
			if($respuesta == "ok"){
				if($_POST["imagenConsultaFrecuente"] != ''){
					$rutaEliminar = $rutaGlobal."/archivos/consulta-frecuente/".trim(utf8_decode($_POST["imagenConsultaFrecuente"]));
					unlink($rutaEliminar);
				}
			}
			return $respuesta;
		}//if
	}//function ctrEliminarNoticia
}//ControladorConsultaFrecuente