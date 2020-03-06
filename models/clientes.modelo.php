<?php
require_once "conexion.php";
class ModeloClientes{
	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/
	static public function mdlMostrarClientes($tabla,$item,$valor,$entrada){
		$db = new Conexion();
		if($item != null){
			if($entrada == "creaCotizacion"){
				$sql = $db->consulta("SELECT vtama_cliente.dsc_documento,vtama_cliente.dsc_direccion,vtama_distrito.dsc_distrito,vtama_provincia.dsc_provincia, vtama_departamento.dsc_departamento, vtama_pais.dsc_pais,vtama_cliente.cod_forma_pago,vtama_pais.flg_peru FROM vtama_cliente INNER JOIN vtama_pais ON vtama_pais.cod_pais = vtama_cliente.cod_pais LEFT JOIN vtama_departamento ON vtama_departamento.cod_departamento = vtama_cliente.cod_departamento LEFT JOIN vtama_provincia ON vtama_provincia.cod_provincia = vtama_cliente.cod_provincia LEFT JOIN vtama_distrito ON vtama_distrito.cod_distrito = vtama_cliente.cod_distrito WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else if($entrada == "validarDocumentoRepetido"){
				$sql = $db->consulta("SELECT COUNT(dsc_documento) as contador FROM $tabla WHERE $item = '$valor'");
				$datos = $db->recorrer($sql);
			}else if($entrada == "capturarDocumentoCliente"){
				$sql = $db->consulta("SELECT dsc_documento FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}else{
				$sql = $db->consulta("SELECT * FROM $tabla WHERE $item = '$valor'");
				$datos = arrayMapUtf8Encode($db->recorrer($sql));
			}
		}else{
			if($entrada == 'filtroCotizacion'){
				$sql = $db->consulta("SELECT dsc_razon_social FROM $tabla");
			}else{
				$sql = $db->consulta("SELECT vtama_cliente.dsc_documento,vtama_cliente.dsc_razon_social,vtama_categoria_cliente.dsc_categoria_cliente,vtama_pais.dsc_pais,vtama_departamento.dsc_departamento,vtama_provincia.dsc_provincia,vtama_distrito.dsc_distrito,vtama_cliente.cod_cliente,vtama_cliente.dsc_direccion FROM $tabla INNER JOIN vtama_categoria_cliente ON vtama_categoria_cliente.cod_categoria_cliente = vtama_cliente.cod_categoria_cliente LEFT JOIN vtama_pais ON vtama_pais.cod_pais = vtama_cliente.cod_pais LEFT JOIN vtama_departamento ON vtama_departamento.cod_departamento = vtama_cliente.cod_departamento LEFT JOIN vtama_provincia ON vtama_provincia.cod_provincia = vtama_cliente.cod_provincia LEFT JOIN vtama_distrito ON vtama_distrito.cod_distrito = vtama_cliente.cod_distrito ORDER BY $tabla.dsc_razon_social ASC");
			}
		    $datos = array();
		    while($key = $db->recorrer($sql)){
		    	$datos[] = arrayMapUtf8Encode($key);
		    }
		}
		$db->liberar($sql);
        $db->cerrar();
		return $datos;
	}//function mdlMostrarClientes
	/*=============================================
	CREAR CLIENTE
	=============================================*/
	static public function mdlIngresarCliente($tabla,$datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("INSERT INTO $tabla(cod_cliente, dsc_razon_social, cod_tipo_documento, dsc_documento, cod_categoria_cliente, cod_pais, cod_departamento, cod_provincia, cod_distrito, dsc_direccion, cod_usr_registro, fch_registro, cod_forma_pago) VALUES ('".$datos["cod_cliente"]."','".$datos["dsc_razon_social"]."','".$datos["cod_tipo_documento"]."','".$datos["dsc_documento"]."','".$datos["cod_categoria_cliente"]."','".$datos["cod_pais"]."','".$datos["cod_departamento"]."','".$datos["cod_provincia"]."','".$datos["cod_distrito"]."','".$datos["dsc_direccion"]."','".$datos["cod_usr_registro"]."',CONVERT(datetime,'".$datos["fch_registro"]."',21),'".$datos["cod_forma_pago"]."')");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlIngresarCliente	
	/*=============================================
	EDITAR CLIENTE
	=============================================*/
	static public function mdlEditarCliente($tabla,$datos){
		$datos =  arrayMapUtf8Decode($datos);
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET dsc_razon_social = '".$datos["dsc_razon_social"]."', dsc_documento = '".$datos["dsc_documento"]."', cod_categoria_cliente = '".$datos["cod_categoria_cliente"]."', cod_pais = '".$datos["cod_pais"]."', cod_departamento = '".$datos["cod_departamento"]."', cod_provincia = '".$datos["cod_provincia"]."', dsc_direccion = '".$datos["dsc_direccion"]."', cod_distrito = '".$datos["cod_distrito"]."', cod_usr_modifica = '".$datos["cod_usr_modifica"]."', fch_modifica = CONVERT(datetime,'".$datos["fch_modifica"]."',21), cod_forma_pago = '".$datos["cod_forma_pago"]."' WHERE cod_cliente = '".$datos["cod_cliente"]."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEditarCliente
	/*=============================================
	ELIMINAR CLIENTE
	=============================================*/
	static public function mdlEliminarCliente($tabla,$datos){
		$db = new Conexion();
		$sql = $db->consulta("DELETE FROM $tabla WHERE cod_cliente = '".$datos."'");
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlEliminarCliente
}//class ModeloClientes