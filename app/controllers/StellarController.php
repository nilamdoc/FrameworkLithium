<?php
namespace app\controllers;

use ZuluCrypto\StellarSdk\Keypair;
use ZuluCrypto\StellarSdk\Server;
use ZuluCrypto\StellarSdk\XdrModel\Operation\PaymentOp;

use app\models\Accounts;


class StellarController extends \lithium\action\Controller {
 public function _inherit(){}
 public function createAccount(){
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
   'public'=>$pub,
   'secret'=>$secret,
   'publicReceive'=>$pubReceive,
   'secretReceive'=>$secretReceive,
  );
  $account = Accounts::create()->save($data);
 }
 $accounts = Accounts::find('all');
 return compact('accounts');
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
 if($this->request->data){
   $server = Server::testNet();

   // GAHC2HBHXSRNUT5S3BMKMUMTR3IIHVCARBFAX256NONXYKY65R2C5267
   // You may need to fund this account if the testnet has been reset:
   // https://www.stellar.org/laboratory/#account-creator?network=test
   $sourceKeypair = Keypair::newFromSeed($secret);
   $destinationAccountId = 'GA2C5RFPE6GCKMY3US5PAB6UZLKIGSPIUKSLRB6Q723BM2OARMDUYEJ5';

   // Verify that the destination account exists. This will throw an exception
   // if it does not
   $destinationAccount = $server->getAccount($destinationAccountId);

   // Build the payment transaction
   $transaction = \ZuluCrypto\StellarSdk\Server::testNet()
       ->buildTransaction($sourceKeypair->getPublicKey())
       ->addOperation(
           PaymentOp::newNativePayment($destinationAccountId, 1)
       )
   ;

   // Sign and submit the transaction
   $response = $transaction->submit($sourceKeypair->getSecret());

   print "Response:" . PHP_EOL;
   print_r($response->getRawData());

   print PHP_EOL;
   print 'Payment succeeded!' . PHP_EOL;
  }
  return compact('pubkey','account');
 }
 
}