<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwilioCallController extends Controller
{
    public function index()
    {
        return view('twilio.call');
    }

    public function outgoingCall(Request $request)
    {
        $to = $request->input('To');

        return response()->xml(
            '<?xml version="1.0" encoding="UTF-8"?>
            <Response>
                <Dial>' . $to . '</Dial>
            </Response>'
        );
    }
}
