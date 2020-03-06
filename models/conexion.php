<?php
class Conexion{
  private $link;
  public function __construct(){
    $connection = array("Database"=>DB_NAME,"UID"=>DB_USER,"PWD"=>DB_PASS,'CharacterSet' => 'UTF-8');
    $this->link = sqlsrv_connect(DB_HOST,$connection);
    if (!$this->link) {
        echo "Error: No se pudo conectar a Sql." . PHP_EOL;
        echo "error de depuración: " . sqlsrv_errors() . PHP_EOL;
        exit;
    }
  }//function  __construct
  public function consulta($query){
    return sqlsrv_query($this->link,$query);
  }
  public function recorrer($query){
    return sqlsrv_fetch_array($query,SQLSRV_FETCH_ASSOC);
  }
  public function liberar($query){
    return sqlsrv_free_stmt($query);
  }
  public function cerrar(){
    return sqlsrv_close($this->link);
  }
  public function inicioTransaccion(){
    return sqlsrv_begin_transaction($this->link);
  }
  public function beginTransaction(){
    return sqlsrv_begin_transaction($this->link);
  }
  public function commit(){
    return sqlsrv_commit($this->link);
  }
  public function rollback(){
    return sqlsrv_rollback($this->link);
  }
}//class Conexion