<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditAccount;
use App\Http\Requests\LoginUser;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\updateUserRequest;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['loginPage', 'login', 'registerUserPage', 'registerUser'
            , 'logout']);
    }

    public function home()
    {
        $posts = Post::latest()->get();
        return view('home', compact('posts'));
    }

    public function hashTag($hashTag)
    {
        $posts = Post::where('body', 'LIKE', '%'.$hashTag.'%')->get();
        return view('home', compact('posts'));
    }

    public function loginPage()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            return view('login');
        }
    }

    public function login(LoginUser $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('home');
        } else {
            return redirect()->back()->with(['message_err' => 'Invalid Email or Password!']);
        }
    }

    public function registerUserPage()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            return view('users.register');
        }
    }

    public function registerUser(StoreUserRequest $request)
    {
        $path = Storage::disk('public')->put('users', $request->file('image'));
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'type' => 'USER',
            'image' => $path
        ]);

        return redirect()->route('login')->with(['message' => 'Your Account successfully created!']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function viewAccount()
    {
        if (Auth::user()->type != "USER") {
            return redirect()->back();
        }
        $user = Auth::user();
        return view('users.account', compact('user'));
    }

    public function editAccount(EditAccount $request, User $user)
    {
        if (Auth::user() != $user) {
            return redirect()->back();
        }
        $path = $user->image;
        // check if request has file
        if ($request->hasFile('image')) {
            // check if file exists
            $exists = Storage::disk('public')->exists($user->image);
            if ($exists) {
                // delete old image
                Storage::disk('public')->delete($user->image);
                // move new image
                $path = Storage::disk('public')->put('users', $request->file('image'));
            }
        }

        $password = $user->password;
        if ($request->password != null) {
            $password = bcrypt($request->password);
        }
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'password' => $password,
            'image' => $path
        ]);
        return redirect()->back()->with(['message' => 'Your Account successfully updated!']);
    }

    public function index()
    {
        if (Auth::user()->type != "ADMIN") {
            return redirect()->back();
        }
        $users = User::where('type', 'USER')->get();
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        if (Auth::user()->type != 'ADMIN') {
            return redirect()->back();
        }

        return view('users.update', compact('user'));
    }

    public function profile(User $user)
    {
        if ($user->type == 'ADMIN') {
            return redirect()->back();
        }

        return view('users.profile', compact('user'));
    }

    public function update(User $user, updateUserRequest $request)
    {
        if (Auth::user()->type != 'ADMIN') {
            return redirect()->back();
        }
        if ($request->password == '') {
            $password = $user->password;
        } else {
            $password = bcrypt($request->password);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $password
        ]);

        return redirect()->route('listUsers')->with(['message' => 'User Successfully Updated!']);
    }

    public function destroy(User $user)
    {
        if (Auth::user()->type != 'ADMIN') {
            return redirect()->back();
        }
        $user->posts()->delete();
        $user->comments()->delete();
        // check if file exists
        $exists = Storage::disk('public')->exists($user->image);
        if ($exists) {
            // delete old image
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();
        return redirect()->route('listUsers')->with(['message' => 'User Successfully deleted!']);

    }
}
