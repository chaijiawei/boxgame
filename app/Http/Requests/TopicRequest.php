<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TopicRequest extends FormRequest
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
        return [
            'title' => ['required', 'string', 'min:1', 'max:255'],
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'content' => ['required', 'string', 'min:3'],
        ];
    }

    public function attributes()
    {
        return [
            'title' => '标题',
            'category_id' => '分类',
            'content' => '话题内容',
        ];
    }
}
