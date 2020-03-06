<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/trabajador.controlador.php";
require_once "../models/trabajador.modelo.php";
class CalendarioCumpleaños{
	/*=============================================
	MOSTRAR TABLAS MAESTRAS
	=============================================*/
	public function mostrarCalendarioCumpleaños(){
		$item1 = "fch_nacimiento";
		if($_POST["start"] > $_POST["end"] && $_POST["start"] == 12){
			$inicio = 1;
			$fin = $_POST["end"];
		}else if($_POST["start"] > $_POST["end"] && $_POST["end"] == 1){
			$inicio = $_POST["start"];
			$fin = 12;
		}else{
			$inicio = $_POST["start"];
			$fin = $_POST["end"];
		}
        $valor1 = $inicio.'|'.$fin;
        $item2 = $valor2 = $item3 = $valor3 = null;
        $entrada = "calendarioCumpleaños";
        $cumpleaños = ControladorTrabajador::ctrMostrarTrabajador($item1,$valor1,$item2,$valor2,$item3,$valor3,$entrada);
        if(count($cumpleaños) > 0){
	        $datosJson = '[';
				 	for ($i=0; $i < count($cumpleaños) ; $i++) {
				 		$fechaNacimiento = dateFormatCumpleanios($cumpleaños[$i]["fch_nacimiento"]);
				 		$datosJson .= '{
							"nombre" : "'.$cumpleaños[$i]["dsc_nombres"]." ".$cumpleaños[$i]["dsc_apellido_paterno"]." ".$cumpleaños[$i]["dsc_apellido_materno"].'",
							"fecha" : "'.$fechaNacimiento.'",
							"imagen" : "'.$cumpleaños[$i]["imagen"].'",
							"cargo" : "'.$cumpleaños[$i]["dsc_cargo"].'"
						},';
					}			 	
					$datosJson = substr($datosJson, 0, -1);
				$datosJson .= ']';	
		}else{
			$datosJson = '[
				{}
			]';
		}
		echo $datosJson;	
	}//function mostrarTablaClientes
}//class TablaClientes
/*=============================================
ACTIVAR TABLA CLIENTE
=============================================*/
$activarCalendarioCumpleaños = new CalendarioCumpleaños();
$activarCalendarioCumpleaños -> mostrarCalendarioCumpleaños();