<?php

namespace App\Observers;

use App\Models\Car;

class CarObserver
{
    /**
     * Handle the Car "saved" event.
     **/
    public function saved(Car $car)
    {
        if ($car->user_id) {
            $car->resetUserId($car->user_id, $car->id);
        }
    }
}
