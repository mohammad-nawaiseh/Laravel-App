<?php

// api.php

use Illuminate\Http\Request;
use App\Http\Controllers\OrderController;

Route::middleware('api')->group(function () {
    Route::resource('order', OrderController::class)->only(['index','store','show','update','destroy']);
});
