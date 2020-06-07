<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *      title="Update User Password request",
 *      description="Update User Password request body data",
 * )
 */
class UpdatePasswordRequest extends FormRequest
{
    /**
     * @OA\Property(
     *   title="password"
     * )
     *
     * @var string
     */
    public $password;

    /**
     * @OA\Property(
     *   title="password_confirm"
     * )
     *
     * @var string
     */
    public $password_confirm;


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
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ];
    }
}
