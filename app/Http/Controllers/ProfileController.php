<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail(Auth::user()->id);
        Validator::make($request, [
            'avatar' => ['bail', 'string'],
            'birthDate' => ['required', 'timestamp'],
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

        $this->uploadImage($request);

        if (
            $request['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $request->all());
        } else {
            $user->forceFill([
                'avatar' => $request['avatar'],
                'birth_date' => $request['birthDate'],
                'email' => $request['email'],
                'first_name' => $request['firstName'],
                'gender' => $request['gender'],
                'ID_document' => $request['IDDocument'],
                'last_name' => $request['lastName'],
                'occupation' => $request['occupation'],
                'phone' => $request['phone']
            ])->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $request
     */
    protected function updateVerifiedUser(User $user, array $request): void
    {
        $user->forceFill([
            'avatar' => $request['avatar'],
            'birth_date' => $request['birthDate'],
            'email' => $request['email'],
            'email_verified_at' => null,
            'first_name' => $request['firstName'],
            'gender' => $request['gender'],
            'ID_document' => $request['IDDocument'],
            'last_name' => $request['lastName'],
            'occupation' => $request['occupation'],
            'phone' => $request['phone']
        ])->save();

        $user->sendEmailVerificationNotification();
    }

    protected function uploadImage(Request $request): string {
        if ($request->file()) {
            $resp = Storage::put('storage/id-pics', $request->file, 'public');
            return $resp;
        } else {
            return $request->images;
        }
    }
}
