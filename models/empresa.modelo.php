<?php
require_once "conexion.php";
class ModeloEmpresa{
	/*=============================================
	MOSTRAR EMPRESA
	=============================================*/
	static public function mdlMostrarEmpresa($tabla,$entrada){
		$db = new Conexion();
		if($entrada == "footer"){
			$sql = $db->consulta("SELECT TOP(1) scfma_empresa.dsc_razon_social,vtama_pais.dsc_pais,vtama_distrito.dsc_distrito,vtama_provincia.dsc_provincia,vtama_departamento.dsc_departamento,scfma_empresa.dsc_direccion FROM scfma_empresa INNER JOIN vtama_pais ON vtama_pais.cod_pais = scfma_empresa.cod_pais LEFT JOIN vtama_departamento ON vtama_departamento.cod_departamento = scfma_empresa.cod_departamento LEFT JOIN vtama_provincia ON vtama_provincia.cod_provincia = scfma_empresa.cod_provincia LEFT JOIN vtama_distrito ON vtama_distrito.cod_distrito = scfma_empresa.cod_distrito");	
		}else if($entrada == "nosotros"){
			$sql = $db->consulta("SELECT TOP(1) dsc_historia,dsc_vision,dsc_mision FROM $tabla");
		}
		$datos = arrayMapUtf8Encode($db->recorrer($sql));
	    return $datos;
	}//function mdlMostrarEmpresa
	/*=============================================
	EDITAR HISTORIA
	=============================================*/
	static public function mdlActualizarEmpresa($tabla,$item,$valor){
		$db = new Conexion();
		$sql = $db->consulta("UPDATE $tabla SET $item = '".Utf8Decode($valor)."'");		
		if($sql){
			return "ok";
		}else{
			return "error";
		}
		$db->liberar($sql);
        $db->cerrar();
	}//function mdlActualizarEmpresa
}//class ModeloEmpresa