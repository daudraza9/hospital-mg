<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Rules\UpperCaseRule;
use App\Rules\EmailRule;

class StoreDoctorRequest extends FormRequest
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
            //
            'first_name' => ['required','regex:/^[a-zA-Z]+$/u','unique:doctors','min:3','max:10'],
            'last_name' => ['required','regex:/^[a-zA-Z]+$/u','unique:doctors','min:3','max:10'],
            'email' => ['bail','required','unique:doctors','email',new EmailRule],
            'phone' => ['required','min:10'],
            'title' => ['required'],
            'address' => ['required'],
            'experience' => ['required']
        ];

    }
    public function messages()
    {
         return[
           'first_name.required'=>'First Name must be required',
           'first_name.min'=>'First Name must be of 3 character',
           'first_name.max'=>'First Name have no more than 10 character',
           'last_name.required'=>'Last Name is required',
           'last_name.min'=>'Last Name must be of 3 character',
           'last_name.max'=>'Last Name have no more than 10 character',
           'email.required'=>'Email must be required',
           'phone.required'=> 'Phone must be required',
           'title.required'=>'Title must be required',
           'address.required'=>'Address must be required',
           'experience.required'=>'Experience must be required',
         ];
    }
}
