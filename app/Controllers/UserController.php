<?php

class UserController extends Controller{

  public function index($f3){

    $user = $this->db->exec("SELECT username, email FROM user");
    echo json_encode($user);
    // $user = new User($this->db);
    // $user = $user->all();
    // $f3->set('users',$user);
    // echo \Template::instance()->render('welcome.htm');
  }

  public function login($f3){

    $identity = $this->f3->get('POST.identity');
    $password = md5($this->f3->get('POST.password'));

    $user = new User($this->db);
    $user->getByEmail($identity);

    if($user->dry()) {
      $user->getByPhone($identity);
      if($user->dry()){
        echo json_encode(["status" => "Error", "message" => "User Not Found"]);
        return false;
      }
    }

    if($password == $user->password) {
        $token = $this->generateTokenJwt($user->id);
        $this->f3->set('SESSION.user', ["id" => $user->id, "username" => $user->username, "email" => $user->email, "phone" => $user->phone, "token" => $token]);
        echo json_encode(["status" => "Success",
                          "message" => "You successfully loged",
                          "result" => ["email" => $user->email, "token" => $token]]);

    } else {
        echo json_encode(["status" => "error", "message" => "login gagal"]);
    }
  }

  public function register($f3){

    $_POST['password']  = md5($_POST['password']);
    try {
      $user = new User($this->db);
      $user->store();
      $this->f3->set('SESSION.user', ["id" => $user->id, "username" => $user->username, "email" => $user->email, "phone" => $user->phone, "token" => $token]);
      $result = [ 'status' => 'Success',
                  'message' => 'You successfully registered! You are loged now',
                  'result' => ["username" => $user->username, "email" => $user->email, "token" => $this->generateTokenJwt($user->id)]
                ];
      echo json_encode($result);
      return false;
    } catch(\PDOException $e) {
      $err = $e->errorInfo;
      $result = ["status" => "Error", "message" => $err[2]];
      echo json_encode($result);
    }
  }

  public function generateTokenJwt($id){
    // Create token header as a JSON string
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    // Create token payload as a JSON string
    $payload = json_encode(['user_id' => rand()]);
    // Encode Header to Base64Url String
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    // Encode Payload to Base64Url String
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    // Create Signature Hash
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'abC123!', true);
    // Encode Signature to Base64Url String
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    // Create JWT
    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    return $jwt;
  }

  public function logout()
  {
    session_start();
    session_destroy();
    $result = [ 'status' => 'Success',
                'message' => 'You successfully logout'
              ];
    echo json_encode($result);
  }

}
