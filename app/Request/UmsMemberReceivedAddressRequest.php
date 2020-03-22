<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class UmsMemberReceivedAddressRequest extends FormRequest
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
            'name'           => 'required',
            'phoneNumber'   => 'required',
//            'post_code'      => 'required',
            'province'       => 'required',
            'city'           => 'required',
            'region'         => 'required',
            'detailAddress' => 'required',
        ];
    }
}