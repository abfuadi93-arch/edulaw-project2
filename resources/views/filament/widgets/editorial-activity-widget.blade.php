<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">Aktivitas Terbaru</x-slot>

        <div class="edulaw-list-widget">
            @forelse($activities as $activity)
                <div class="edulaw-activity-row">
                    <span class="edulaw-activity-icon">
                        <x-filament::icon :icon="$activity['icon']" />
                    </span>

                    <div class="min-w-0">
                        <p class="edulaw-activity-copy">
                            <strong>Edulaw Project</strong> {{ $activity['action'] }}
                        </p>

                        @if($activity['title'])
                            <p class="edulaw-activity-title">{{ $activity['title'] }}</p>
                        @endif
                    </div>

                    <time>{{ $activity['updated_at']?->locale('id')->diffForHumans() }}</time>
                </div>
            @empty
                <div class="edulaw-empty-state">
                    <x-heroicon-o-clock />
                    <strong>Belum ada aktivitas</strong>
                    <span>Aktivitas editorial terbaru akan muncul di sini.</span>
                </div>
            @endforelse
        </div>

        <div class="edulaw-widget-footer">
            <span class="edulaw-mini-button edulaw-mini-button-muted">
                Lihat semua aktivitas
                <x-heroicon-m-chevron-right />
            </span>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
