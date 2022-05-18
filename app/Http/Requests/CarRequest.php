<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\ApiFormRequest;
use App\Models\{Car, User};

class CarRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'brand' => 'required|in:' . implode(',', Car::BRANDS),
            'model' => 'required|in:' . implode(',', Car::MODELS),
            'year_issue' => 'required|int',
            'user_id' => 'int|exists:' . (new User())->getTable() . ',id',
        ];
    }
}
