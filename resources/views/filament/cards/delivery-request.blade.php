@php $record = $getRecord(); @endphp

<div x-data="{ open: false }">
    <div class="flex gap-14">
        <!-- Left Column -->
        <div class="w-4/6">
        <span class="mb-4 inline-block justify-end px-3 py-2 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">
            {{ $record->matches()->count() }} Travel Request(s)
        </span>

            <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                {{ $record->deliveryCountry->name }}
            </h2>

            <p class="mt-1 text-sm">
                <strong>Location:</strong> {{ $record->delivery_location }}
            </p>

            <p class="text-sm text-gray-400 flex items-center">
                Date (Approx): {{ $record->preferred_delivery_date }}
            </p>

            <p class="mt-2 text-sm text-gray-400 flex items-center">
                Date (Max): {{ $record->delivery_deadline }}
            </p>
        </div>

        <!-- Right Column -->
        <div class="w-2/6">
            <h2 class="text-xs text-right font-semibold text-gray-900 dark:text-white">
                Weight: {{ $record->delivery_weight }} <br>
                Price: {{ $record->delivery_price }}
            </h2>

        </div>
    </div>

    @if($record->products()->count() > 0)
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
    @endif
</div>
