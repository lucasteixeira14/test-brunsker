<?php
include_once '../conn/conn.php';

class ControllerCustomers
{

 public function selectAll()
 {
  $sql =  "SELECT customers.idCustomer, SUBSTRING_INDEX(customers.name, ' ', 2) as name, customers.cpf, customers.rg, contacts.number, 
                   contacts.email FROM customers 
				   inner join contacts on (contacts.idCustomer = customers.idCustomer AND 
				                           contacts.type = 'COMERCIAL')  GROUP by idCustomer";
  $consulta = Conexao::prepare($sql);
  $consulta->execute();
  return $consulta->fetchAll();
 }

public function login($user, $password){
  $sql =  "select * FROM customers  where user= :user and password = :password ";
  $consulta = Conexao::prepare($sql);
  $consulta->bindValue("user",  $user);
  $consulta->bindValue("password",  $password);
  $consulta->execute();
  return $consulta->fetch();
}
 public function select($idCustomer)
 {
  $listReturn = [];
  $sql =  "select * FROM customers  where idCustomer = :idCustomer";
  $consulta = Conexao::prepare($sql);
  $consulta->bindValue("idCustomer",  $idCustomer);
  $consulta->execute();
  $obj =  $consulta->fetchAll();


  $sql =  "select * FROM contacts  where idCustomer = :idCustomer";
  $consulta = Conexao::prepare($sql);
  $consulta->bindValue("idCustomer",  $idCustomer);
  $consulta->execute();
  $listContacts =  $consulta->fetchAll();


  $sql =  "select * FROM adresses  where idCustomer = :idCustomer";
  $consulta = Conexao::prepare($sql);
  $consulta->bindValue("idCustomer",  $idCustomer);
  $consulta->execute();

  $listAdresses = $consulta->fetchAll();

  array_push($listReturn, $obj, $listContacts, $listAdresses);

  return $listReturn;
 }
/* Função responsavel por  realizar a inserção do cliente. Primeiramente será inserido os dados via função os dados base do cliente.
A função returna o id do registro inserido, na sequencia são inseridos os demais dados sendo agregado o id do cliente para assim criar o relacionamento

*/
 public function insert($listObj)
 {
  // Insere os dados do cliente no banco
  $sql =  " select insert_Customers( :name, :cpf, :dispatcher, :rg, :birthday, :obs) as id";

  $consulta = Conexao::prepare($sql);
  $consulta->bindValue("name",  $listObj[0]->name);
  $consulta->bindValue("cpf",  $listObj[0]->cpf);
  $consulta->bindValue("dispatcher",  $listObj[0]->dispatcher);
  $consulta->bindValue("rg",  $listObj[0]->rg);
  $consulta->bindValue("birthday",  $listObj[0]->birthday);
  $consulta->bindValue("obs",  $listObj[0]->obs);
  $consulta->execute();
  $idCustomer = $consulta->fetch()->id;

  // salva imagem no diretorio e em seguida atualiza o cliente com nome da imagem   
  $nameImage = self::base64ToImage($listObj[0]->image, $idCustomer);
  $sql =  " UPDATE customers SET image = :image WHERE idCustomer = :idCustomer";
  $consulta = Conexao::prepare($sql);
  $consulta->bindValue("image",  $nameImage);
  $consulta->bindValue("idCustomer",  $idCustomer);

  $consulta->execute();

  // Insere os contatos e os relacionam com o cliente   
  foreach ($listObj[1] as $contact) {
   $sql =  " INSERT INTO contacts(idCustomer, type, number, email) VALUES (:idCustomer, :type, :number, :email)";
   $consulta = Conexao::prepare($sql);
   $consulta->bindValue("idCustomer",  $idCustomer);
   $consulta->bindValue("type", $contact->type);
   $consulta->bindValue("number", $contact->number);
   $consulta->bindValue("email", $contact->email);

   $consulta->execute();
  }

  // Insere os enderecos e os relacionam com o cliente   
  foreach ($listObj[2] as $address) {
   $sql =  " INSERT INTO adresses ( idCustomer, type, street, district, number, complement, city, state, zipCode) 
                           VALUES (:idCustomer, :type, :street, :district, :number, :complement, :city, :state, :zipCode)";
   $consulta = Conexao::prepare($sql);
   $consulta->bindValue("idCustomer",  $idCustomer);
   $consulta->bindValue("type", $address->type);
   $consulta->bindValue("street", $address->street);
   $consulta->bindValue("district", $address->district);
   $consulta->bindValue("number", $address->number);
   $consulta->bindValue("complement", $address->complement);
   $consulta->bindValue("city", $address->city);
   $consulta->bindValue("state", $address->state);
   $consulta->bindValue("zipCode", $address->zipCode);

   $consulta->execute();
  }
  return true;
 }

 public function delete($idCustomer = null)
 {
  $sql = "DELETE FROM customers WHERE idCustomer = :idCustomer";
  $consulta = Conexao::prepare($sql);
  $consulta->bindValue("idCustomer", $idCustomer);
  return $consulta->execute();
 }

 public function update($obj)
 {
  $sql = "UPDATE customers
          SET 
          name= :name,
          cpf=:cpf,
          dispatcher=:dispatcher,
          rg=:rg,
          birthday=:birthday,
		  nickname = :nickname,
		  genre = :genre,
		  user = :user,
		  password = :password,";

  if ($obj->image != null)
   $sql .= "  image=:image,";

  $sql .= "
          obs=:obs
          WHERE idCustomer = :idCustomer";
  $consulta = Conexao::prepare($sql);
  $consulta->bindValue("name",  $obj->name);
  $consulta->bindValue("cpf",  $obj->cpf);
  $consulta->bindValue("nickname",  $obj->nickname);
  $consulta->bindValue("genre",  $obj->genre);
  $consulta->bindValue("user",  $obj->user);
  $consulta->bindValue("password",  $obj->password);
  $consulta->bindValue("dispatcher",  $obj->dispatcher);
  $consulta->bindValue("rg",  $obj->rg);
  $consulta->bindValue("birthday",  $obj->birthday);
  $consulta->bindValue("obs",  $obj->obs);
  $consulta->bindValue("idCustomer", $obj->idCustomer);
  if ($obj->image != null)
   $consulta->bindValue("image",  self::base64ToImage($obj->image, $obj->idCustomer));

 return  $consulta->execute();
 }

// Função responsavel por inserir a imagem no diretorio e retornar o nome da mesma.
 function base64ToImage($dataImagem, $idCustomer)
 {
  $data = '';
  if (!is_dir("Imgs/Customers/" . $idCustomer . "/")) {
   mkdir("Imgs/Customers/" . $idCustomer . "/");
  }
  list($type, $dataImagem) = explode(';', $dataImagem);
  list(, $extension) = explode('/', $type);
  list(, $dataImagem)      = explode(',', $dataImagem);
  $fileName = date("Y-m-d-H-i-s") . uniqid() . '.' . $extension;
  $dataImagem = base64_decode($dataImagem);
  file_put_contents("Imgs/Customers/" . $idCustomer . "/" . $fileName, $dataImagem);
  return $fileName;
 }
}
