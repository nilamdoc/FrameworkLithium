<?php
namespace app\controllers;

use app\models\Users;
use app\models\Countries;

use app\models\Accounts;

use lithium\storage\Session;

use app\extensions\action\Functions;
use app\extensions\action\GoogleAuthenticator;

class ExController extends \lithium\action\Controller {
 public function _inherit(){
  $user = Session::read('default');
  $conditions = array(
   'email'=>strtolower($user['email']),
   'secret'=>$user['secret']
  );
  $user = Users::find('first',array(
   'conditions'=>$conditions
  ));
  if(!is_array($user)){
   return $this->redirect('/user/login');
  }
 }
 public function index(){}
 public function logout(){
			Session::delete('default');		
   return $this->redirect('/');
 }
 public function settings(){
  $user = Session::read('default');
  $conditions = array(
   'email'=>strtolower($user['email']),
   'secret'=>$user['secret']
  );
  if($this->request->data){
   extract($this->request->data);
   $data = array(
    'Name'=>$Name,
    'Mobile'=>$Mobile,
    'Country'=>$Country,
    'Network'=>$Network
   );
   Users::update($data,$conditions);
  }
  
  
  $user = Users::find('first',array(
   'conditions'=>$conditions
  ));
  $countries = Countries::find('all',array(
   'fields'=>array('Country','Phone'),
   'order'=>array('Country'=>'ASC')
  ));
  return compact('user','countries');
 }
}
?>