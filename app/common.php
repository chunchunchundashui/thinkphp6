<?php
// 应用公共文件

// 封装异常处理函数
function throwException($msg = '异常', $errorCode = 999, $code = 400) {
    throw new \app\common\controller\exception\BaseException(['code' => $code, 'msg' => $msg, 'errorCode' => $errorCode]);
}

// 获取文件完整url
function getFileUrl($url = '') {
    if (!$url) return;
    return url($url, '', false, true);
}