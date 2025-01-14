<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ParseService;
use GuzzleHttp\Client;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'link' => ['required', 'url', 'max:255']
        ]);
        $user = User::create($data);
        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    public function login()
    {
        Log::error("Error parsing URL ");
        return view('user.login');
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        return view('user.dashboard');
    }

    protected $parseService;

    public function __construct(ParseService $parseService)
    {
        $this->parseService = $parseService;
    }

    public function show()
    {
        $this->parseService->processUsers();

        $users = User::all();
        foreach ($users as $user) {
            $user->parsedata = $user->parsedata ? json_decode($user->parsedata, true) : [];
        }
        return view('welcome', compact('users'));
    }
}
