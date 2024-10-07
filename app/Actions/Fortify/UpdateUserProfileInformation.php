<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
    {
        // return response()->json($input);
        $this->showInput($input);
        Validator::make($input, [
            'avatar' => ['bail', 'string'],
            'birthDate' => ['required', 'string'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'firstName' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string'],
            'IDDocument' => ['bail', 'string'],
            'lastName' => ['required', 'string', 'max:255'],
            'occupation' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:255'],
        ])->validateWithBag('updateProfileInformation');

        $input['id_document'] = $this->uploadImage($user, $input);

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                // 'avatar' => $input['avatar'],
                'birth_date' => $input['birthDate'],
                'email' => $input['email'],
                'first_name' => $input['firstName'],
                'gender' => $input['gender'],
                'ID_document' => $input['id_document'],
                'last_name' => $input['lastName'],
                'occupation' => $input['occupation'],
                'phone' => $input['phone']
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            // 'avatar' => $input['avatar'],
            'birth_date' => $input['birthDate'],
            'email' => $input['email'],
            'email_verified_at' => null,
            'first_name' => $input['firstName'],
            'gender' => $input['gender'],
            'ID_document' => $input['id_document'],
            'last_name' => $input['lastName'],
            'occupation' => $input['occupation'],
            'phone' => $input['phone']
        ])->save();

        $user->sendEmailVerificationNotification();
    }

    protected function uploadImage(User $user, array $input): string {
        if (isset($input['file'])) {
            $resp = Storage::putFileAs('storage/id-pics', $input['file'], str_replace(' ', '', "$user->id-$user->full_name.jpg"));
            // $resp = Storage::put('storage/id-pics', $input['file'], 'public');
            return $resp;
        } else {
            return $input['IDDocument'];
        }
    }

    private function showInput(array $input) {
        return response()->json($input);
    }
}
