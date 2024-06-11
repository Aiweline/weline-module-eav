<?php
declare(strict_types=1);

/*
 * 本文件由 秋枫雁飞 编写，所有解释权归Aiweline所有。
 * 作者：Administrator
 * 邮箱：aiweline@qq.com
 * 网址：aiweline.com
 * 论坛：https://bbs.aiweline.com
 * 日期：25/4/2024 15:29:13
 */

namespace Weline\Eav\Ui\EavModel\Select;

use Weline\Eav\EavModelInterface;
use Weline\Eav\Model\EavAttribute;

class Option implements EavModelInterface
{

    function getHtml(EavAttribute &$attribute, mixed $value, string &$label_class, array &$attrs, array &$option_items = []): string
    {
        $type = $attribute->getTypeModel();
        $options = $this->getModelData();
        foreach ($option_items as $key=>$option_item) {
            $options[$key] = $option_item;
        }
        $attrStr      = '';
        foreach ($attrs as $key => $attr_val) {
            if(is_array($attr_val)){
                $attrStr .= ' ' . $key . '="' . implode(',', $attr_val) . '"';
            }else{
                $attrStr .= ' ' . $key . '="' . $attr_val . '"';
            }
        }
        $html = '<label class="' . $label_class . '">'.($type->getRequired()?'<span class="required">*</span>':'').$attribute->getName().'(' . __($type->getName()) . ')</label>
<select name="' . $type->getCode() . '" ' . $attrStr . '>';
        foreach ($options as $key => $v) {
            if ((is_array($value) and in_array($key,$value)) || $value == $key) {
                $html .= '<option value="' . $key . '" selected>' . $v . '</option>';
                continue;
            }
            $html .= '<option value="' . $key . '">' . $v . '</option>';
        }
        $html .= '</select>';
        return $html;
    }

    public function getModelData():mixed
    {
        return [
            '1' => __('默认选项1'),
            '0' => __('默认选项2'),
        ];
    }
}