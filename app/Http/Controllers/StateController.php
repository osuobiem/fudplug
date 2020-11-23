<?php

namespace App\Http\Controllers;

use App\Area;
use App\State;
use Illuminate\Support\Facades\Log;

class StateController extends Controller
{
    /**
     * Get states
     * @param null
     */
    public function get($area_id = null)
    {
        try {
            if (!empty($area_id)) {
                // Fetch User State
                $user_state = Area::where('id', $area_id)->first('state_id');

                return response()->json([
                    'user_state' => $user_state,
                ]);
            } else {
                return response()->json([
                    'states' => State::get(),
                ]);
            }
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'status' => 500, 'message' => $th->getMessage()]);
        }
    }
}
