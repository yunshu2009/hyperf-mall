<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class PmsBrandRequest extends FormRequest
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
            'name'  =>  'required',
            'firstLetter'  =>  'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '品牌不能为空',
            'firstLetter.required' => '品牌名首字母不能为空',
        ];
    }
}
