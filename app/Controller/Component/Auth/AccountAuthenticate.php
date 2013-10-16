<?php
//AccountAuth
App::uses('Router','Routing');
App::uses('BaseAuthenticate','Controller/Component/Auth');
class AccountAuthenticate extends BaseAuthenticate{
    public $accountType = [ACCOUNT_LAWYER,ACCOUNT_LAWYER_TEST];
    public function authenticate(CakeRequest $request,CakeResponse $response){
        if(empty($request->data['Account']['account'])||empty($request->data['Password']['password']))return false;
        $account = $request->data['Account']['account'];
        $password = $request->data['Password']['password'];
        //@入ってたらメールで
        $column = 'account_name';
        if(strpos( $account,'@')) {                                                                        
            $column = 'mailaddress';
        }                                                                                                         
        $params = ['conditions'=>[
            'Account.'.$column => $account,
            'Account.del_flg' => 0,
            'Account.account_type' => $this->accountType
        ],'order'=>['Account.modified'=>'DESC']];
        $account = ClassRegistry::init('Account')->find('first',$params);
        if(!empty($account) && $account['Password']['password'] === getPassHash($password,$account['Password']['hash_type'])){
            return $account;    
        }
        return false;
    }
}
