<?php
include_once '../conn/conn.php';

class ControllerContacts
{

 public function select($idCustomer)
 {

  $sql =  "select * FROM contacts  where idCustomer = :idCustomer";
  $consulta = Conexao::prepare($sql);
  $consulta->bindValue("idCustomer",  $idCustomer);
  $consulta->execute();
  return $consulta->fetchAll();
 }

 public function save($listObj)
 {
  $sql = "";
  foreach ($listObj as $contact) {
   if ($contact->idContact > 0 && $contact->idContact != null) {
    $sql = "UPDATE contacts
            SET 
             type = :type,
             number = :number,
             email =  :email
            WHERE idContact =" . $contact->idContact;
   } else {
    $sql =  " INSERT INTO contacts(idCustomer, type, number, email) VALUES (:idCustomer, :type, :number, :email)";
   }
   $consulta = Conexao::prepare($sql);
   if ($contact->idContact == 0 && $contact->idContact == null)
    $consulta->bindValue("idCustomer",  $contact->idCustomer);
   $consulta->bindValue("type", $contact->type);
   $consulta->bindValue("number", $contact->number);
   $consulta->bindValue("email", $contact->email);
   $consulta->execute();
  }
  return true;
 }

 public function delete($idContact = null)
 {
  $sql = "DELETE FROM contacts WHERE idContact = :idContact";
  $consulta = Conexao::prepare($sql);
  $consulta->bindValue("idContact", $idContact);
  return $consulta->execute();
 }
}
