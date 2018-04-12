<?php 
namespace app\controllers; 
use app\models\Telegrams; 
use app\models\Users; 

use ZuluCrypto\StellarSdk\Keypair;
use ZuluCrypto\StellarSdk\Server;
use ZuluCrypto\StellarSdk\XdrModel\Operation\PaymentOp;


 class TelegramController extends \lithium\action\Controller {
 public function _inherit(){}

 public function run($botURL){
   if($botURL != TELEGRAM){return "False";}
    define('API_URL', 'https://api.telegram.org/bot'.TELEGRAM.'/');
    define('LITHIUM_WEBROOT_PATH', str_replace("\\","/",str_replace("F:","",dirname(LITHIUM_APP_PATH))) . '/app/webroot');
    $arrContextOptions=array(
     "ssl"=>array(
     "verify_peer"=>false,
     "verify_peer_name"=>false,
    ),
   );
   $content = file_get_contents("php://input", false, stream_context_create($arrContextOptions));
   $update = json_decode($content, true);
   $parse_mode="HTML";
   var_dump($update["message"]);
   if (isset($update["message"])) {
     $this->processMessage($update["message"]);
   } else if (isset($update["callback_query"])){
       $callbackQuery = $update["callback_query"];
       $queryId = $callbackQuery["from"]["id"];
       $data = $callbackQuery["data"];
       $this->apiRequest("sendMessage", array('chat_id' => $queryId, "text" => $data, "parse_mode"=>$parse_mode));

   } else if (isset($update["inline_query"])) {
       $inlineQuery = $update["inline_query"];
       $queryId = $inlineQuery["id"];
       $queryText = $inlineQuery["query"];
       $queryFrom = $inlineQuery["from"]["first_name"]. " " . $inlineQuery["from"]["last_name"]. " (".$inlineQuery["from"]["username"].")";
       $message_text = $queryFrom . "
/start
/generatekeys
/network";

      if (isset($queryText) && $queryText !== "") {
        $this->apiRequestJson("answerInlineQuery", [
          "inline_query_id" => $queryId,
          "results" => $this->queryInline($queryText,$queryId,$messageText),
          "cache_time" => 86400,
        ]);
      } else {
        $this->apiRequestJson("answerInlineQuery", [
         "inline_query_id" => $queryId,
         "cache_time"=>5,
         "results" => [
            [
              "type" => "article",
              "id" => "0",
              "title" => "Generate Keys",
              "message_text" => "@@StellarXLMBot GenerateKeys",
            ],
            [
              "type" => "article",
              "id" => "1",
              "title" => "Select Network",
              "message_text" => "/network",
            ],

          ]
        ]);
      }
  }
    return "OK"; 
//    return $this->render(array('layout' => false));
}
 function processMessage($message) {
  // process incoming message
  $message_id = $message['message_id'];
  $chat_id = $message['chat']['id'];
  if (isset($message['text'])) {
    // incoming text message
    $text = $message['text'];
$userName = $message['chat']['first_name'] . " " . $message['chat']['last_name'] . " (".$message['chat']['username'].")";
$ReplyText = "Hi ".$userName.",
<b>Stellar Luments XML</b> welcomes you.
We provide with the following details:
|- Generate Keys
|- Select Network
|- Trade XML
|- Account Info

Select any one
";
$parse_mode="HTML";

    if (strpos($text, "/generatekeys") === true){
      $commands = split(" ", $text);
      $ReplyText = "aa";//$this->generateKeys();
      $this->apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $ReplyText, "parse_mode"=>$parse_mode));
    }else if(strpos($text, "/selectnetwork") === 0){
      $commands = split(" ", $text);
      $ReplyText = $this->generateKeys();
      $this->apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => $ReplyText, "parse_mode"=>$parse_mode));
    }
  }
  $this->apiRequest("sendMessage", array('chat_id' => $chat_id, "text" => strpos($text, "/generatekeys"), "parse_mode"=>$parse_mode));
 }

 function generateKeys(){
  $keypair = Keypair::newFromRandom();
  $secret = $keypair->getSecret() ;
  $pub = $keypair->getPublicKey() ;
  $text = "Public Key (pk): ".$pub. "
";
 $text = $text . "Secret Key (sk): ".$secret. "
";
 return "Grnerated";
  return $text;
 }
 public function curl_get_contents($url){
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_HEADER, 0);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_URL, $url);
   $data = curl_exec($ch);
   curl_close($ch);
   return $data;
 }
 function apiRequestWebhook($method, $parameters) {
   if (!is_string($method)) {
     error_log("Method name must be a string\n");
     return false;
   }
   if (!$parameters) {
     $parameters = array();
   } else if (!is_array($parameters)) {
     error_log("Parameters must be an array\n");
     return false;
   }
   $parameters["method"] = $method;
   header("Content-Type: application/json");
   echo json_encode($parameters);
   return true;
 }
 function exec_curl_request($handle) {
   $response = curl_exec($handle);
   if ($response === false) {
     $errno = curl_errno($handle);
     $error = curl_error($handle);
     error_log("Curl returned error $errno: $error\n");
     curl_close($handle);
     return false;
   }
   $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
   curl_close($handle);
   if ($http_code >= 500) {
     // do not wat to DDOS server if something goes wrong
     sleep(10);
     return false;
   } else if ($http_code != 200) {
     $response = json_decode($response, true);
     error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
     if ($http_code == 401) {
       throw new Exception('Invalid access token provided');
     }
     return false;
   } else {
     $response = json_decode($response, true);
     if (isset($response['description'])) {
       error_log("Request was successful: {$response['description']}\n");
     }
     $response = $response['result'];
   }
   return $response;
 }
 function apiRequest($method, $parameters) {
   if (!is_string($method)) {
     error_log("Method name must be a string\n");
     return false;
   }
   if (!$parameters) {
     $parameters = array();
   } else if (!is_array($parameters)) {
     error_log("Parameters must be an array\n");
     return false;
   }
   foreach ($parameters as $key => &$val) {
     // encoding to JSON array parameters, for example reply_markup
     if (!is_numeric($val) && !is_string($val)) {
       $val = json_encode($val);
     }
   }
   $url = API_URL.$method.'?'.http_build_query($parameters);
   $handle = curl_init($url);
   curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($handle, CURLOPT_SAFE_UPLOAD, false);
   curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
   curl_setopt($handle, CURLOPT_TIMEOUT, 60);
   return $this->exec_curl_request($handle);
 }
 function apiRequestPhoto($method,$photo, $parameters) {
   if (!is_string($method)) {
     error_log("Method name must be a string\n");
     return false;
   }
   if (!$parameters) {
     $parameters = array();
   } else if (!is_array($parameters)) {
     error_log("Parameters must be an array\n");
     return false;
   }
   foreach ($parameters as $key => &$val) {
     // encoding to JSON array parameters, for example reply_markup
     if (!is_numeric($val) && !is_string($val)) {
       $val = json_encode($val);
     }
   }

   $url = API_URL.$method.'?'.http_build_query($parameters);
// print_r($url);
   $handle = curl_init($url);
   curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
   curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
   curl_setopt($handle, CURLOPT_TIMEOUT, 60);
   curl_setopt($handle, CURLOPT_SAFE_UPLOAD, false);
   curl_setopt($handle, CURLOPT_INFILESIZE, filesize($photo));
   return $this->exec_curl_request($handle);
 }

 function apiRequestJson($method, $parameters) {
   if (!is_string($method)) {
     error_log("Method name must be a string\n");
     return false;
   }
   if (!$parameters) {
     $parameters = array();
   } else if (!is_array($parameters)) {
     error_log("Parameters must be an array\n");
     return false;
   }
   $parameters["method"] = $method;
   $handle = curl_init(API_URL);
   curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
   curl_setopt($handle, CURLOPT_TIMEOUT, 60);
   curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
   curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
   return $this->exec_curl_request($handle);
 }

}