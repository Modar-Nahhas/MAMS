<?php

namespace App\Http\Requests;

use App\Enums\ArticleStatusEnum;
use Illuminate\Validation\Rule;
use Mapi\Easyapi\Requests\BaseRequest;

class ArticleRequest extends BaseRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('get')) {
            return array_merge($this->getRules, [
                'with_comments' => ['sometimes', 'boolean'],
                'with_reviewer' => ['sometimes', 'boolean'],
                'with_approvedBy' => ['sometimes', 'boolean'],
                'with_user' => ['sometimes', 'boolean'],
                'where_status' => ['sometimes', Rule::in(ArticleStatusEnum::values())],
            ]);
        } elseif ($this->isMethod('post')) {
            return array_merge($this->postRules, [
                'title' => ['required', 'string', 'max:512'],
                'content' => ['required', 'string']
            ]);
        } elseif ($this->isMethod('put')) {
            return array_merge($this->putRules, [
                'title' => ['sometimes', 'string', 'max:512'],
                'content' => ['sometimes', 'string']
            ]);
        }
        return [];
    }
}
