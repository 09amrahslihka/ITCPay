<?php

namespace App\Http\Requests;

class CardUploadRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'idtype' => 'required',
            'Id_number' => 'required',
            'issuing_authority' => 'required',
            'photo_id' => 'required|mimes:pdf,png,jpeg,jpg,gif,bmp|max:10240',
            'cardfront' => 'required|mimes:pdf,png,jpeg,jpg,gif,bmp|max:10240',
            'cardback' => 'required|mimes:pdf,png,jpeg,jpg,gif,bmp|max:10240',
        ];

        if ($this->input('user_nationality') === 'India') {
            $rules['pan_card_number'] = 'required|alpha_num|size:10';
        }

        return $rules;
    }

    public function messages()
    {
        return ['pan_card_number.alpha_num' => 'Invalid Card Number'];
    }
}
