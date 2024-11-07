<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Str;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $this->rateLimitLogin($request);  

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();  
            RateLimiter::clear($this->throttleKey($request));  
            return redirect()->intended('dashboard')->withSuccess('Signed in');
        }

        return redirect("login")->withErrors(['emailPassword' => 'Email address or password is incorrect.']);
    }


    protected function rateLimitLogin(Request $request)
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            throw ValidationException::withMessages([
                'email' => ['Too many login attempts. Please try again in ' . RateLimiter::availableIn($this->throttleKey($request)) . ' seconds.'],
            ]);
        }

        RateLimiter::hit($this->throttleKey($request), 60); 
    }

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function customRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect("login")->withErrors(['session' => 'Your session has expired. Please log in again.']);
        }
        $user = Auth::user();
        return view('dashboard.index', compact('user'));
    }

    public function signOut() {
        Session::flush();
        Auth::logout();
        Session::regenerate(); 
    
        return redirect()->route('login')->with('status', 'You have been successfully logged out.');
    }
    
}
