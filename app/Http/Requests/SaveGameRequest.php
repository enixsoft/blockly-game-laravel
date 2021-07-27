<?php
namespace App\Http\Requests;

use App\Http\Controllers\GameController;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SaveGameRequest
 *
 */
class SaveGameRequest extends FormRequest
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
            'category' => 'required|numeric|min:1|max:' . sizeof(GameController::LEVELS_PER_CATEGORY),
            'level' => 'required|numeric|min:1|max:' . GameController::LEVELS_PER_CATEGORY[$this->input('category') - 1],
            'progress' => 'required|numeric|min:0|max:100',
            'json' => 'required|json'
        ];
    }

}