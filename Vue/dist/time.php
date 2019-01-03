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

$post_data = json_decode(file_get_contents('php://input'), true);

if(isset($post_data['token_mystery'])){
  $token = $post_data['token_mystery'];
  
  $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
  // Check user existance
  
  $stmt = $conn->prepare("SELECT * FROM users WHERE password = ?");
  if($stmt->execute(array($token))){
    $user = $stmt->fetch();
    $uniDetails = $conn->prepare("SELECT * FROM uni_details WHERE uniNameCN = ?");
    $uniDetails->execute(array($user['uniNameCN']));
    $uniDetails = $uniDetails->fetch();

    if($uniDetails['drawn'] == 0){
      
      // Set some variables
      switch($user['region']){
        case "Singapore": $offTimeStart = 1544434200000000; $offTimeEnd = 1544445000000000; break;
        case "Malaysia": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
        case "Australia": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
        case "China": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
        case "Hong Kong": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
        case "Taiwan": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
        case "Macau": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
        case "Others": $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
        case "Admin": $offTimeStart = 1546515000000000; $offTimeEnd = 1546525800000000; break;
        default: $offTimeStart = 1544345460000000; $offTimeEnd = 1544345520000000; break;
      };

      
      // $offTimeStart = $uniDetails['offTimeStart']; 
      // $offTimeEnd = $uniDetails['offTimeEnd'];
      // $pressedTime = $uniDetails['offTimePress'];
      $pressTime = microtime(true)*1000000; //microsecond
      
      $difference = $pressTime - $offTimeStart;
      
      if($difference < 0){ //before start time
        response([
          'message' => "还未到报名时间!"
        ]);
      }else if($difference > 10800000000){ //after end time
        $end = microtime(true);
        date_default_timezone_set("Asia/Singapore");
        $diff = $end-$start;
        response([
          'message' => "报名已经结束了!".$diff.date("d/m/Y H:i:s", $pressTime/1000000)." SGT"
        ]);
      }else{ //between the 3 hours interval
        // Get UniDetails 
        
        $pressedTime = $uniDetails['offTimePress'];
        // Check time range
        if($pressTime > $pressedTime){
            response([
                'message' => "队伍已经报名了！请等待成绩！",
                'status' => '304'
                ]);
        }
        $updateTime = $conn->prepare("UPDATE uni_details SET offTimePress=?, offTimeDiff = ?, drawn = 1 WHERE  uniNameCN = ?");
        if($updateTime->execute(array($pressTime, $pressTime - $offTimeStart, $user['uniNameCN']))){
          response([
            'message' => "时间成功记录！",
            'status' => 200,
          ]);
        }
      }
    //     if($pressTime < $offTimeEnd){
    //       $updateTime = $conn->prepare("UPDATE uni_details SET offTimePress=?, offTimeDiff = ?, drawn = 1 WHERE  uniNameCN = ?");
        
    //       if($updateTime->execute(array($pressTime, $pressTime - $offTimeStart, $user['uniNameCN']))){
    //         response([
    //           'message' => "Simulate press time is recorded!",
    //           'status' => 200,
    //           'time' => date("Y-m-d H:i:s", microtime(true)),
    //           'epoch' => $pressTime,
    //           'converted' => strtotime(date("Y-m-d H:i:s", microtime(true)))
    //         ]);
    //       }
    //     }else{
    //         response([
    //           'message' => '报名已经结束了！',
    //         ]);
    //     }   
    //   } else {
    //     response([
    //       'message' => '还没到报名时间！',
    //       'offTimeStart' => $offTimeStart,
    //       'offTimeEnd' => $offTimeEnd,
    //       'user' => $user,
    //     ]);
    //   }
    // } else {
    //   response([
    //     'message' => '队伍已报名！',
    //   ]);
    // }
  }else{
    response([
      'message' => "队伍已经报名了!"
    ]);
  }
}
}
