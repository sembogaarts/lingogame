<?php

namespace App\Http\Requests;

use App\Helpers\GameHelper;
use App\Helpers\UserHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AttemptRequest extends FormRequest
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

        $user = Auth::user();
        $userHelper = new UserHelper($user);
        $game = $userHelper->getLatestGame();
        $gameHelper = new GameHelper($game);

        return [
            'word' => 'required|size:' . $gameHelper->getWordLength()
        ];
    }
}
