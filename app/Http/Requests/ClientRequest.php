<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ClientRequest extends ParentRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => Rule::unique('clients')->where(function($query){
                return $query->where('consultant_id', auth()->user()->id);
            }),
            'phone' => Rule::unique('clients')->where(function($query){
                return $query->where('consultant_id', auth()->user()->id);
            }),
            'address' => 'required|string',
            'registered_address' => 'required|string',
            'is_public_entity'=> 'required|integer',
            'nature_of_business' => 'required|string',
            'doubts' => 'required|string',

            'directors' => 'required|array',
            'directors.*' => 'required|array',
            'directors.*.name' => 'required|string',
            'directors.*.units_held' => 'required|integer',
            'directors.*.designation' => 'required|string',

            'is_part_of_group' => 'required|integer',

            'subsidiaries' => 'exclude_if:is_part_of_group,0|required|array',
            'subsidiaries.*' => 'exclude_if:is_part_of_group,0|required|array',
            'subsidiaries.*.name' => 'exclude_if:is_part_of_group,0|required|string',
            'subsidiaries.*.percentage_holding' => 'exclude_if:is_part_of_group,0|required|integer',
            'subsidiaries.*.nature' => 'exclude_if:is_part_of_group,0|required|string',
            'subsidiaries.*.nature_of_business' => 'exclude_if:is_part_of_group,0|required|string'
        ];
    }
}
