
 <?php
 header("Access-Control-Allow-Origin: *");
 require "../Slim/Slim.php";
 include_once "../controller/ControllerCustomers.php";

 \Slim\Slim::registerAutoloader();

 $app = new \Slim\Slim();

 $app->post("/selectAll", function () use ($app) {
  $controllerCustomers = new ControllerCustomers();
  echo json_encode($controllerCustomers->selectAll());
 });
 $app->post("/select", function () use ($app) {
  $lstObj = json_decode($app->request()->getBody());
  $controllerCustomers = new ControllerCustomers();
  echo json_encode($controllerCustomers->select($lstObj[0]));
 });
 $app->post("/login", function () use ($app) {
  $lstObj = json_decode($app->request()->getBody());
  $controllerCustomers = new ControllerCustomers();
  echo json_encode($controllerCustomers->login($lstObj[0],$lstObj[1]));
 });
 $app->post("/insert", function () use ($app) {

  $lstObj = json_decode($app->request()->getBody());
  $controllerCustomers = new ControllerCustomers();

  echo json_encode($controllerCustomers->insert($lstObj));
 });

 $app->post("/update", function () use ($app) {

  $lstObj = json_decode($app->request()->getBody());
  $controllerCustomers = new ControllerCustomers();

  echo json_encode($controllerCustomers->update($lstObj));
 });

 $app->post("/delete", function () use ($app) {
  $obj = $app->request()->getBody();
  $lstObj = json_decode($obj);
  $controllerCustomers = new ControllerCustomers();
  echo json_encode($controllerCustomers->delete($lstObj[0]));
 });


 $app->run();




 ?>
 