<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | EventEase</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-300 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-2xl rounded-2xl p-10 w-full max-w-md border-t-8 border-blue-700">
        <div class="flex flex-col items-center mb-6">
            <div class="bg-blue-700 text-white rounded-full w-16 h-16 flex items-center justify-center text-3xl font-bold mb-2 shadow-lg">EE</div>
            <h2 class="text-3xl font-extrabold text-blue-900 mb-1">Welcome Back</h2>
            <p class="text-gray-500 text-sm">Sign in to your EventEase account</p>
        </div>
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded text-sm">{{ $errors->first() }}</div>
        @endif
        <form action="/login" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Email</label>
                <input type="text" name="email" required pattern="[a-zA-Z]+\.[a-zA-Z]+@strathmore\.edu" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="first.lastname@strathmore.edu">
                <span class="text-xs text-gray-500">Use your Strathmore email (first.lastname@strathmore.edu)</span>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="••••••••">
            </div>
            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 rounded transition shadow">Login</button>
        </form>
        <p class="mt-6 text-center text-sm text-gray-600">
            No account? <a href="/register" class="text-blue-700 font-bold hover:underline">Register here</a>
        </p>
    </div>
</body>
</html>