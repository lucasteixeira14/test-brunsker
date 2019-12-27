<?php
include_once '../conn/conn.php';

class ControllerAdresses
{

 public function select($idCustomer)
 {

  $sql =  "select * FROM adresses  where idCustomer = :idCustomer";
  $consulta = Conexao::prepare($sql);
  $consulta->bindValue("idCustomer",  $idCustomer);
  $consulta->execute();
  return $consulta->fetchAll();
 }

 public function save($listObj)
 {
  $sql = "";
  foreach ($listObj as $address) {
   if ($address->idAddress > 0 && $address->idAddress != null) {
    $sql = "UPDATE adresses SET 
             type= :type,
             street= :street,
             district= :district,
             number= :number,
             complement= :complement,
             city= :city,
             state= :state,
             zipCode= :zipCode
            WHERE idAddress =" . $address->idAddress;
   } else {

    $sql =  " INSERT INTO adresses ( idCustomer, type, street, district, number, complement, city, state, zipCode) 
                 VALUES (:idCustomer, :type, :street, :district, :number, :complement, :city, :state, :zipCode)";
   }
   $consulta = Conexao::prepare($sql);
   if ($address->idAddress == 0 && $address->idAddress == null)
    $consulta->bindValue("idCustomer",  $address->idCustomer);
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

 public function delete($idAddress = null)
 {
  $sql = "DELETE FROM adresses WHERE idAddress = :idAddress";
  $consulta = Conexao::prepare($sql);
  $consulta->bindValue("idAddress", $idAddress);
  return $consulta->execute();
 }
}
