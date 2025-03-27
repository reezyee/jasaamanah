<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $settings = Setting::pluck('value', 'key')->toArray();
            return view('pages.admin.settings', compact('user', 'settings'))->with(['title' => 'Settings']);
        } elseif ($user->role === 'worker') {
            return view('pages.worker.settings', compact('user'))->with(['title' => 'Settings']);
        }
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Update data user
        $user->fill([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);

        // Jika ada avatar baru, hapus yang lama dan simpan yang baru
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }

            // Simpan avatar baru
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->save();

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('settings.index')->with('success', 'Profil berhasil diperbarui.');
        } elseif ($user->role === 'worker') {
            return redirect()->route('worker.settings.index')->with('success', 'Profil berhasil diperbarui.');
        } else {
            return redirect()->route('user.settings.index')->with('success', 'Profil berhasil diperbarui.');
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->update(['password' => Hash::make($request->new_password)]);

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()->route('settings.index')->with('success', 'Password berhasil diperbarui.');
        } elseif ($user->role === 'worker') {
            return redirect()->route('worker.settings.index')->with('success', 'Password berhasil diperbarui.');
        } else {
            return redirect()->route('user.settings.index')->with('success', 'Password berhasil diperbarui.');
        }
    }

    public function updateWebsiteSettings(Request $request)
    {
        // Hanya admin yang bisa mengakses
        $this->authorize('update', Setting::class);

        $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:15',
            'contact_address' => 'required|string|max:255',
            'about_us' => 'nullable|string',
            'social_facebook' => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'social_twitter' => 'nullable|url',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('site_logo')) {
            // Hapus logo lama jika ada
            $oldLogo = Setting::where('key', 'site_logo')->first();
            if ($oldLogo && $oldLogo->value && Storage::exists('public/' . $oldLogo->value)) {
                Storage::delete('public/' . $oldLogo->value);
            }

            $logoPath = $request->file('site_logo')->store('logos', 'public');
            Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $logoPath]);
        }

        $settingsData = $request->except('_token', 'site_logo');
        foreach ($settingsData as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('settings.index')->with('success', 'Pengaturan website berhasil diperbarui.');
    }
}
