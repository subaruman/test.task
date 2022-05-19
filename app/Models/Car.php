<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Car",
 *     description="Car model",
 *     required={"brand", "model", "year_issue"},
 *     @OA\Xml(
 *         name="Car"
 *     )
 * )
 */
class Car extends Model
{
    use HasFactory;
    /**
     * @OA\Property(
     *     description="ID автомобиля",
     *     example=1,
     *     type="integer",
     * )
     * @OA\Property(
     *      description="Автомобильная марка",
     *      property="brand",
     *      type="string",
     *      enum={"BMW", "Mersedes", "Audi", "Subaru", "Mitsubishi", "Nissan"},
     *  ),
     * @OA\Property(
     *      description="Модель автомобиля",
     *      property="model",
     *      type="string",
     *      enum={"E39", "E46", "C63", "Quattro S1", "R8", "Impreza WRX STI", "Legacy", "Lancer IX Evolution", "Lancer X", "Skyline GTR R34"}
     *  ),
     * @OA\Property(
     *      description="Год выпуска",
     *      property="year_issue",
     *      type="integer",
     *      example={"2007", "1997"},
     *  )
     * @OA\Property(
     *      description="Id пользователя, владеющий автомобилем",
     *      property="user_id",
     *      type="integer",
     *  )
     */

    protected $fillable = [
        'brand',
        'model',
        'year_issue',
        'user_id',
    ];

    const BRAND_BMW = "BMW";
    const BRAND_MERSEDES = "Mersedes";
    const BRAND_AUDI = "Audi";
    const BRAND_SUBARU = "Subaru";
    const BRAND_MITSUBISHI = "Mitsubishi";
    const BRAND_NISSAN = "Nissan";

    const BRANDS = [
        self::BRAND_BMW,
        self::BRAND_MERSEDES,
        self::BRAND_AUDI,
        self::BRAND_SUBARU,
        self::BRAND_MITSUBISHI,
        self::BRAND_NISSAN,
    ];

    const MODELS_BMW = [
        "E39",
        "E46",
    ];

    const MODELS_MERSEDES = [
        "C63",
    ];

    const MODELS_AUDI = [
        "Quattro S1",
        "R8",
    ];

    const MODELS_SUBARU = [
        "Impreza WRX STI",
        "Legacy",
    ];

    const MODELS_MITSUBISHI = [
        "Lancer IX Evolution",
        "Lancer X",
    ];

    const MODELS_NISSAN = [
        "Skyline GTR R34",
    ];

    const MODELS = [
        ...self::MODELS_BMW,
        ...self::MODELS_MERSEDES,
        ...self::MODELS_AUDI,
        ...self::MODELS_SUBARU,
        ...self::MODELS_MITSUBISHI,
        ...self::MODELS_NISSAN,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Remove current user_id from other record
     */
    public function resetUserId(int $userId, int $carId = null): void
    {
        $cars = Car::where('user_id', $userId)->get()->except($carId);

        if ($cars->isNotEmpty()) {
            $cars->each(function ($car) {
                $car->user_id = null;
                $car->save();
            });
        }
    }
}
