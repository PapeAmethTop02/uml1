@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Suivre ma commande</h1>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('orders.track') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-gray-700 mb-2">Email utilisé pour la commande</label>
                <input type="email" name="email" id="email" required
                       class="w-full border rounded-md px-3 py-2"
                       value="{{ old('email') }}">
            </div>

            <div>
                <label for="order_id" class="block text-gray-700 mb-2">Numéro de commande</label>
                <input type="number" name="order_id" id="order_id" required
                       class="w-full border rounded-md px-3 py-2"
                       value="{{ old('order_id') }}">
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition">
                🔍 Suivre ma commande
            </button>
        </form>
    </div>
</div>
@endsection 