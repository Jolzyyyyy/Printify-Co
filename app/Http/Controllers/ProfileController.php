<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Rules\PhilippineMobileNumber;
use App\Services\PhilippinePhoneNumber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

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
    public function update(ProfileUpdateRequest $request): RedirectResponse|JsonResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        $fullName = trim((string) ($validated['name'] ?? ''));
        $firstName = trim((string) ($validated['first_name'] ?? ''));
        $lastName = trim((string) ($validated['last_name'] ?? ''));

        if ($fullName !== '' && ($firstName === '' && $lastName === '')) {
            $parts = preg_split('/\s+/', $fullName, 2);
            $firstName = $parts[0] ?? '';
            $lastName = $parts[1] ?? '';
        }

        if ($fullName === '') {
            $fullName = trim($firstName.' '.$lastName);
        }

        $profileData = [
            'name' => $fullName ?: null,
            'username' => $this->nullableText($validated['username'] ?? null),
            'first_name' => $firstName ?: null,
            'last_name' => $lastName ?: null,
            'email' => $validated['email'],
            'backup_email' => filled($validated['backup_email'] ?? null)
                ? Str::lower(trim((string) $validated['backup_email']))
                : null,
            'phone' => PhilippinePhoneNumber::normalize($validated['phone'] ?? null),
            'birthdate' => $this->nullableText($validated['birthdate'] ?? null),
            'gender' => $this->nullableText($validated['gender'] ?? null),
            'street' => $this->nullableText($validated['street'] ?? null),
            'barangay' => $this->nullableText($validated['barangay'] ?? null),
            'region' => $this->nullableText($validated['region'] ?? null),
            'province' => $this->nullableText($validated['province'] ?? null),
            'city' => $this->nullableText($validated['city'] ?? null),
            'postal_code' => $this->nullableText($validated['postal_code'] ?? null),
            'company' => $this->nullableText($validated['company'] ?? null),
            'preferences' => $validated['preferences'] ?? $user->preferences,
        ];

        if (! empty($validated['photo_base64']) && str_starts_with($validated['photo_base64'], 'data:image/')) {
            $profileData['profile_photo'] = $validated['photo_base64'];
        }

        $user->fill($profileData);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'message' => 'Profile updated successfully.',
                'user' => $user->fresh(),
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    private function nullableText(mixed $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    public function updateBackupEmail(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validateWithBag('backupEmail', [
            'backup_email' => [
                'nullable',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::notIn([Str::lower((string) $user->email)]),
                Rule::unique(User::class, 'email')->ignore($user->id),
                Rule::unique(User::class, 'backup_email')->ignore($user->id),
            ],
        ]);

        $user->forceFill([
            'backup_email' => filled($validated['backup_email'] ?? null)
                ? Str::lower(trim((string) $validated['backup_email']))
                : null,
        ])->save();

        return Redirect::route('profile.edit')->with('status', 'backup-email-updated');
    }

    public function adminEdit(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if (! $user || ! $user->canAccessAdminPortal()) {
            abort(403, 'Unauthorized access for profile.');
        }

        return view('Admin.dashboard', [
            'section' => 'settings',
            'portalUser' => $user,
        ]);
    }

    public function adminUpdate(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user || ! $user->canAccessAdminPortal()) {
            abort(403, 'Unauthorized access for profile.');
        }

        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'username' => [
                'nullable',
                'string',
                'max:60',
                'alpha_dash:ascii',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'backup_email' => [
                'nullable',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::notIn([Str::lower((string) $user->email)]),
                Rule::unique(User::class, 'email')->ignore($user->id),
                Rule::unique(User::class, 'backup_email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:40', new PhilippineMobileNumber],
            'profile_photo' => ['nullable', 'string'],
        ]);

        $user->fill([
            'name' => $this->nullableText($validated['name'] ?? null),
            'username' => $this->nullableText($validated['username'] ?? null),
            'email' => $validated['email'],
            'backup_email' => filled($validated['backup_email'] ?? null)
                ? Str::lower(trim((string) $validated['backup_email']))
                : null,
            'phone' => PhilippinePhoneNumber::normalize($validated['phone'] ?? null),
        ]);

        if (! empty($validated['profile_photo']) && str_starts_with($validated['profile_photo'], 'data:image/')) {
            $user->profile_photo = $validated['profile_photo'];
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('admin.profile.edit')->with('status', 'profile-updated');
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
