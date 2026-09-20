<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Кузница и ковка</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="rpg-page">

  <header class="rpg-header">
    <div class="rpg-crest">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="48" height="48" fill="var(--gold)">
        <path d="M246.9 82.3L271 67.8C292.6 54.8 317.3 48 342.5 48C379.3 48 414.7 62.6 440.7 88.7L504.6 152.6C519.6 167.6 528 188 528 209.2L528 240.1L547.7 259.8C563.3 244.2 588.6 244.2 604.3 259.8C620 275.4 619.9 300.7 604.3 316.4L540.3 380.4C524.7 396 499.4 396 483.7 380.4C468 364.8 468.1 339.5 483.7 323.8L464 304L433.1 304C411.9 304 391.5 295.6 376.5 280.6L327.4 231.5C312.4 216.5 304 196.1 304 174.9L304 162.2C304 151 298.1 140.5 288.5 134.8L246.9 109.8C236.5 103.6 236.5 88.6 246.9 82.4zM50.7 466.7L272.8 244.6L363.3 335.1L141.2 557.2C116.2 582.2 75.7 582.2 50.7 557.2C25.7 532.2 25.7 491.7 50.7 466.7z"/>
      </svg>
    </div>
    <h1 class="rpg-title">Кузница</h1>
    <p class="rpg-subtitle">Создай своё оружие или скрафти по рецепту</p>
  </header>

  <a href="/" class="rpg-back">← Назад</a>

  @if(session('error'))
    <div class="rpg-flash rpg-flash-error">✦ {{ session('error') }}</div>
  @endif

  @if(session('success'))
    <div class="rpg-flash rpg-flash-success">✦ {{ session('success') }}</div>
  @endif

  {{-- Блок рецептов --}}
  @if(isset($recipes) && $recipes->isNotEmpty())
    <div class="rpg-panel" style="max-width:560px; margin-bottom:28px;">
      <p class="rpg-panel-title">Рецепты создания</p>

      <div style="display:flex; flex-direction:column; gap:16px;">
        @foreach($recipes as $itemId => $itemRecipes)
          @php
            $target = $itemRecipes->first()->item;
            $canCraft = true;
          @endphp

          <div style="border:1px solid var(--border); background:var(--bg-card); padding:16px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
              <div style="display:flex; align-items:center; gap:10px;">
                <x-item-icon :title="$target?->name ?? ''" :type="$target?->type ?? 'weapon'" :power="$target?->power ?? 0" :size="30" />
                <span style="font-family:'Cinzel',serif; font-weight:700; color:var(--gold-bright); font-size:15px;">
                  {{ $target?->name ?? 'Оружие' }} (Сила: {{ $target?->power ?? 0 }})
                </span>
              </div>
            </div>

            <div style="font-size:13px; color:var(--text-dim); margin-bottom:12px; display:flex; flex-wrap:wrap; align-items:center; gap:12px;">
              <span>Требуется:</span>
              @foreach($itemRecipes as $recipe)
                @php
                  $available = $userItems[$recipe->ingredient_id] ?? 0;
                  if ($available < $recipe->quantity) {
                    $canCraft = false;
                  }
                @endphp
                <span style="display:inline-flex; align-items:center; gap:6px; color: {{ $available >= $recipe->quantity ? '#7aaa7a' : '#c06060' }};">
                  <x-item-icon :title="$recipe->ingredient?->name ?? ''" :type="'resource'" :size="16" />
                  {{ $recipe->ingredient?->name }}: {{ $available }}/{{ $recipe->quantity }}
                </span>
              @endforeach
            </div>

            <form method="POST" action="{{ route('inventory.craft', $itemId) }}">
              @csrf
              <button type="submit" class="rpg-btn {{ $canCraft ? '' : 'rpg-btn-ghost' }}" style="font-size:11px; padding:8px 16px;" {{ $canCraft ? '' : 'disabled' }}>
                {{ $canCraft ? 'Сковать по рецепту' : 'Не хватает ресурсов' }}
              </button>
            </form>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  {{-- Блок ручной ковки --}}
  <div class="rpg-panel" style="max-width:560px;">
    <p class="rpg-panel-title">Индивидуальная ковка</p>

    <form method="POST" action="{{ route('inventory.store') }}" class="rpg-form">
      @csrf

      <div class="rpg-input-group">
        <label class="rpg-label" for="title">Название оружия</label>
        <input
          class="rpg-input"
          type="text"
          id="title"
          name="title"
          placeholder="Например: Клинок теней"
          value="{{ old('title') }}"
          required
        >
      </div>

      <div class="rpg-input-group">
        <label class="rpg-label" for="description">
          Описание <span style="color:var(--text-dim); font-size:11px;">(необязательно)</span>
        </label>
        <input
          class="rpg-input"
          type="text"
          id="description"
          name="description"
          placeholder="Откуда это оружие?"
          value="{{ old('description') }}"
        >
      </div>

      <div class="rpg-input-group">
        <label class="rpg-label" for="power">Сила (1–100)</label>
        <input
          class="rpg-input"
          type="number"
          id="power"
          name="power"
          placeholder="75"
          min="1" max="100"
          value="{{ old('power') }}"
          required
        >
      </div>

      <div class="rpg-divider" style="margin:8px 0;"><div class="rpg-divider-gem"></div></div>

      <button type="submit" class="rpg-btn rpg-btn-full">
        Выковать оружие
      </button>
    </form>

    @if($errors->any())
      <div class="rpg-errors" style="margin-top:16px;">
        @foreach($errors->all() as $error)
          <p>✦ {{ $error }}</p>
        @endforeach
      </div>
    @endif
  </div>

</div>

</body>
</html>
