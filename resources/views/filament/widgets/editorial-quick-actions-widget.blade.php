<x-filament-widgets::widget>
    <x-filament::section>
        <div class="edulaw-hero-card">
            <div class="edulaw-hero-copy">
                <p class="edulaw-eyebrow">
                    Selamat datang kembali, {{ auth()->user()?->name ?? 'Edulaw Project' }}
                </p>

                <p>
                    Gunakan dashboard ini untuk menerbitkan insight, mengunggah publikasi,
                    memantau performa artikel, dan menjaga konsistensi editorial Edulaw Project.
                </p>
            </div>

            <div class="edulaw-hero-actions">
                <a
                    href="{{ \App\Filament\Resources\InsightResource::getUrl('create') }}"
                    class="edulaw-action-button edulaw-action-button-primary"
                >
                    <x-heroicon-m-pencil-square />
                    Tambah Insight
                </a>

                <a
                    href="{{ \App\Filament\Resources\ResearchResource::getUrl('create') }}"
                    class="edulaw-action-button"
                >
                    <x-heroicon-m-book-open />
                    Tambah Publikasi
                </a>

                <a
                    href="{{ \App\Filament\Resources\ProgramResource::getUrl('create') }}"
                    class="edulaw-action-button"
                >
                    <x-heroicon-m-academic-cap />
                    Tambah Program
                </a>

            </div>

            <div class="edulaw-hero-watermark" aria-hidden="true">
                <x-heroicon-o-scale />
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
