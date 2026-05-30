@props([
    'label' => 'Insight',
    'compact' => false,
])

<div {{ $attributes->merge(['class' => 'relative flex h-full w-full items-center justify-center overflow-hidden bg-[#0F2868]']) }}>
    <div class="absolute inset-0 opacity-20" style="background-image: linear-gradient(135deg, rgba(255,255,255,.24) 1px, transparent 1px); background-size: {{ $compact ? '22px' : '26px' }} {{ $compact ? '22px' : '26px' }};"></div>
    <div class="absolute left-5 top-5 rounded border border-white/20 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-white/60">Edulaw</div>
    <div class="absolute -bottom-16 -right-10 h-40 w-40 rounded-full border border-white/10"></div>
    <div class="relative text-center">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-white/55">Editorial</p>
        <p class="mt-2 {{ $compact ? 'text-2xl' : 'text-3xl' }} font-bold leading-none text-white">{{ $label }}</p>
        @unless($compact)
            <div class="mx-auto mt-5 h-px w-24 bg-white/40"></div>
        @endunless
    </div>
</div>
