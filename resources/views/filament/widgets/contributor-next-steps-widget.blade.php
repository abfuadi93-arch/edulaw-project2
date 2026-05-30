<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">Langkah Berikutnya</x-slot>

        <div class="edulaw-next-steps">
            @if($draft)
                <a href="{{ $draftUrl }}" class="edulaw-next-draft">
                    <span><x-heroicon-o-pencil-square /></span>
                    <div>
                        <strong>Lanjutkan draft terakhir</strong>
                        <small>{{ str($draft->title)->limit(72) }}</small>
                    </div>
                    <x-heroicon-m-chevron-right />
                </a>
            @endif

            <div class="edulaw-next-step-list">
                <p>
                    @if($isProfileComplete)
                        <x-heroicon-m-check-circle />
                        Profil penulis sudah lengkap
                    @else
                        <x-heroicon-m-exclamation-circle />
                        Lengkapi profil penulis
                    @endif
                </p>
                <p><x-heroicon-m-plus-circle /> <a href="{{ $createUrl }}">Tulis insight baru</a></p>
                <p><x-heroicon-m-clock /> Pantau naskah yang sedang direview</p>
                <p><x-heroicon-m-arrow-path /> Perbarui tulisan yang sudah terbit bila diperlukan</p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
