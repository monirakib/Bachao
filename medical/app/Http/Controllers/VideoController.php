<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    public function generateToken(Request $request)
    {
        try {
            // Validate the request
            if (!$request->has('roomName')) {
                return response()->json(['error' => 'Room name is required'], 400);
            }

            // Check if Twilio credentials are configured
            if (!env('TWILIO_ACCOUNT_SID') || !env('TWILIO_API_KEY') || !env('TWILIO_API_SECRET')) {
                return response()->json(['error' => 'Twilio credentials are not properly configured'], 500);
            }

            // Create access token with Twilio SDK
            $token = new AccessToken(
                env('TWILIO_ACCOUNT_SID'),
                env('TWILIO_API_KEY'),
                env('TWILIO_API_SECRET'),
                3600,
                $request->user()->email // Use email as the identity
            );

            // Room name is already prefixed with consultation_ from the client
            $roomName = $request->roomName;
            
            // Log room name for debugging
            Log::info('Creating video room:', ['roomName' => $roomName]);
            
            // Create Video grant
            $videoGrant = new VideoGrant();
            $videoGrant->setRoom($roomName);
            
            // Add grant to token
            $token->addGrant($videoGrant);

            try {
                // Create Twilio client
                $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
                
                // Try to fetch the room first
                try {
                    $room = $twilio->video->v1->rooms($roomName)->fetch();
                    Log::info('Room exists:', ['roomName' => $roomName, 'status' => $room->status]);
                } catch (\Exception $e) {
                    // Room doesn't exist, create it
                    if (strpos($e->getMessage(), 'Unable to fetch record') !== false) {
                        $room = $twilio->video->v1->rooms->create([
                            'uniqueName' => $roomName,
                            'type' => 'group',
                            'maxParticipants' => 2
                        ]);
                        Log::info('Room created:', ['roomName' => $roomName]);
                    } else {
                        throw $e;
                    }
                }

                return response()->json([
                    'token' => $token->toJWT(),
                    'roomName' => $roomName
                ]);            } catch (\Exception $e) {
                Log::error('Twilio room error:', [
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ]);

                // Check for common connection issues
                if (strpos($e->getMessage(), 'Could not resolve host') !== false) {
                    // DNS resolution failed
                    return response()->json([
                        'error' => 'Unable to connect to Twilio services. Please check your internet connection.'
                    ], 500);
                }

                if (strpos($e->getMessage(), 'cURL error 6') !== false) {
                    // DNS lookup failed
                    return response()->json([
                        'error' => 'Network connectivity issue. Please check your internet connection and DNS settings.'
                    ], 500);
                }

                if (strpos($e->getMessage(), 'cURL error 7') !== false) {
                    // Failed to connect
                    return response()->json([
                        'error' => 'Failed to connect to Twilio services. Please check your firewall settings.'
                    ], 500);
                }

                return response()->json([
                    'error' => 'Failed to setup video room: ' . $e->getMessage()
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Token generation error:', ['error' => $e->getMessage()]);
            return response()->json([
                'error' => 'Failed to generate token: ' . $e->getMessage()
            ], 500);
        }
    }
}