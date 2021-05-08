<?php
declare (strict_types = 1);

namespace app\index\controller;

use app\common\controller\BaseController;
use think\Exception;
use think\Request;
use app\common\controller\TxSMSController;
use app\common\controller\AliSMSController;

class Index extends BaseController
{
   public function index()
   {
       $phone = '15082730141';
       $code  = random_int(1000, 9999);
       $al = (new AliSMSController())::SendSMS($phone, $code);
       dump($al); die;

       $result = (new TxSMSController())::txSmsSend($phone, $code);
       return 'index';
   }
}
