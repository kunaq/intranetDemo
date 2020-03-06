<?php
if($_GET["reporte"] == "reporteClientes"){
	require_once "../../core.php";
	require_once "../../funciones.php";
	require_once "../../controllers/clientes.controlador.php";
	require_once "../../models/clientes.modelo.php";
	$reporte = new ControladorClientes();
	$reporte -> ctrDescargarReporte();
}else if($_GET["reporte"] == "reporteProductos"){
	require_once "../../core.php";
	require_once "../../funciones.php";
	require_once "../../controllers/productos.controlador.php";
	require_once "../../models/productos.modelo.php";
	$reporte = new ControladorProductos();
	$reporte -> ctrDescargarReporte();
}else if($_GET["reporte"] == "reporteOrdenProduccion" || $_GET["reporte"] == "reporteOrdenProduccionDetalle"){
	require_once "../../core.php";
	require_once "../../funciones.php";
	require_once '../../extensions/PHPExcel/PHPExcel/IOFactory.php';
	require_once "../../controllers/ordenProduccion.controlador.php";
	require_once "../../controllers/area.controlador.php";
	require_once "../../models/ordenProduccion.modelo.php";
	require_once "../../models/area.modelo.php";
	$reporte = new ControladorOrdenProduccion();
	$reporte -> ctrDescargarReporte();
}