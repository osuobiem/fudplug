<?php

namespace App\Http\Controllers;

use App\SocketData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SocketController extends Controller
{
    /**
     * Save new socket id
     * @param string $username Socket client username
     * @param string $socket_id Socket client id
     * 
     * @return object
     */
    public function save_id($username, $socket_id)
    {
        $socket = SocketData::where('username', $username)->first();

        if (!$socket) {
            $socket = new SocketData();
        }
        $socket->username = $username;
        $socket->socket_id = $socket_id;

        // Try Save
        try {
            $socket->save();

            return response()->json([
                'success' => true,
                'message' => 'Socket ID Saved'
            ]);
        } catch (\Throwable $th) {
            Log::error($th);

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error'
            ], 500);
        }
    }
}
