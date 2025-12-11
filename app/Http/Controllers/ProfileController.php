<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest; // Kita biarkan baris ini (tidak dipakai tidak apa-apa)
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule; // Tambahan untuk validasi email

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    // PERUBAHAN DI SINI: Kita ganti 'ProfileUpdateRequest' jadi 'Request' biasa
    // supaya kita bisa atur validasinya langsung di sini.
    public function update(Request $request): RedirectResponse
    {
        // 1. VALIDASI LANGSUNG DI SINI (Supaya pasti tersimpan)
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Email wajib unik, TAPI kecualikan email milik user yang sedang login
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($request->user()->id)],
            // 🔥 TAMBAHAN VALIDASI HP 🔥
            // Wajib diisi, harus angka, minimal 10 digit, maksimal 15 digit
            'no_hp' => ['required', 'numeric', 'digits_between:10,15'],
        ]);

        // 2. ISI DATA
        $request->user()->fill($validated);

        // 3. JIKA EMAIL BERUBAH, RESET VERIFIKASI
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // 4. SIMPAN KE DATABASE
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
