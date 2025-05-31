@php $record = $getRecord(); @endphp

<div x-data="{ open: false }">
    <div>
        <span class="mb-4 inline-block px-3 py-1 text-xs font-semibold rounded-full
            {{ match($record->status) {
                'active' => 'bg-green-100 text-green-800',
                'pending' => 'bg-yellow-100 text-yellow-800',
                'banned' => 'bg-red-100 text-red-800',
                default => 'bg-gray-100 text-gray-800',
            } }}">
            {{ ucwords($record->status) }}
        </span>

        <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $record->deliveryCountry->name }}</h2>

        <p class="mt-1 text-sm"><strong>Location:</strong> {{ $record->delivery_location }}</p>

        <p class="mt-2 text-sm text-gray-400 flex items-center">
            Date (Approx): {{ $record->preferred_delivery_date }}
        </p>

        <p class="mt-2 text-sm text-gray-400 flex items-center">
            Date (Max): {{ $record->preferred_delivery_date }}
        </p>
    </div>

    <!-- Product Detail Toggle Button -->
    <div class="mt-4">

        <div class="mt-4 flex gap-2">
            <x-filament::button
                @click="open = !open"
                color="primary"
                icon="heroicon-o-globe-asia-australia"
                x-text="open ? 'Hide Product Details' : 'Show Product Details'">
                View Product Details
            </x-filament::button>
            <x-filament::button color="success" icon="heroicon-o-globe-asia-australia">Chat</x-filament::button>
        </div>
        <!-- Collapsible Product Details Section -->
        <div x-show="open" x-transition class="mt-4 text-sm text-gray-700 dark:text-gray-300">
            <p><strong>Product Name:</strong> {{ $record->products()->first()?->product_name }}</p>
            <p><strong>Product Link:</strong>
                @if ($link = $record->products()->first()?->product_link)
                    <a href="{{ $link }}" target="_blank" class="text-primary-600 hover:underline">Link</a>
                @else
                    <span class="text-gray-400">N/A</span>
                @endif
            </p>
            <p><strong>Product Description:</strong> {{ $record->products()->first()?->product_description }}</p>
            <p><strong>Price (Approx):</strong> {{ $record->products()->first()?->price }}</p>
            <p><strong>Store Name:</strong> {{ $record->products()->first()?->store_name }}</p>
            <p><strong>Store Location:</strong> {{ $record->products()->first()?->store_location }}</p>
        </div>
    </div>
</div>
