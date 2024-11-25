@extends('layout')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
        <form class="max-w-sm mx-auto" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label for="username" class="form-label">Your Username</label>
                <input type="text" id="username" name="username" class="text-form" placeholder="yourusername"
                    required />
            </div>
            <div class="mb-5">
                <label for="password" class="form-label">Your Password</label>
                <input type="password" id="password" name="password" class="text-form" required />
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
        </form>
    </div>
</div>
@endsection