<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;


class ContactController extends Controller
{
    public function index()
    {
        $data = [
            'site_name' => Setting::where('key', 'site_name')->value('value'),
            'site_logo' => Setting::where('key', 'site_logo')->value('value'),
            'about_us' => Setting::where('key', 'about_us')->value('value'),
            'contact_email' => Setting::where('key', 'contact_email')->value('value'),
            'contact_phone' => Setting::where('key', 'contact_phone')->value('value'),
            'contact_address' => Setting::where('key', 'contact_address')->value('value'),
            'social_facebook' => Setting::where('key', 'social_facebook')->value('value'),
            'social_instagram' => Setting::where('key', 'social_instagram')->value('value'),
            'social_twitter' => Setting::where('key', 'social_twitter')->value('value'),
        ];

        return view('pages.about', $data)->with(['title' => 'About Us']);
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string', // Sesuai dengan yang dikirim dari form
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'user_message' => $request->message, // Ganti nama variabel
        ];

        Mail::send('emails.contact', ['data' => $data], function ($mail) use ($request) {
            $adminEmail = Setting::get('contact_email', 'Admin@jasaamanahberkah.com');
            $mail->to($adminEmail)
                ->subject('New Idea Submission from ' . $request->name)
                ->replyTo($request->email);
        });

        return back()->with('success', 'Your idea has been sent successfully!');
    }
}
