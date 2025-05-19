<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;


class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'website_id' => 'required|exists:websites,id'
        ]);

        $subscriber = Subscriber::firstOrCreate(['email' => $request->email]);
        $subscriber->websites()->syncWithoutDetaching([$request->website_id]);

        return response()->json(['message' => 'Subscribed successfully']);
    }
}
