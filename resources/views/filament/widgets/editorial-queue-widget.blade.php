<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <span class="edulaw-section-heading">
                Editorial Queue
                <span class="edulaw-count-badge">{{ $queueCount }}</span>
            </span>
        </x-slot>

        <div class="edulaw-list-widget">
            @forelse($items as $item)
                <div class="edulaw-queue-row">
                    <span class="edulaw-queue-dot"></span>

                    <div class="min-w-0">
                        <p class="edulaw-queue-title">{{ $item->title }}</p>
                        <p class="edulaw-queue-meta">
                            Insight · Diperbarui {{ $item->updated_at?->locale('id')->diffForHumans() }}
                        </p>
                    </div>

                    <span class="edulaw-status-pill">
                        {{ $statusLabels[$item->status] ?? str($item->status)->headline() }}
                    </span>
                </div>
            @empty
                <div class="edulaw-empty-state">
                    <x-heroicon-o-check-circle />
                    <strong>Queue editorial kosong</strong>
                    <span>Semua insight sudah tertangani. Tidak ada naskah yang menunggu review.</span>
                </div>
            @endforelse
        </div>

        <div class="edulaw-widget-footer">
            <a href="{{ $insightsUrl }}" class="edulaw-mini-button">
                Lihat semua queue
                <x-heroicon-m-chevron-right />
            </a>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
