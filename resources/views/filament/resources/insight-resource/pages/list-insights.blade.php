<x-filament-panels::page
    @class([
        'fi-resource-list-records-page',
        'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
        'edulaw-insight-list-page',
    ])
>
    @php
        $summaryCards = $this->getInsightSummaryCards();
    @endphp

    <div class="edulaw-resource-page">
        <section class="edulaw-resource-hero">
            <div>
                <span>Editorial Insight</span>
                <h1>Kelola Edulaw Insight</h1>
                <p>Tinjau artikel, kelola status publikasi, dan jaga kualitas editorial Edulaw Project.</p>
            </div>
        </section>

        <section class="edulaw-insight-summary" aria-label="Ringkasan artikel">
            @foreach ($summaryCards as $card)
                <article class="edulaw-insight-summary-card edulaw-insight-summary-card-{{ $card['tone'] }}">
                    <span>{{ $card['label'] }}</span>
                    <strong>{{ number_format($card['value'], 0, ',', '.') }}</strong>
                </article>
            @endforeach
        </section>

        <x-filament-panels::resources.tabs />

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_BEFORE, scopes: $this->getRenderHookScopes()) }}

        <section class="edulaw-resource-table-card">
            <div class="edulaw-resource-table-scroll">
                {{ $this->table }}
            </div>
        </section>

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_AFTER, scopes: $this->getRenderHookScopes()) }}
    </div>
</x-filament-panels::page>
