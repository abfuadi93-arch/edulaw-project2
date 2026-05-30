<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">Akses Pengguna</x-slot>

        <div class="edulaw-access-list">
            <div class="edulaw-access-item">
                <span><x-heroicon-o-shield-check /></span>
                <div>
                    <strong>Administrator</strong>
                    <small>Akses penuh ke seluruh sistem</small>
                </div>
                <b>{{ $adminCount }}</b>
            </div>

            <div class="edulaw-access-item edulaw-access-item-success">
                <span><x-heroicon-o-pencil-square /></span>
                <div>
                    <strong>Editor</strong>
                    <small>Mengelola konten dan publikasi</small>
                </div>
                <b>{{ $editorCount }}</b>
            </div>

            <div class="edulaw-access-item edulaw-access-item-warning">
                <span><x-heroicon-o-users /></span>
                <div>
                    <strong>Contributor</strong>
                    <small>Kontributor artikel dan insight</small>
                </div>
                <b>{{ $contributorCount }}</b>
            </div>

            <div class="edulaw-access-item edulaw-access-item-danger">
                <span><x-heroicon-o-envelope /></span>
                <div>
                    <strong>Belum Verifikasi</strong>
                    <small>Menunggu verifikasi email</small>
                </div>
                <b>{{ $unverifiedCount }}</b>
            </div>
        </div>

        <div class="edulaw-access-note">
            <a href="{{ $usersUrl }}" class="edulaw-mini-button">
                Kelola pengguna
                <x-heroicon-m-chevron-right />
            </a>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
