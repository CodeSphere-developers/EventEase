<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register | EventEase</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-300 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-2xl rounded-2xl p-10 w-full max-w-lg border-t-8 border-blue-700">
        <div class="flex flex-col items-center mb-6">
            <div class="bg-blue-700 text-white rounded-full w-16 h-16 flex items-center justify-center text-3xl font-bold mb-2 shadow-lg">EE</div>
            <h2 class="text-3xl font-extrabold text-blue-900 mb-1">Create Account</h2>
            <p class="text-gray-500 text-sm">Join EventEase to discover and register for events!</p>
        </div>
        <form action="/register" method="POST" class="space-y-4">
            @csrf
            <div class="flex gap-3">
                <div class="w-1/2">
                    <label class="block text-sm font-bold text-gray-700 mb-1">First Name</label>
                    <input type="text" name="firstname" required class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="First Name">
                </div>
                <div class="w-1/2">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="lastname" required class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Last Name">
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                <input type="text" name="email" required pattern="[a-zA-Z]+\.[a-zA-Z]+@strathmore\.edu" placeholder="first.lastname@strathmore.edu" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <span class="text-xs text-gray-500">Use your Strathmore email (first.lastname@strathmore.edu)</span>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required minlength="6" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••">
                @error('password')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
                <span class="text-xs text-gray-500 block">Password must be at least 6 characters.</span>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required minlength="6" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Repeat Password">
                @if($errors->has('password'))
                    <span class="text-xs text-red-600">Passwords must match.</span>
                @endif
            </div>
            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 rounded transition shadow">Sign Up</button>
        </form>
        <p class="mt-6 text-center text-sm text-gray-600">
            Have an account? <a href="/login" class="text-blue-700 font-bold hover:underline">Login</a>
        </p>
    </div>
</body>
</html>