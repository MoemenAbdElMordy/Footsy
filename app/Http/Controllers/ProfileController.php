<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        /** @var User $user */
        $user = auth()->user();
        $addresses = Address::where('user_id', $user->id)->latest()->get();

        return view('pages.profile.show', compact('addresses'));
    }

    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.show')->with('success', 'Password updated successfully.');
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
            'is_default' => 'nullable|boolean',
        ]);

        /** @var User $user */
        $user = auth()->user();

        DB::transaction(function () use ($user, $validated) {
            $isDefault = (bool) ($validated['is_default'] ?? false);

            if ($isDefault) {
                Address::where('user_id', $user->id)->update(['is_default' => false]);
            }

            Address::create([
                'user_id' => $user->id,
                'label' => $validated['label'] ?? null,
                'full_name' => $validated['full_name'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip_code' => $validated['zip_code'],
                'phone' => $validated['phone'],
                'is_default' => $isDefault,
            ]);
        });

        return redirect()->route('profile.show')->with('success', 'Address added successfully.');
    }

    public function updateAddress(Request $request, Address $address)
    {
        /** @var User $user */
        $user = auth()->user();
        if ((int) $address->user_id !== (int) $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
            'is_default' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($address, $user, $validated) {
            $isDefault = (bool) ($validated['is_default'] ?? false);

            if ($isDefault) {
                Address::where('user_id', $user->id)->update(['is_default' => false]);
            }

            $address->update([
                'label' => $validated['label'] ?? null,
                'full_name' => $validated['full_name'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip_code' => $validated['zip_code'],
                'phone' => $validated['phone'],
                'is_default' => $isDefault,
            ]);
        });

        return redirect()->route('profile.show')->with('success', 'Address updated successfully.');
    }

    public function destroyAddress(Address $address)
    {
        /** @var User $user */
        $user = auth()->user();
        if ((int) $address->user_id !== (int) $user->id) {
            abort(403);
        }

        DB::transaction(function () use ($address, $user) {
            $wasDefault = (bool) $address->is_default;
            $address->delete();

            if ($wasDefault) {
                $fallback = Address::where('user_id', $user->id)->latest()->first();
                if ($fallback) {
                    $fallback->update(['is_default' => true]);
                }
            }
        });

        return redirect()->route('profile.show')->with('success', 'Address deleted successfully.');
    }

    public function setDefaultAddress(Address $address)
    {
        /** @var User $user */
        $user = auth()->user();
        if ((int) $address->user_id !== (int) $user->id) {
            abort(403);
        }

        DB::transaction(function () use ($address, $user) {
            Address::where('user_id', $user->id)->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        });

        return redirect()->route('profile.show')->with('success', 'Default address updated.');
    }
}
