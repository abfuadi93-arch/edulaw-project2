<x-filament-widgets::widget>
    <x-filament::section>
        <div class="edulaw-security-widget">
            <div>
                <h2>
                    <span class="edulaw-security-icon">
                        <x-heroicon-s-shield-exclamation />
                    </span>
                    Pemeriksaan keamanan panel admin.
                </h2>

                <p>
                    Pantau konfigurasi production, akun berisiko, dan akses pengguna agar dashboard Edulaw tetap aman.
                </p>
            </div>

            <div class="edulaw-security-counts">
                <div class="edulaw-security-count edulaw-security-count-critical">
                    <span><x-heroicon-s-shield-exclamation /></span>
                    <strong>{{ $criticalCount }}</strong>
                    <small>Critical</small>
                </div>
                <div class="edulaw-security-count edulaw-security-count-high">
                    <span><x-heroicon-s-shield-exclamation /></span>
                    <strong>{{ $highCount }}</strong>
                    <small>High</small>
                </div>
                <div class="edulaw-security-count edulaw-security-count-medium">
                    <span><x-heroicon-s-shield-check /></span>
                    <strong>{{ $mediumCount }}</strong>
                    <small>Medium</small>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="space-y-3">
                @forelse($issues->take(2) as $issue)
                    @php
                        $tone = match ($issue['severity']) {
                            'critical' => 'border-danger-200 bg-danger-50 text-danger-700 dark:border-danger-900/50 dark:bg-danger-950/30 dark:text-danger-300',
                            'high' => 'border-warning-200 bg-warning-50 text-warning-700 dark:border-warning-900/50 dark:bg-warning-950/30 dark:text-warning-300',
                            default => 'border-gray-200 bg-gray-50 text-gray-700 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300',
                        };
                    @endphp

                    <div class="edulaw-security-issue {{ $tone }}">
                        <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between">
                            <div>
                                <p class="text-sm font-bold text-gray-950 dark:text-white">{{ $issue['title'] }}</p>
                                <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">{{ $issue['description'] }}</p>
                            </div>
                            <span class="w-fit rounded-full bg-white/70 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide dark:bg-gray-950/40">
                                {{ $issue['severity'] }}
                            </span>
                        </div>

                        <p class="mt-3 text-xs font-semibold text-gray-500 dark:text-gray-400">
                            {{ $issue['meta'] }}
                        </p>
                    </div>
                @empty
                    <div class="edulaw-security-issue border-success-200 bg-success-50 dark:border-success-900/50 dark:bg-success-950/30">
                        <p class="text-sm font-bold text-success-700 dark:text-success-300">Tidak ada security issue prioritas.</p>
                        <p class="mt-1 text-sm leading-6 text-success-700/80 dark:text-success-300/80">
                            Konfigurasi utama dan role pengguna terlihat aman berdasarkan pemeriksaan dashboard.
                        </p>
                    </div>
                @endforelse

                @if($issues->count() > 2)
                    <a href="{{ $usersUrl }}" class="edulaw-security-more">
                        {{ $issues->count() - 2 }} issue lain perlu ditinjau
                        <x-heroicon-m-chevron-right />
                    </a>
                @endif
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
