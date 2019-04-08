<?php

class Quote extends DB\SQL\Mapper{

  public function __construct(DB\SQL $db){
    parent::__construct($db, 'quote');
  }

  public function all(){
    $this->load();
    return $this->query;
  }

  public function getById($id){
    $this->load(array('id=?', $id));
    return $this->query;
  }

  public function store(){
    $this->copyFrom('POST');
    $this->save();
  }

  public function edit($id){
    $this->load(array('id=?', $id));
    $this->copyFrom('POST');
    $this->update();
  }

  public function destroy($id){
    $this->load(array('id=?', $id));
    $this->erase();
  }
}
