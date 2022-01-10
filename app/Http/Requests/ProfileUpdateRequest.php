<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            "firstName"                             => "required",
            "lastName"                              => "required",
            "workExperiences.*"                     => "required|array|min:1",
            "workExperiences.*.comapnyName"         => "required",
            "workExperiences.*.role"                => "required",
            "workExperiences.*.startedAt"           => "required|date_format:d-m-Y",
            "workExperiences.*.endAt"               => "required_if:workExperiences.*.endAtCurrentWorking,false",
            "workExperiences.*.endAtCurrentWorking" => "required|boolean",
            "workExperiences.*.description"         => ["required", new MaxWordsRule(300, 'work experience description')],
            "organizations.*"                       => "required|array|min:1",
            "organizations.*.name"                  => "required",
            "organizations.*.associatedAs"          => "required",
            "organizations.*.startedAt"             => "required|date_format:d-m-Y",
            "organizations.*.endAt"                 => "required_if:organizations.*.endAtCurrentWorking,false",
            "organizations.*.endAtCurrentWorking"   => "required|boolean",
            "organizations.*.description"           => ["required", new MaxWordsRule(100, 'organization description')],
        ];
    }

    /**
     * get error message for given field and validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            "organizations.*.associatedAs.required_unless" => "Organization associated as field is required",
            "organizations.*.startedAt.required_unless"    => "Organization started at field is required",
            "organizations.*.endAt.required_unless"        => "Organization end at field is required",
            "organizations.*.description.required_unless"  => "Organization description As field is required",
        ];
    }
}
