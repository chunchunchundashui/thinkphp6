<?php


namespace app\common\controller;

// 引入阿里云 sdk  使用composer 下载  composer require alibabacloud/client
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
// 引入异常类
use app\common\controller\exception\BaseException;
class AliSMSController
{
    public static function SendSMS($phone, $code)
    {
        AlibabaCloud::accessKeyClient(config('api.aliSMS.accessKeyId'), config('api.aliSMS.accessSecret'))
            ->regionId('cn-hangzhou')
            ->asDefaultClient();
        try {
            $option = [
                'query' => [
                    'RegionId' => config('api.aliSMS.regionId'),
                    'PhoneNumbers' => $phone,
                    'SignName' => config('api.aliSMS.SignName'),
                    'TemplateCode' => config('api.aliSMS.TemplateCode'),
                    'TemplateParam' => '{"code":'.$code.'}'
                ],
            ];
            $result = AlibabaCloud::rpc()
                ->product(config('api.aliSMS.product'))
                // ->scheme('https') // https | http
                ->version(config('api.aliSMS.version'))
                ->action('SendSMS')
                ->method('GET')
                ->options($option)
                ->request();
            return $result->toArray();
        } catch (ClientException $e) {
            throw new BaseException(['code' => 200, 'msg' => $e->getErrorMessage(), 'errorCode' => 30000]);
        } catch (ServerException $e) {
            throw new BaseException(['code' => 200, 'msg' => $e->getErrorMessage(), 'errorCode' => 30000]);
        }
    }
}