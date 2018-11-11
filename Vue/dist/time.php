<?php

$servername = "localhost";
$username   = "apchine2_user";
$password   = "apchinese9";
$dbname     = "apchine2_apdebate";

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

if(isset($_POST['token_mystery'])){
  $token = $_POST['token_mystery'];
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", 'forge', $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Check user existance
  $stmt = $conn->prepare("SELECT * FROM users WHERE password = ?");
  if($stmt->execute(array($token))){
    $user = $stmt->fetch();

    if($user['drawn'] !== 1){
      // Get UniDetails 
      $uniDetails = $conn->prepare("SELECT * FROM uni_details WHERE uniNameCN = ?");
      $uniDetails->execute(array($user['uniNameCN']));
      $uniDetails = $uniDetails->fetch();

      // Set some variables
      $simTimeStart = $uniDetails['simTimeStart'];
      $simTimeEnd = $uniDetails['simTimeEnd'];
      $offTimeStart = $uniDetails['offTimeStart'];
      $offTimeEnd = $uniDetails['offTimeEnd'];
      $pressTime = microtime(true)*1000;

      // Check time range
      if($pressTime >= $simTimeStart && $pressTime < $simTimeEnd){
        $updateTime = $conn->prepare("UPDATE users SET offTimePress=?, offTimeDiff = ?, drawn = 1 WHERE  uniNameCN = ?");
        if($updateTime->execute(array($pressTime, $pressTime - $offTimeStart, $user['uniNameCN']))){
          response([
            'message' => "Simulate press time is recorded!",
            'status' => 200,
            'time' => date("Y-m-d H:i:s", microtime(true)),
            'epoch' => $pressTime,
            'converted' => strtotime(date("Y-m-d H:i:s", microtime(true)))
          ]);
        }
      } else {
        response([
          'message' => '还没到报名时间！',
          'status' => 201
        ]);
      }
    } else {
      response([
        'message' => 'The player has already drawn!',
        'status' => 304
      ]);
    }
  }
}