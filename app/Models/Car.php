<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Car extends Model
{
    use HasFactory;

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
