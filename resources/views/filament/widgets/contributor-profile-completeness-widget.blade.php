<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">Kelengkapan Profil</x-slot>

        <div class="edulaw-profile-meter">
            <strong>{{ $percentage }}%</strong>
            <div>
                <span style="width: {{ $percentage }}%"></span>
            </div>
        </div>

        <div class="edulaw-profile-checklist">
            @foreach($items as $label => $complete)
                <div>
                    <span class="{{ $complete ? 'is-complete' : 'is-missing' }}">
                        @if($complete)
                            <x-heroicon-m-check />
                        @else
                            <x-heroicon-m-x-mark />
                        @endif
                    </span>
                    <p>{{ $label }}</p>
                    <small>{{ $complete ? 'Lengkap' : 'Belum' }}</small>
                </div>
            @endforeach
        </div>

        <div class="edulaw-widget-footer">
            <a href="{{ $profileUrl }}" class="edulaw-mini-button">
                {{ $percentage === 100 ? 'Edit Profil' : 'Lengkapi Profil' }}
                <x-heroicon-m-chevron-right />
            </a>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
