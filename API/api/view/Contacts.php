
 <?php
 header("Access-Control-Allow-Origin: *");
 require "../Slim/Slim.php";
 include_once "../controller/ControllerContacts.php";

 \Slim\Slim::registerAutoloader();

 $app = new \Slim\Slim();


 $app->post("/select", function () use ($app) {
  $lstObj = json_decode($app->request()->getBody());
  $controllerContacts = new ControllerContacts();
  echo json_encode($controllerContacts->select($lstObj[0]));
 });



 $app->post("/save", function () use ($app) {

  $lstObj = json_decode($app->request()->getBody());
  $controllerContacts = new ControllerContacts();

  echo json_encode($controllerContacts->save($lstObj));
 });


 $app->post("/delete", function () use ($app) {
  $obj = $app->request()->getBody();
  $lstObj = json_decode($obj);
  $controllerContacts = new ControllerContacts();
  echo json_encode($controllerContacts->delete($lstObj[0]));
 });


 $app->run();




 ?>
 