<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex justify-center items-center">
    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">Student Register</h2>
        
        <form action="/register" method="POST">
            @csrf
            <div class="mb-4">
                <label>Name</label>
                <input type="text" name="name" required class="w-full border p-2 rounded">
            </div>
            <div class="mb-4">
                <label>Email</label>
                <input type="email" name="email" required class="w-full border p-2 rounded">
            </div>
            <div class="mb-4">
                <label>Password</label>
                <input type="password" name="password" required class="w-full border p-2 rounded">
            </div>
            <div class="mb-6">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" required class="w-full border p-2 rounded">
            </div>
            <button type="submit" class="w-full bg-green-600 text-white p-2 rounded hover:bg-green-700">Sign Up</button>
        </form>
        <p class="mt-4 text-center text-sm">
            Have an account? <a href="/login" class="text-blue-600">Login</a>
        </p>
    </div>
</body>
</html>
