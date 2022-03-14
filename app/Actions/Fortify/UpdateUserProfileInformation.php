<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Illuminate\Support\Facades\Session;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'path_image' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];

        if (! empty($input['pills']) && $input['pills'] == 'bank') {
            $rules = [
                'bank_id' => [
                    'required',
                    'exists:bank,id',
                    Rule::unique('bank_user')->where(function ($query) use ($input) {
                        return ! $query->where('user_id', auth()->id())
                                       ->where('bank_id', $input['bank_id']);
                    })
                ],
                'account' => 'required|unique:bank_user,account',
                'name' => 'required',
                'is_main' => [
                    'nullable',
                    Rule::unique('bank_user')->where(function ($query) use ($input) {
                        $countAvailable = $query->where('user_id', auth()->id())
                            ->where('is_main', 1)
                            ->count();

                        if ($input['is_main'] == 1 && $countAvailable > 0) {
                            return false;
                        }

                        return true;
                    })
                ]
            ];
        }

        $validated = Validator::make($input, $rules, [
            'is_main.unique' => 'Akun utama sudah ada sebelumnya.'
        ]);

        if ($validated->fails()) {
            return back()
                ->withInput()
                ->withErrors($validated->errors());
        }

        if (isset($input['path_image'])) {
            $input['path_image'] = upload('user', $input['path_image'], 'user');
        }

        $user->update($input);

        if (! empty($input['pills']) && $input['pills'] == 'bank') {
            $user->bank_user()->attach($input['bank_id'], [
                'account' => $input['account'],
                'name' => $input['name'],
                'is_main' => $input['is_main'] ?? 0
            ]);
        }

        Session::flash('message', 'Profil berhasil diperbarui');
        Session::flash('success', true);
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
