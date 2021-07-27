<?php
namespace App\Http\Requests;

use App\Http\Controllers\GameController;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LogGameplayRequest
 *
 */
class LogGameplayRequest extends FormRequest
{
    const resultTypes = [
        'mainTaskCompleted',
        'mainTaskFailed',
        'dizzy',
        'death',
        'zerosteps',
        'stoppedExecution',
        'functionerror'
    ];
    
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
            'level_start' => 'required|date_format:H:i:s',
            'task' => 'required|numeric|min:0',
            'task_start' => 'required|date_format:H:i:s',
            'task_end' => 'nullable|date_format:H:i:s',
            'task_elapsed_time' => 'required|numeric|min:0', 
            'rating' => 'required|numeric|min:0|max:5', 
            'code' => 'required|string',
            'result' => 'required|string|in:' . implode(',', static::resultTypes)
        ];
    }
}