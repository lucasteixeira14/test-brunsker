
 <?php
header("Content-type: text/html; charset=utf-8");
 require_once "config.php";
 date_default_timezone_set("America/Sao_Paulo");
 class Conexao{
 
 private static $instance;
 
 public static function getInstance(){
 
  if(!isset(self::$instance)){
 
   try {
    self::$instance = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    self::$instance->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	self::$instance->query('SET NAMES utf8');
   } catch (PDOException $e) {
    echo $e->getMessage();
   }
 
  }
 
  return self::$instance;
 }
  
 public static function prepare($sql){
  return self::getInstance()->prepare($sql);
 }
 
 }