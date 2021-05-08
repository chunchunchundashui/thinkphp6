<?php


namespace app\common\controller\lib;


class Curl
{
    /**
     * @param string $url   请求地址
     * @param array $params 请求参数
     * @param array $header 请求头
     * @param int $timeOut  请求时间
     * @return bool|string
     */
    public static function delete(string $url, array $params = [], array $header = [], int $timeOut = 10)
    {
        return self::curlRequest($url, 'DELETE', $params, '', $header, $timeOut);
    }

    /**
     * @param string $url   请求地址
     * @param array $header 请求头
     * @param int $timeOut  请求时间
     * @return bool|string
     */
    public static function get(string $url, array $header = [], int $timeOut = 10)
    {
        return self::curlRequest($url, 'GET', [], '', $header, $timeOut);
    }

    /**
     * @param string $url   请求地址
     * @param array $params 请求参数
     * @param string $paramsType    请求数据类型
     * @param array $header     请求头
     * @param int $timeOut      请求时间
     * @return bool|string
     */
    public static function post(string $url, array $params = [], string $paramsType = '', array $header = [], int $timeOut = 10)
    {
        return self::curlRequest($url, 'POST', $params, $paramsType, $header, $timeOut);
    }

    /**
     * @param string $url   请求地址
     * @param string $method    请求方式
     * @param array $params     请求参数
     * @param string $paramsType    请求数据类型
     * @param array $header     请求头
     * @param int $timeOut      请求时间
     * @return bool|string
     */
    private static function curlRequest(string $url, string $method = '', array $params = [], string $paramsType = '', array $header = [], int $timeOut)
    {
        $resHeader = [];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);    // 地址
        curl_setopt($ch, CURLOPT_HEADER, 0);    // 请求头
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    //获取的信息以文件流的形式放回， 而不是直接输出
        crul_setopt($ch, CURLINFO_HEADER_OUT, true);    // TRUE 时追踪句柄的请求字符串, 这个很关键，就是允许你查看请求header
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);    // 告诉成功 PHP 从服务器接收缓冲完成前需要等待多长时间，如果目标是个巨大的文件，生成内容速度过慢或者链路速度过慢，这个参数就会很有用
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeOut);     //  告诉 PHP 在成功连接服务器前等待多久（连接成功之后就会开始缓冲输出），这个参数是为了应对目标服务器的过载，下线，或者崩溃等可能状况
        curl_setopt($ch, CURLOPT_FAILONERROR, false);  // PHP在发生错误(HTTP代码返回大于等于300)时，不显示,设置这个选项为一人非零值。默认行为是返回一个正常页，忽略代码。
        if (1 == strpos('$'.$url, "https://")) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($paramsType == 'JSON') {
                $resHeader[] = 'Content-Type: application/json; charset=utf-8';
                $resParams = json_encode($params);
            } else {
                $resParams = http_build_query($params);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, $resParams);
        } else if ($method == 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        } else if ($method == 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }
        $resHeader = array_merge($resHeader, $header);
        if ($resHeader) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $resHeader);
        }
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}