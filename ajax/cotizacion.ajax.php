<?php
require_once "../core.php";
require_once "../funciones.php";
require_once "../extensions/PHPMailer/src/PHPMailer.php";
require_once "../extensions/PHPMailer/src/SMTP.php";
require_once "../extensions/PHPMailer/src/Exception.php";
require_once "../controllers/productos.controlador.php";
require_once "../controllers/cotizacion.controlador.php";
require_once "../models/productos.modelo.php";
require_once "../models/cotizacion.modelo.php";
class AjaxCotizacion{
	/*=============================================
	MOSTAR COTIZACION DETALLE
	=============================================*/
	public $codCotizacion;
	public function ajaxMostrarCotizacionDetalle(){
		$item = "cod_cotizacion";
		$valor = $this->codCotizacion;
		$entrada = null;
		$respuesta = ControladorCotizacion::ctrMostrarCotizacionDetalle($item,$valor,$entrada);
		echo json_encode($respuesta);
	}//function ajaxMostrarCotizacionDetalle
	public function ajaxCrearCotizacion(){
		$respuesta = ControladorCotizacion::ctrCrearCotizacion();
		echo $respuesta;
	}//function ajaxCrearCotizacion
	public function ajaxEditarCotizacion(){
		$respuesta = ControladorCotizacion::ctrEditarCotizacion();
		echo $respuesta;
	}//function ctrEditarCotizacion
	public function ajaxClonarCotizacion(){
		$respuesta = ControladorCotizacion::ctrCrearCotizacion();
		echo $respuesta;
	}//function ajaxClonarCotizacion
	public function ajaxEliminarCotizacion(){
		$respuesta = ControladorCotizacion::ctrEliminarCotizacion();
		echo $respuesta;
	}//function ajaxEditarCliente
	public function ajaxEnviarCorreoCotizacion(){
		$respuesta = ControladorCotizacion::ctrEnviarCorreoCotizacion();
		echo $respuesta;
	}//function ajaxEnviarCorreoCotizacion
	public function ajaxMostrarCotizacion(){
		$valor1 = isset($_POST["codCotizacion"]) ?  $this->codCotizacion : null;
		$valor2 = $valor3 = null;
		$valor4 = isset($_POST["fechaInicial"]) ? $_POST["fechaInicial"] : null;
		$valor5 = isset($_POST["fechaFinal"]) ? $_POST["fechaFinal"] : null;
		$entrada = isset($_POST["entrada"]) ? $_POST["entrada"] : null;
		$respuesta = ControladorCotizacion::ctrMostrarCotizacion($valor1,$valor2,$valor3,$valor4,$valor5,$entrada);
		echo json_encode($respuesta);
	}//function ajaxMostrarCotizacion
	public function ajaxMostrarCotizacionDatosAdjuntos(){
		$item = "cod_cotizacion";
		$valor = $this->codCotizacion;
		$respuesta = ControladorCotizacion::ctrMostrarCotizacionDatosAdjuntos($item,$valor);
		echo json_encode($respuesta);
	}//function ajaxMostrarCotizacionDatosAdjuntos
}//class AjaxCotizacion
/*=============================================
MOSTAR COTIZACION DETALLE
=============================================*/
if(isset($_POST["codCotizacion"])){
	$cotizacion = new AjaxCotizacion();
	$cotizacion -> codCotizacion = $_POST["codCotizacion"];
	$cotizacion -> ajaxMostrarCotizacionDetalle();
}
/*=============================================
ENVIO DE CORREO
=============================================*/
if(isset($_POST["receptorCorreoCotizacion"])){
	$cotizacion = new AjaxCotizacion();
	$cotizacion -> ajaxEnviarCorreoCotizacion();
}
/*=============================================
ACCIONES CLIENTE
=============================================*/
if(isset($_POST["accionCotizacion"]) && $_POST["accionCotizacion"] == 'mostrar'){
	$cliente = new AjaxCotizacion();
	$cliente -> ajaxMostrarCotizacion();
}else if(isset($_POST["accionCotizacion"]) && $_POST["accionCotizacion"] == 'crear'){
	$cliente = new AjaxCotizacion();
	$cliente -> ajaxCrearCotizacion();
}else if(isset($_POST["accionCotizacion"]) && $_POST["accionCotizacion"] == 'editar'){
	$cliente = new AjaxCotizacion();
	$cliente -> ajaxEditarCotizacion();
}else if(isset($_POST["accionCotizacion"]) && $_POST["accionCotizacion"] == 'eliminar'){
	$cotizacion = new AjaxCotizacion();
	$cotizacion -> ajaxEliminarCotizacion();
}else if(isset($_POST["accionCotizacion"]) && $_POST["accionCotizacion"] == 'clonar'){
	$cotizacion = new AjaxCotizacion();
	$cotizacion -> ajaxClonarCotizacion();
}else if(isset($_POST["accionCotizacion"]) && $_POST["accionCotizacion"] == 'enviarCorreo'){
	$cotizacion = new AjaxCotizacion();
	$cotizacion -> codCotizacion = $_POST["codigoCotizacion"];
	$cotizacion -> ajaxMostrarCotizacion();
}else if(isset($_POST["accionCotizacion"]) && $_POST["accionCotizacion"] == 'mostrarDatosAdjuntos'){
	$cotizacion = new AjaxCotizacion();
	$cotizacion -> codCotizacion = $_POST["codigoCotizacion"];
	$cotizacion -> ajaxMostrarCotizacionDatosAdjuntos();
}