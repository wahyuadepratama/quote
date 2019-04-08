<?php

class GuestController extends Controller{

  public function quote(){
    $quote = $this->db->exec("SELECT quote.id, quote.quote, user.username AS owner, user.email AS email_owner, category.name AS category_name, quote.updated_at AS last_updated FROM quote
                              LEFT JOIN category ON  quote.category_id = category.id
                              LEFT JOIN user ON quote.user_id = user.id"
                            );
    echo json_encode(['status' => 'Success', 'result' => $quote]);
    return true;
  }

  public function category(){
    $quote = $this->db->exec("SELECT * FROM category");
    echo json_encode($quote);
    return true;
  }
}
