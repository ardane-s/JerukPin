<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Send email to admin
        try {
            Mail::raw(
                "Pesan Kontak Baru dari Website JerukPin\n\n" .
                "Nama: {$validated['name']}\n" .
                "Email: {$validated['email']}\n" .
                "Subjek: {$validated['subject']}\n\n" .
                "Pesan:\n{$validated['message']}",
                function ($message) use ($validated) {
                    $message->to('info@jerukpin.com')
                        ->subject('Pesan Kontak: ' . $validated['subject'])
                        ->replyTo($validated['email'], $validated['name']);
                }
            );

            return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim. Kami akan membalas sesegera mungkin.');
        } catch (\Exception $e) {
            return back()->with('error', 'Maaf, terjadi kesalahan. Silakan coba lagi atau hubungi kami via WhatsApp.');
        }
    }
}
