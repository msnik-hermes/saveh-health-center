<x-filament-widgets::widget>
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <div class="shc-stat">
                <div class="shc-stat-label">{{ $stat['label'] }}</div>
                <div class="shc-stat-value">{{ $stat['value'] }}</div>
                <div class="shc-stat-hint">{{ $stat['hint'] }}</div>
            </div>
        @endforeach
    </div>
</x-filament-widgets::widget>
