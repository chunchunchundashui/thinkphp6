<?php


namespace app\api\controller;

use app\common\controller\BaseController;
use app\common\controller\AliSMSController;
use app\common\controller\exception\BaseException;
use think\facade\Cache;
class index extends BaseController
{
    public function index()
    {
        $code = random_int(1000, 9999);
        $phone = 15082730141;
        $res = AliSMSController::SendSMS($phone, $code);
        // 发送成功  写入缓存
        if($res['Code']=='OK') return Cache::set($phone, $code, config('api.aliSMS.expire'));
        // 无效号码
        if($res['Code'] == 'isv.MOBILE_NUMBER_ILLEGAL') throw new BaseException(['code' => 200, 'msg' => '无效号码', 'errorCode' => 30002]);
        // 触发次数限制
        if($res['Code'] == 'isv.DAY_LIMIT_CONTROL') throw new BaseException(['code' => 200, 'msg' => '今日超出发送次数，改天再来', 'errorCode' => 30002]);
        // 发送失败
        throwException('发送失败', 30004, 200);
//        throw new BaseException(['code' => 200, 'msg' => '发送失败', 'errorCode' => 30004]);
    }
}