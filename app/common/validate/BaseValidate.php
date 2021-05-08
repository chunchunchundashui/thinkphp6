<?php
declare (strict_types = 1);

namespace app\common\validate;

use app\common\controller\exception\BaseException;
use think\Validate;

class BaseValidate extends Validate
{
    // 验证提交表单
    public function goCheck($scene = '') {
        // 获取所有数据
        $params = input('');
        // 开始验证
        if (!$this->scene($scene)->check($params)) {
            throw new BaseException(['msg' => $this->getError(), 'errorCode' => 10000, 'code' => 400]);
        }
        return true;
    }
}
