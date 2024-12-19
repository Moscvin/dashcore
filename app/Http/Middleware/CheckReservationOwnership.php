<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckReservationOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $reservation = $request->route('coreReservation');


        if (!$reservation) {
            return $next($request);
        }

        if ($reservation->core_user_id !== auth()->id()) {
            return redirect()->route('core_reservations.index')->with('error', 'Reservation not found or access denied.');
        }

        return $next($request);
    }
}
