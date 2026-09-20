@props([
    'title' => '',
    'type' => 'weapon',
    'power' => 0,
    'size' => 28,
    'class' => '',
])

@php
    $lower = mb_strtolower($title);
    $iconType = 'default';

    if (str_contains($lower, 'кирк') || str_contains($lower, 'pickaxe')) {
        $iconType = 'pickaxe';
    } elseif (str_contains($lower, 'топор') || str_contains($lower, 'axe') || str_contains($lower, 'колун')) {
        $iconType = 'axe';
    } elseif (str_contains($lower, 'нож') || str_contains($lower, 'кинжал') || str_contains($lower, 'dagger')) {
        $iconType = 'dagger';
    } elseif (str_contains($lower, 'меч') || str_contains($lower, 'клинок') || str_contains($lower, 'sword') || str_contains($lower, 'сабля')) {
        $iconType = 'sword';
    } elseif (str_contains($lower, 'дубин') || str_contains($lower, 'молот') || str_contains($lower, 'булав') || str_contains($lower, 'mace') || str_contains($lower, 'hammer')) {
        $iconType = 'mace';
    } elseif (str_contains($lower, 'дерев') || str_contains($lower, 'бревн') || str_contains($lower, 'доск') || str_contains($lower, 'wood')) {
        $iconType = 'wood';
    } elseif (str_contains($lower, 'камен') || str_contains($lower, 'камень') || str_contains($lower, 'stone') || str_contains($lower, 'булыж')) {
        $iconType = 'stone';
    } elseif (str_contains($lower, 'желез') || str_contains($lower, 'сталь') || str_contains($lower, 'слиток') || str_contains($lower, 'iron') || str_contains($lower, 'steel')) {
        $iconType = 'iron';
    } elseif (str_contains($lower, 'золот') || str_contains($lower, 'монет') || str_contains($lower, 'gold') || str_contains($lower, 'coin')) {
        $iconType = 'gold';
    } elseif (str_contains($lower, 'щит') || str_contains($lower, 'shield')) {
        $iconType = 'shield';
    } elseif (str_contains($lower, 'лук') || str_contains($lower, 'арбалет') || str_contains($lower, 'bow')) {
        $iconType = 'bow';
    } elseif ($type === 'tool') {
        $iconType = 'pickaxe';
    } elseif ($type === 'resource') {
        $iconType = 'iron';
    } else {
        $iconType = 'sword';
    }
@endphp

<span class="rpg-item-icon-wrap rpg-icon-{{ $iconType }} {{ $class }}" style="width: {{ $size }}px; height: {{ $size }}px; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;">
@if($iconType === 'pickaxe')
    {{-- Кирка --}}
    <svg class="rpg-animated-icon rpg-svg-pickaxe" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="{{ $size }}" height="{{ $size }}" fill="currentColor">
        <path d="M472.9 83.1c18.7-18.7 18.7-49.1 0-67.9s-49.1-18.7-67.9 0L383 37.1l-14.7 14.7c-5.8 5.8-9.1 13.7-9.1 22c0 8.3 3.3 16.2 9.1 22l44 44c5.8 5.8 13.7 9.1 22 9.1s16.2-3.3 22-9.1l14.7-14.7 2.9-2.9 0 0-1 1zm-96 96l-36.9-36.9-224 224-18.3 73.1c-2.7 10.9 6.8 20.4 17.7 17.7l73.1-18.3 224-224-35.6-35.6zM28.3 228.3c-15.6-15.6-15.6-40.9 0-56.6L127 73c15.6-15.6 40.9-15.6 56.6 0l42.4 42.4-78.1 78.1-119.6 34.8zm399 255.4l-78.1-78.1 42.4 42.4c15.6 15.6 40.9 15.6 56.6 0l98.7-98.7c15.6-15.6 15.6-40.9 0-56.6l-34.8 119.6-84.8 71.4z"/>
    </svg>
@elseif($iconType === 'sword')
    {{-- Меч / Клинок --}}
    <svg class="rpg-animated-icon rpg-svg-sword" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="{{ $size }}" height="{{ $size }}" fill="currentColor">
        <path d="M499.7 12.3c-16.4-16.4-43-16.4-59.4 0l-160 160-33.9-33.9c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l33.9 33.9-140.7 140.7c-9.4 9.4-14.6 22.1-14.6 35.4l0 38.6-67.3 67.3c-15.6 15.6-15.6 40.9 0 56.6s40.9 15.6 56.6 0l67.3-67.3 38.6 0c13.3 0 26-5.3 35.4-14.6l140.7-140.7 33.9 33.9c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-33.9-33.9 160-160c16.4-16.4 16.4-43 0-59.4z"/>
    </svg>
