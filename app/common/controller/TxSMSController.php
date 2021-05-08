<?php


namespace app\common\controller;

use TencentCloud\Common\Credential;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Sms\V20190711\Models\SendSmsRequest;
use TencentCloud\Sms\V20190711\SmsClient;

class TxSMSController
{
    public static function txSmsSend($phone, $code)
    {
        try {
            $resp = [];
            $cred = new Credential(config('api.txSMS.secretId'), config('api.txSMS.secretKey'));
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint("sms.tencentcloudapi.com");

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);
            $client = new SmsClient($cred, "", $clientProfile);
            $req = new SendSmsRequest();
            $params = array(
                "PhoneNumberSet" => array( '+86'."$phone" ),
                "TemplateID" => config('api.txSMS.TemplateID'),
                "Sign" => config('api.txSMS.Sign'),
                "TemplateParamSet" => array( "$code" ),
                "SmsSdkAppid" => config('api.txSMS.SmsSdkAppid')
            );
            $req->fromJsonString(json_encode($params));

            $resp = $client->SendSms($req);
            return $resp;
        }
        catch(TencentCloudSDKException $e) {
            throwException(['msg' => $e->getErrorCode(), 'errorCode' => 30000, 'code' => 200]);
        }
    }
}