@php($value = (float) ($rating ?? 0))
<span class="text-nowrap">
    @for ($i = 1; $i <= 5; $i++)
        <i class="{{ $i <= round($value) ? 'fa-solid text-warning' : 'fa-regular text-secondary' }} fa-star" style="font-size: {{ $size ?? '.8rem' }}"></i>
    @endfor
</span>
