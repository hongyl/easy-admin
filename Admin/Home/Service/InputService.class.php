<?php
namespace Home\Service;

/**
 * InputService
 */
class InputService extends CommonService {
    /**
     * 添加input
     * @param array input
     * @return
     */
    public function add($input) {
        $Input = $this->getD();
        $input = $Input->create($input);
        if (false === $Input->add($input)) {
            return $this->resultReturn(false);
        }

        return $this->resultReturn(true);
    }

    /**
     * 检查表单域是否可用
     * @param  array $input Input数组
     * @param  int   $id    需要更新input的id
     * @return mixed
     */
    public function checkInput($input, $id) {
        $Input = $this->getD();
        if ($Input->isValid($input, $id)) {
            return $this->resultReturn(true);
        }

        return $this->errorResultReturn($Input->getError());
    }

    /**
     * 创建input
     * @param  array $input
     * @param  array $field
     * @return array
     */
    public function create(&$input, $field) {
        $inputLogic = D('Input', 'Logic');

        // 处理表单域长度
        $inputLogic->genSize($input);

        // 生成表单域html
        if (!isset($input['html']) || '' == $input['html']) {
            $inputLogic->genHtml($input, $field['name']);
        }

        return $this->getD()->create($input);
    }

    protected function getModelName() {
        return 'Input';
    }
}