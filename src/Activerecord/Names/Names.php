<?php

namespace Activerecord\Names;

use PDO;

class Names
{
  private $id;
  private $name;
  private $surname;
  private $conn;

  function __construct() {
    $this->conn = new PDO('mysql:host=localhost;dbname=mb', 'vlad', 'qwer5');
  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function getSurname()
  {
    return $this->surname;
  }

  public function setSurname($surname)
  {
    $this->surname = $surname;
  }

  public function findById($id) {
    $sql = 'SELECT * from names WHERE id=:id LIMIT 1';
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam('id', $id);
    $stmt->execute();
    return $stmt->fetchAll()[0];
  }

  public function findBySurname($surname) {
    $sql = 'SELECT * from names WHERE surname=:surname';
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam('surname', $surname);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function getAll() {
    $sql = 'SELECT * from names';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function save() {
    $id = $this->id;
    $name = $this->name;
    $surname = $this->surname;
    $sql = 'INSERT INTO names(id, surname, name) values(:id, :surname, :name)';
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam('id', $id);
    $stmt->bindParam('name', $name);
    $stmt->bindParam('surname', $surname);
    $stmt->execute();
  }

  public function delete() {
    $id = $this->id;
    $sql = 'DELETE FROM names WHERE id=:id';
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam('id', $id);
    $stmt->execute();
  }

}
