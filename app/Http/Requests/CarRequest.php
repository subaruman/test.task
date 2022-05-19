<?php

namespace App\Http\Requests;

use App\Http\Requests\Api\ApiFormRequest;
use App\Models\{Car, User};

/**
 * @OA\Schema()
 *     title="CarRequest",
 *     description="Car request validation",
 *     required={"brand", "model", "year_issue"},
 */
class CarRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    /**
     * @OA\Property(
     *      description="Автомобильная марка",
     *      property="brand",
     *      type="string",
     *      default="Subaru",
     *      enum={"BMW", "Mersedes", "Audi", "Subaru", "Mitsubishi", "Nissan"},
     *  ),
     * @OA\Property(
     *      description="Модель автомобиля",
     *      property="model",
     *      type="string",
     *      default="Impreza WRX STI",
     *      enum={"E39", "E46", "C63", "Quattro S1", "R8", "Impreza WRX STI", "Legacy", "Lancer IX Evolution", "Lancer X", "Skyline GTR R34"}
     *  ),
     * @OA\Property(
     *      description="Год выпуска",
     *      property="year_issue",
     *      type="integer",
     *      example=2007,
     *      default=1997,
     *  )
     * @OA\Property(
     *      description="Id пользователя, владеющий автомобилем",
     *      property="user_id",
     *      type="integer",
     *      default=1,
     *  )
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
