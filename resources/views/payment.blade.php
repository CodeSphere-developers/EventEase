<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pay for Ticket | EventEase</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex justify-center items-center">
    
    <div class="bg-white p-8 rounded-xl shadow-lg w-96 border border-gray-200">
        <h2 class="text-2xl font-bold mb-2 text-center text-gray-800">Complete Payment</h2>
        <p class="text-center text-gray-500 mb-6">Secure Checkout</p>

        <div class="bg-blue-50 p-4 rounded mb-6 text-sm">
            <p class="font-bold text-blue-800">Event:</p>
            <p>{{ $event->title }}</p>
            <p class="font-bold text-blue-800 mt-2">Amount Due:</p>
            <p class="text-xl font-bold text-blue-900">${{ number_format($event->fee, 2) }}</p>
        </div>

        <form action="{{ route('payment.process') }}" method="POST">
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <input type="hidden" name="amount" value="{{ $event->fee }}">

            <div class="mb-4">
                <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Card Number</label>
                <input type="text" placeholder="4242 4242 4242 4242" class="w-full border p-2 rounded bg-gray-50" readonly>
            </div>

            <div class="flex gap-4 mb-6">
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Expiry</label>
                    <input type="text" placeholder="MM/YY" class="w-full border p-2 rounded bg-gray-50" readonly>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-1">CVC</label>
                    <input type="text" placeholder="123" class="w-full border p-2 rounded bg-gray-50" readonly>
                </div>
            </div>

            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded transition shadow">
                Pay ${{ number_format($event->fee, 2) }}
            </button>
            
            <a href="{{ route('dashboard') }}" class="block text-center text-gray-400 text-sm mt-4 hover:text-gray-600">Cancel</a>
        </form>
    </div>

</body>
</html>