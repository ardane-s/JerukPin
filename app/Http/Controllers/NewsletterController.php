<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        try {
            // Check if already subscribed
            $exists = DB::table('newsletter_subscribers')
                ->where('email', $validated['email'])
                ->exists();

            if ($exists) {
                return back()->with('info', 'Email Anda sudah terdaftar di newsletter kami.');
            }

            // Insert new subscriber
            DB::table('newsletter_subscribers')->insert([
                'email' => $validated['email'],
                'subscribed_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('success', 'Berhasil! Anda akan menerima update promo dan produk terbaru.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}
