<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingCreateValidation;
use App\Services\BookingService;

class BookingController extends Controller
{
    /**
     * @param BookingService $service
     */
    public function __construct(
        private BookingService $service
    ){}

    /**
     * Yeni bir rezervasyon oluştur.
     */
    public function store(BookingCreateValidation $request)
    {
        $data = $request->validated();


        try {
            $booking = $this->service->create($data['event_id']);
            return response()->json(['message' => 'Etkinlik başarıyla rezerve edildi!', 'booking' => $booking], 201);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $booking = $this->service->delete($id);
            return response()->json(['message' => 'Etkinlik başarıyla silindi!', 'booking' => $booking], 201);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json(['message' => $e->getMessage()], 403);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }
}
