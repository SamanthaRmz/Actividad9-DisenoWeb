<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;
use Illuminate\Support\Facades\Mail; 
use App\Mail\WelcomeMail;


class RegisterController extends Controller
{

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users', 'email')->where(function ($query) use ($data) {
                    return $query->where('email', $data['email']);
                }),
                function ($attribute, $value, $fail) {
                    $validator = new EmailValidator();
                    if (!($validator->isValid($value, new RFCValidation()) && checkdnsrr(explode('@', $value)[1], 'MX'))) {
                        $fail('El correo electrónico no es válido o no existe.');
                    }
                },
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    
        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
    
            // Envía un correo electrónico de bienvenida al usuario registrado
            Mail::to($user->email)->send(new WelcomeMail($user));
    
            return $user;
        } catch (\Exception $e) {
            // Maneja el error de alguna manera
            dd($e->getMessage());
        }
    }
}
