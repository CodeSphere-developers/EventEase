<!DOCTYPE html>
<html>
<head>
    <title>Join EventEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex justify-center items-center">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-900">Join EventEase</h2>
        
        <form action="/register" method="POST">
            @csrf
            <div class="mb-4 flex gap-2">
                <div class="w-1/2">
                    <label class="block text-sm font-bold text-gray-700 mb-1">First Name</label>
                    <input type="text" name="firstname" required class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="w-1/2">
                    <label class="block text-sm font-bold text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="lastname" required class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                <input type="text" name="email" required pattern="[a-zA-Z]+\.[a-zA-Z]+@strathmore\.edu" placeholder="first.lastname@strathmore.edu" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <span class="text-xs text-gray-500">Use your Strathmore email (first.lastname@strathmore.edu)</span>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required minlength="6" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <span class="text-xs text-red-600">{{ $message }}</span>
                @enderror
                <span class="text-xs text-gray-500 block">Password must be at least 6 characters.</span>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required minlength="6" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                @if($errors->has('password'))
                    <span class="text-xs text-red-600">Passwords must match.</span>
                @endif
            </div>

            <!-- NEW SECRET CODE FIELD -->
                <!-- Admin Code field removed -->

            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded font-bold hover:bg-blue-700 transition">Sign Up</button>
        </form>
        <p class="mt-4 text-center text-sm">
            Have an account? <a href="/login" class="text-blue-600 font-bold hover:underline">Login</a>
        </p>
    </div>
</body>
</html>