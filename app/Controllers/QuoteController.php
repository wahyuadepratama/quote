<?php

class QuoteController extends Controller{

  public function __construct(){
    $this->checkUser();
  }

  public function storeQuote(){
    $_POST['user_id'] = $_SESSION['id'];
    var_dump($_SESSION);
    return 0;
    try {
      $quote = new Quote($this->db);
      $quote->store();
      $result = [ 'status' => 'Success',
                  'message' => 'You successfully add new quote!',
                  'result' => ["id" => $quote->id,
                               "owner" => $_SESSION['username'],
                               "quote" => $quote->quote,
                               "last_updated" => $quote->updated_at
                              ]
                ];
      echo json_encode($result);
      return false;
    } catch(\PDOException $e) {
      $err = $e->errorInfo;
      $result = ["status" => "Error", "message" => $err[2]];
      echo json_encode($result);
    }
  }
}
