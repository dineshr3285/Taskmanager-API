<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\FormRequest;

class TaskRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (app('request')->route()->getName() == "tasks.index") {
            return [
                'status' => [
                    'nullable',
                    'in:0,1'
                ],
                'direction' => [
                    'nullable',
                    'in:asc,desc',
                ],
                'page_limit' => [
                    'nullable',
                    'in:' . implode(',', config('app.pagination.list')),
                ],
            ];
        }
        else if (
            (app('request')->route()->getName() == "tasks.store")
            || (app('request')->route()->getName() == "tasks.update")
        ) {
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'max:255',
                ],
                'description' => [
                    'nullable',
                    'string',
                ]
            ];
        }
        else if (app('request')->route()->getName() == "tasks.change-status") {
            return [
                'id' => [
                    'required',
                ],
                'status' => [
                    'required',
                    'in:0,1'
                ]
            ];
        }
        else {
            return [];
        }
    }

}
