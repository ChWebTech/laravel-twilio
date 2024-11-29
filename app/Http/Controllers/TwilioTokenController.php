<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VoiceGrant;

class TwilioTokenController extends Controller
{
    public function generateToken(Request $request)
    {
        $accountSid = env('TWILIO_SID');
        $apiKey = env('TWILIO_API_KEY');
        $apiSecret = env('TWILIO_API_SECRET');
        $twilioAppSid = env('TWILIO_APP_SID');

        // Create an access token
        $token = new AccessToken(
            $accountSid,
            $apiKey,
            $apiSecret,
            3600 // Token valid for 1 hour
        );

        // Add a Voice Grant
        $voiceGrant = new VoiceGrant();
        $voiceGrant->setOutgoingApplicationSid($twilioAppSid);
        $token->addGrant($voiceGrant);

        return response()->json(['token' => $token->toJWT()]);
    }
}
