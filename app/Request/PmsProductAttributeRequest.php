<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

class PmsProductAttributeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'product_attribute_category_id'    =>   'required',
            'name'                             =>   'required',
            'select_type'                      =>   [Rule::in([0, 1, 2])],
            'input_type'                       =>   [Rule::in([0, 1])],
            'filter_type'                      =>   [Rule::in([0, 1])],
            'search_type'                      =>   [Rule::in([0, 1, 2])],
            'related_status'                   =>   [Rule::in([0, 1])],
            'hand_add_status'                  =>   [Rule::in([0, 1])],
            'type'                             =>   [Rule::in([0, 1])],
        ];
    }

    /**
     * 获取已定义验证规则的错误消息
     */
    public function messages(): array
    {
        return [
            'product_attribute_category_id.required' => '属性分类不能为空',
            'name.required'  => '属性名称不能为空',
        ];
    }
}
