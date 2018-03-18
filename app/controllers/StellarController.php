<?php
namespace app\controllers;
use ZuluCrypto\StellarSdk\Keypair;
use ZuluCrypto\StellarSdk\Server;
use app\models\Accounts;


class StellarController extends \lithium\action\Controller {
        public function _inherit(){}
        public function createAccount(){

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
                return $this->render(array('json'=>array(
                        'public'=>$pub,
                        'secret'=>$secret,
                        'publicReceive'=>$pubReceive,
                        'secretReceive'=>$secretReceive,

                )));
        }
        public function fundAccount($pubkey=null){
        // See 01-create-account.php for where this was generated
                $publicAccountId = $pubkey;

                // Use the testnet friendbot to add funds:
                $response = file_get_contents('https://horizon-testnet.stellar.org/friendbot?addr=' . $publicAccountId);

                // After a successful response, the account will have lumens from the testbot
                if ($response !== false) {
                        $funded = 'Success! Account is now funded.';
                        return $this->render(array('json'=>array('funded'=>$funded,'response'=>$response)));
                }
        }
        public function getAccount($pubkey=null){

                $publicAccountId = $pubkey;
                $server = Server::testNet();
//              print_r($server);

                $account = $server->getAccount($publicAccountId);
              print_r($account);
//              print 'Balances for account ' . $publicAccountId . PHP_EOL;
                foreach ($account->getBalances() as $balance) {
                // printf('  Type: %s, Code: %s, Balance: %s' . PHP_EOL,
                        $type = $balance->getAssetType();
                $code = $balance->getAssetCode();
                $balance =      $balance->getBalance();
                }
        return $this->render(array('json'=>array(
                'account'=>$publicAccountId,
                'type'=>$type,
                'code'=>$code,
                'balance'=>$balance
        )));
        }

}


