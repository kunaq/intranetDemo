<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../controllers/tablaMaestra.controlador.php";
require_once "../models/tablaMaestra.modelo.php";
class AjaxTablaMaestra{
	public $codTablaMaestra;
	public function ajaxMostrarTablaMaestra(){
		$item = "cod_tabla_maestra";
		$valor = $this->codTablaMaestra;
		$respuesta = ControladorTablaMaestra::ctrMostrarTablaMaestra($item,$valor);
		echo json_encode($respuesta);
	}//function ajaxMostrarTablaMaestra
}//class AjaxTablaMaestra
/*=============================================
TRAER EL NOMBRE DE LA BASE DE DATOS DE CADA TABLA
=============================================*/
if(isset($_POST["codTablaMaestra"])){
	$mostrarTablaMaestra = new AjaxTablaMaestra();
	$mostrarTablaMaestra -> codTablaMaestra = $_POST["codTablaMaestra"];
	$mostrarTablaMaestra -> ajaxMostrarTablaMaestra();
}