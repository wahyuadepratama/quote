<?php

class Controller{

  protected $f3;
  protected $db;

  public function __construct(){
    $f3 = Base::instance();
    $this->f3 = $f3;
    $db = new DB\SQL(
      $f3->get('devdb'),
      $f3->get('devdbusername'),
      $f3->get('devdbpassword'),
      array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION )
    );
    $this->db = $db;
  }

  public function checkUser(){
    session_start();
    if(!isset($_SESSION['user'])){
      echo json_encode(["status" => "Error", "message" => "Please login to access this route"]);
      return false;
    }
  }
}