@elseif($iconType === 'dagger')
    {{-- Нож / Кинжал --}}
    <svg class="rpg-animated-icon rpg-svg-dagger" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="{{ $size }}" height="{{ $size }}" fill="currentColor">
        <path d="M495.9 16.1c-21.5-21.5-56.3-21.5-77.8 0L248 186.2l-22.6-22.6c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l22.6 22.6-180.7 180.7c-6 6-9.4 14.1-9.4 22.6l0 48-12 12c-15.6 15.6-15.6 40.9 0 56.6s40.9 15.6 56.6 0l12-12 48 0c8.5 0 16.6-3.4 22.6-9.4L272.3 338l22.6 22.6c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-22.6-22.6 190-190c21.5-21.5 21.5-56.3 0-77.8l-.3-.2z"/>
    </svg>
@elseif($iconType === 'mace')
    {{-- Дубина / Молот --}}
    <svg class="rpg-animated-icon rpg-svg-mace" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="{{ $size }}" height="{{ $size }}" fill="currentColor">
        <path d="M496 160c-8.8 0-16-7.2-16-16l0-16-32 0 0 16c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-16-32 0 0 16c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-32c0-26.5 21.5-48 48-48l96 0c26.5 0 48 21.5 48 48l0 32c0 8.8-7.2 16-16 16s-16-7.2-16-16l0-16-32 0 0 16c0 8.8-7.2 16-16 16zM320 224l32 0 0-32 32 0 0 32 32 0 0-32 32 0 0 32 32 0c17.7 0 32 14.3 32 32l0 16c0 17.7-14.3 32-32 32l-32 0 0 32-32 0 0-32-32 0 0 32-32 0 0-32-32 0c-17.7 0-32-14.3-32-32l0-16c0-17.7 14.3-32 32-32zm-64 80l-208 208-48-48 208-208 48 48z"/>
    </svg>
@elseif($iconType === 'axe')
    {{-- Топор --}}
    <svg class="rpg-animated-icon rpg-svg-axe" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="{{ $size }}" height="{{ $size }}" fill="currentColor">
        <path d="M494.3 75.8c-10-18.2-30.8-27.8-51-23.7l-72.2 14.4c-12.8 2.6-22.3 13.1-23.7 26L338 180.2l-182 182-96 24c-11.4 2.8-19.8 12.3-21.1 24l-3.3 29.8c-1.8 16.2 9.8 30.7 26 32.5s30.7-9.8 32.5-26l1.3-11.9 44.4-11.1 182-182 87.7-9.4c12.9-1.4 23.4-10.9 26-23.7l14.4-72.2c4.1-20.2-5.5-41-23.7-51l48-26.6zM224 96c-17.7 0-32 14.3-32 32s14.3 32 32 32l16 0 0-64-16 0z"/>
    </svg>
@elseif($iconType === 'wood')
    {{-- Дерево / Бревна --}}
    <svg class="rpg-animated-icon rpg-svg-wood" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="{{ $size }}" height="{{ $size }}" fill="currentColor">
        <path d="M448 192c35.3 0 64 28.7 64 64s-28.7 64-64 64l-384 0C28.7 320 0 291.3 0 256s28.7-64 64-64l384 0zm-384 32c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm0 16a16 16 0 1 0 0 32 16 16 0 1 0 0-32zm320-144c35.3 0 64 28.7 64 64s-28.7 64-64 64l-256 0c-35.3 0-64-28.7-64-64s28.7-64 64-64l256 0zm-256 32c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm256 224c35.3 0 64 28.7 64 64s-28.7 64-64 64l-256 0c-35.3 0-64-28.7-64-64s28.7-64 64-64l256 0zm-256 32c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32z"/>
    </svg>
@elseif($iconType === 'stone')
    {{-- Камень --}}
    <svg class="rpg-animated-icon rpg-svg-stone" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="{{ $size }}" height="{{ $size }}" fill="currentColor">
        <path d="M234.5 5.7c13.9-5 29.1-5 43 0l192 68.6C495.2 83.3 512 107.5 512 134.4l0 243.2c0 26.9-16.8 51.1-42.5 60.1l-192 68.6c-13.9 5-29.1 5-43 0l-192-68.6C16.8 428.7 0 404.5 0 377.6L0 134.4c0-26.9 16.8-51.1 42.5-60.1l192-68.6zM256 66.8L96 124l160 57.1 160-57.1L256 66.8zM64 167.3l0 177.3 160 57.1 0-177.3L64 167.3zm224 234.5l160-57.1 0-177.3-160 57.1 0 177.3z"/>
    </svg>
