<?php
namespace App\Http\Requests;

use App\Http\Controllers\GameController;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterUserByAdminRequest
 *
 */
class RegisterUserByAdminRequest extends FormRequest
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
            'username' => 'required|string|max:255|unique:users,username',            
            'password' => 'required|string'
        ];
    }
}