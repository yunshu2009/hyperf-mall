<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

class PmsProductCategoryRequest extends FormRequest
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
            'parent_id'         =>  'required',
            'name'              =>  'required',
            'nav_status'        =>  Rule::in([0, 1]),
            'show_status'       =>  Rule::in([0, 1]),
            'sort'              =>  'min:0',
            'product_attribute_id_list'    =>  'array'
        ];
    }
}
