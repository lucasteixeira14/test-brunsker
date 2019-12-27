
 <?php
 header("Access-Control-Allow-Origin: *");
 require "../Slim/Slim.php";
 include_once "../controller/ControllerAdresses.php";

 \Slim\Slim::registerAutoloader();

 $app = new \Slim\Slim();


 $app->post("/select", function () use ($app) {
  $lstObj = json_decode($app->request()->getBody());
  $controllerAdresses = new ControllerAdresses();
  echo json_encode($controllerAdresses->select($lstObj[0]));
 });



 $app->post("/save", function () use ($app) {

  $lstObj = json_decode($app->request()->getBody());
  $controllerAdresses = new ControllerAdresses();

  echo json_encode($controllerAdresses->save($lstObj));
 });


 $app->post("/delete", function () use ($app) {
  $obj = $app->request()->getBody();
  $lstObj = json_decode($obj);
  $controllerAdresses = new ControllerAdresses();
  echo json_encode($controllerAdresses->delete($lstObj[0]));
 });


 $app->run();




 ?>
 