@elseif($iconType === 'iron')
    {{-- Железо / Слиток --}}
    <svg class="rpg-animated-icon rpg-svg-iron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="{{ $size }}" height="{{ $size }}" fill="currentColor">
        <path d="M504.3 273.6l-48-160c-4-13.3-14.9-23.4-28.5-26.4L107.8 17.2c-17-3.8-33.8 6.9-37.6 23.9L22.2 201.1c-3.8 17 6.9 33.8 23.9 37.6l24 5.3 0 184c0 17.7 14.3 32 32 32l320 0c17.7 0 32-14.3 32-32l0-141.4 54.3-12.1c17-3.8 27.7-20.6 23.9-37.6l-7.9-2.7zM384 416l-272 0 0-153.8 272-60.4L384 416z"/>
    </svg>
@elseif($iconType === 'gold')
    {{-- Золото / Монеты --}}
    <svg class="rpg-animated-icon rpg-svg-gold" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="{{ $size }}" height="{{ $size }}" fill="currentColor">
        <path d="M512 80c0 18-14.3 34.6-38.4 48-29.1 16.1-72.5 27.5-122.3 30.9-3.7-1.8-7.6-3.5-11.6-5.1-36.1-14.4-84.1-23.8-137.7-23.8-20.6 0-40.4 1.4-59.2 4-2.8-1.5-5.6-3.1-8.2-4.7C10.7 114.6 0 98 0 80 0 35.8 114.6 0 256 0S512 35.8 512 80zm-48 108.6c28.3-12.3 48-31.2 48-52.6l0 80c0 44.2-114.6 80-256 80-6.1 0-12.1-.1-18.1-.3 15.6-18.4 26.6-40.2 31.4-63.7 75.5 0 142.1-17.7 178.7-43.4H464zM240 336c0 53-78.8 96-176 96S0 389 0 336l0-80c0 21.4 19.7 40.3 48 52.6 36.6 25.7 103.2 43.4 178.7 43.4 4.8 23.5 15.8 45.3 31.4 63.7-6 0-12.1.3-18.1.3zM256 496c-141.4 0-256-35.8-256-80l0-48c28.3 12.3 48 31.2 48 52.6 36.6 25.7 103.2 43.4 178.7 43.4 14.6 0 28.7-.7 42.1-2 12.8 18.5 29.8 33.7 49.9 44.2-20.1 6.3-41.9 9.8-62.7 9.8z"/>
    </svg>
@elseif($iconType === 'shield')
    {{-- Щит --}}
    <svg class="rpg-animated-icon rpg-svg-shield" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="{{ $size }}" height="{{ $size }}" fill="currentColor">
        <path d="M256 0c4.8 0 9.3 1.6 13 4.5l192 144c7.4 5.5 11 14.8 9.2 23.8C451.7 266.6 397.6 424.4 266.3 508.8c-6.3 4.1-14.3 4.1-20.6 0C114.4 424.4 60.3 266.6 41.8 172.3c-1.8-9 1.8-18.3 9.2-23.8l192-144C246.7 1.6 251.2 0 256 0zm0 64L96 184c13.7 70.8 54.7 190.8 160 259.7 105.3-68.9 146.3-188.9 160-259.7L256 64z"/>
    </svg>
@elseif($iconType === 'bow')
    {{-- Лук --}}
    <svg class="rpg-animated-icon rpg-svg-bow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="{{ $size }}" height="{{ $size }}" fill="currentColor">
        <path d="M496 16c8.8 0 16 7.2 16 16l0 32c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-32c0-8.8 7.2-16 16-16l32 0zm-80 96c8.8 0 16 7.2 16 16l0 32c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-32c0-8.8 7.2-16 16-16l32 0zM320 224l32 0c8.8 0 16 7.2 16 16l0 32c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-32c0-8.8 7.2-16 16-16zm-96 96l32 0c8.8 0 16 7.2 16 16l0 32c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-32c0-8.8 7.2-16 16-16zm-96 96l32 0c8.8 0 16 7.2 16 16l0 32c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-32c0-8.8 7.2-16 16-16zm-96 96l32 0c8.8 0 16 7.2 16 16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16z"/>
    </svg>
@else
    {{-- Обычный артефакт --}}
    <svg class="rpg-animated-icon rpg-svg-default" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="{{ $size }}" height="{{ $size }}" fill="currentColor">
        <path d="M256 0c14.7 0 28.2 8.1 35.2 21l192 352c7.4 13.5 6.9 30-1.3 43.1S460.1 437 444.8 437L67.2 437c-15.3 0-29.4-7.9-37.3-20.9s-8.7-29.6-1.3-43.1l192-352C227.8 8.1 241.3 0 256 0z"/>
    </svg>
@endif
</span>
