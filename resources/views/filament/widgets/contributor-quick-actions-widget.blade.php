<x-filament-widgets::widget>
    <x-filament::section>
        <div class="edulaw-contributor-hero">
            <div>
                <p class="edulaw-eyebrow">Dashboard Penulis</p>

                <h2>Selamat datang, {{ auth()->user()?->name }}</h2>

                <p>
                    Pantau status tulisan, lanjutkan draft, dan kelola profil penulis Anda di Edulaw Insight.
                    Lengkapi profil agar bio, afiliasi, bidang keahlian, dan foto otomatis tampil pada artikel.
                </p>
            </div>

            <div class="edulaw-contributor-actions">
                <a href="{{ \App\Filament\Resources\InsightResource::getUrl('create') }}" class="edulaw-action-button edulaw-action-button-primary">
                    <x-heroicon-m-pencil-square />
                    Tulis Insight Baru
                </a>

                <a href="{{ url('/admin/profile') }}" class="edulaw-action-button">
                    <x-heroicon-m-user-circle />
                    {{ $isProfileComplete ? 'Edit Profil' : 'Lengkapi Profil' }}
                </a>

                <a href="{{ \App\Filament\Resources\InsightResource::getUrl('index') }}" class="edulaw-action-button">
                    <x-heroicon-m-document-text />
                    Lihat Tulisan Saya
                </a>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
