<?php

$servername = "localhost";
$username   = "apchine2_user";
$password   = "apchinese9";
$dbname     = "apchine2_apdebate";
// $servername = "localhost";
// $username   = "apcn";
// $password   = "abc123456";
// $dbname     = "apchinese";

/** 
 * Get header Authorization
 * */
function getAuthorizationHeader(){
  $headers = null;
  if (isset($_SERVER['Authorization'])) {
      $headers = trim($_SERVER["Authorization"]);
  }
  else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
      $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
  } elseif (function_exists('apache_request_headers')) {
      $requestHeaders = apache_request_headers();
      // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
      $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
      //print_r($requestHeaders);
      if (isset($requestHeaders['Authorization'])) {
          $headers = trim($requestHeaders['Authorization']);
      }
  }
  return $headers;
}

function getBearerToken() {
  $headers = $this->getAuthorizationHeader();
  // HEADER: Get the access token from the header
  if (!empty($headers)) {
      if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
          return $matches[1];
      }
  }
  return null;
}


function response($data) {
  header('Content-Type: application/json');
  header("HTTP/1.1 200 OK");
  echo json_encode($data);
  exit;
}

$get_data = $_REQUEST;


if(isset($get_data['token_mystery'])){
  $token = $get_data['token_mystery'];
  $region = $get_data['region'];
  $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  //look for user

  $stmt = $conn->prepare("SELECT uniNameCN from users where password=? AND region=?");
  if($stmt->execute(array($token,$region))){
      $user = $stmt->fetch();
      $uniDetails = $conn->prepare("SELECT offTimeStart,offTimeEnd FROM uni_details WHERE uniNameCN = ?");
      $uniDetails->execute(array($user['uniNameCN']));
      $uniDetails = $uniDetails->fetch();

      date_default_timezone_set("Asia/Singapore");

      response([
        'status' => 200,
        'offTimeStart' => date("d/m/Y H:i:s", $uniDetails['offTimeStart']/1000000)." SGT",
        'offTimeEnd' => date("d/m/Y H:i:s", $uniDetails['offTimeEnd']/1000000)." SGT"
      ]);
  }else{
      response([
          'message' => 'not found'
      ]);
  }
}