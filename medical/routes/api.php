use App\Http\Controllers\AppointmentController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/doctor-slots', [AppointmentController::class, 'getAvailableSlots']);
});