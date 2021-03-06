<?php
namespace app\controllers;

use lithium\storage\Session;
use app\models\Users;

use ZuluCrypto\StellarSdk\Keypair;
use ZuluCrypto\StellarSdk\Server;
use ZuluCrypto\StellarSdk\XdrModel\Operation\PaymentOp;

use app\models\Accounts;


class StellarController extends \lithium\action\Controller {
 public function _inherit(){}
 public function account(){
  
 }
 public function createAccount(){
 $user = Session::read('default');
 $conditions = array(
  'email'=>strtolower($user['email']),
//  'secret'=>$user['secret']
 );
 $user = Users::find('first',array(
  'conditions'=>$conditions
 ));  
 if($this->request->data){
  $keypair = Keypair::newFromRandom();
  $keypairReceive = Keypair::newFromRandom();

  $secret = $keypair->getSecret() ;
  $secretReceive = $keypairReceive->getSecret() ;
  // SAV76USXIJOBMEQXPANUOQM6F5LIOTLPDIDVRJBFFE2MDJXG24TAPUU7
  $pub = $keypair->getPublicKey() ;
  $pubReceive = $keypairReceive->getPublicKey() ;
  // GCFXHS4GXL6BVUCXBWXGTITROWLVYXQKQLF4YH5O5JT3YZXCYPAFBJZB
 
  $data = array(
   'secret'=>$user['secret'],
   'accounts.public'=>$pub,
   'accounts.secret'=>$secret,
  );
  $account = Accounts::create()->save($data);
 }
  $conditions = array(
   'secret'=>$user['secret']
  );

 $accounts = Accounts::find('all', array(
  'conditions'=>$conditions
  ));
 return compact('accounts','user','secret','pub');
  // return $this->render(array('json'=>array(
   // 'public'=>$pub,
   // 'secret'=>$secret,
   // 'publicReceive'=>$pubReceive,
   // 'secretReceive'=>$secretReceive,
  // )));
}
 public function fundAccount($pubkey=null){
 // See 01-create-account.php for where this was generated
  $publicAccountId = $pubkey;

  // Use the testnet friendbot to add funds:
  $response = file_get_contents('https://horizon-testnet.stellar.org/friendbot?addr=' . $publicAccountId);

  // After a successful response, the account will have lumens from the testbot
  if ($response !== false) {
   $funded = 'Success! Account is now funded.';
   return compact('pubkey','funded');
   //return $this->render(array('json'=>array('funded'=>$funded,'response'=>$response)));
  }else{
   $funded = 'Error! Unable to fund account at this time, try again.';
   return compact('pubkey','funded');
  }
 }
 public function getAccount($pubkey=null){
  $publicAccountId = $pubkey;
  $server = Server::testNet();
  $account = $server->getAccount($publicAccountId);
  if($account){
   foreach ($account->getBalances() as $balance) {
    $type = $balance->getAssetType();
    $code = $balance->getAssetCode();
    $balance =      $balance->getBalance();
   }
   $data = array(
    'account'=>$publicAccountId,
    'type'=>$type,
    'code'=>$code,
    'balance'=>$balance
   ); 
  }else{
   $data = array(
    'account'=>$publicAccountId,
    'type'=>'Native',
    'code'=>'XLM',
    'balance'=>0
    );
   
  }
  
  return compact('data');
 }
 public function transactions(){
  $accounts = Accounts::find('all');
  $accountData = array();
  foreach ($accounts as $account){
   array_push($accountData, $this->getAccount($account['public']));
  }
  return compact('accountData');
 }

 public function transfer($pubkey){
   $conditions = array('public'=>$pubkey);
   $pair = Accounts::find('first', array(
    'conditions'=>$conditions
   ));
   $secret = $pair['secret'];
   $account = $this->getAccount($pubkey);
   $conditions = array('public'=>array('$ne'=>$pubkey));
   
 if($this->request->data){
   $server = Server::testNet();
   $conditions = array('public'=>$this->request->data['sendFrom']);

   $pair = Accounts::find('first', array(
    'conditions'=>$conditions
   ));
   $secret = $pair['secret'];
   $pubkey = $pair['public'];
   $account = $this->getAccount($pubkey);
   
   // GAHC2HBHXSRNUT5S3BMKMUMTR3IIHVCARBFAX256NONXYKY65R2C5267
   // You may need to fund this account if the testnet has been reset:
   // https://www.stellar.org/laboratory/#account-creator?network=test
   
   $sourceKeypair = Keypair::newFromSeed($secret);
   $funded = $this->fundAccount($this->request->data['sendTo']);
   $destinationAccountId = $this->request->data['sendTo'];

   // Verify that the destination account exists. This will throw an exception
   // if it does not
   
   $destinationAccount = $server->getAccount($destinationAccountId);

   // Build the payment transaction
   $transaction = \ZuluCrypto\StellarSdk\Server::testNet()
       ->buildTransaction($sourceKeypair->getPublicKey())
       ->addOperation(
           PaymentOp::newNativePayment($destinationAccountId, $this->request->data['amount'])
       )
   ;

   // Sign and submit the transaction
   $response = $transaction->submit($sourceKeypair->getSecret());
   $others = Accounts::find('all',array(
    'conditions'=>$conditions
   ));
   
   return compact('response','pubkey','account','others');
  }
  $others = Accounts::find('all',array(
    'conditions'=>$conditions
   ));
  return compact('pubkey','account','others');
 }
 
}