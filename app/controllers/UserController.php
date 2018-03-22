<?php
namespace app\controllers;

use app\models\Users;
use app\models\Accounts;

use lithium\storage\Session;

use app\extensions\action\Functions;
use app\extensions\action\GoogleAuthenticator;

class UserController extends \lithium\action\Controller {
 public function _inherit(){

  
 }

 public function login(){
		Session::delete('default');		
  if($this->request->data){
   extract($this->request->data);
   $conditions = array(
    'email'=>strtolower($email),
   );
   $user = Users::find('first',array(
    'conditions'=>$conditions
   ));
   if(count($user)>0){
    if(password_verify($password, $user['password']) && $user['email_verify']=='Verified'){
     Session::write('default',$user);
     return $this->redirect('/ex/');
    }else{
     return $this->redirect('/user/login');
    }
   }
  return compact('user');
  }
 }
 public function register(){
  if($this->request->data){
   extract($this->request->data);
   $conditions = array('email'=>strtolower($email));
   $user = Users::find('first',array(
    'conditions'=>$conditions
   ));
   if(count($user)==0){
    $key = md5(time());
    $ga = new GoogleAuthenticator();
    $secret = $ga->createSecret(64);
    $email_code = $ga->getCode($secret);
    $function = new Functions();

    $data = array(
      'email'=>$email,
      'key'=>$key,
      'secret'=>$secret,
      'email_code'=>$email_code,
      'password' => password_hash($password, PASSWORD_BCRYPT),
      'IP' => $function->getIPAddress(),
      'Server'=>md5($_SERVER["SERVER_ADDR"]),
    		'Refer'=>md5($_SERVER["REMOTE_ADDR"]),
      );
     $user = Users::create()->save($data);
     // Send Email Function
     $emaildata = array(
      'email'=>$email,
      'key'=>$key,
      'secret'=>$secret,
      'email_code'=>$email_code,
      'IP' => $_SERVER["REMOTE_ADDR"],
      );
      $compact = array('data'=>$emaildata);
      $controller = 'user';
      $template = 'verifyEmail';
      $subject = 'Verify your email';
      $from = FROM;
      $mail1=null;$mail2=null;$mail3=null;$attach=null;
      $function->sendEmailTo($email,compact('compact'),$controller,$template,$subject,$from,$mail1,$mail2,$mail3,$attach);
      return $this->redirect('/user/verifyemail/'.$key);
   }
  }
 return compact('user');
 }
 public function verifyemail($key=null,$emailcode=null){
  $conditions = array('key'=>$key);
   $user = Users::find('first',array(
    'conditions'=>$conditions
   ));
   $verify = "";
  if($user['email_code']==$emailcode){
   $verify ="Verified!";
  }
  if($this->request->data){
   extract($this->request->data);
   if($user['email_code']==$emailcode){
    $verify ="Verified!";
   }
  }
  if($verify=="Verified!"){
   $data = array(
    email_verify => 'Verified'
   );
   Users::update($data,$conditions);
  }
  return compact('user','verify');
 }
}
?>