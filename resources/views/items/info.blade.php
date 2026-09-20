<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Инвентарь</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="rpg-page">

  <header class="rpg-header">
    <div class="rpg-crest">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="48" height="48" fill="var(--gold)">
        <path d="M465.4 192L431.1 144L209 144L174.7 192L465.4 192zM96 212.5C96 199.2 100.2 186.2 107.9 175.3L156.9 106.8C168.9 90 188.3 80 208.9 80L431 80C451.7 80 471.1 90 483.1 106.8L532 175.3C539.8 186.2 543.9 199.2 543.9 212.5L544 480C544 515.3 515.3 544 480 544L160 544C124.7 544 96 515.3 96 480L96 212.5z"/>
      </svg>
    </div>
    <h1 class="rpg-title">Инвентарь</h1>
    <p class="rpg-subtitle">Твоя коллекция оружия</p>
  </header>

  <a href="/" class="rpg-back">← Назад</a>

  @if(session('success'))
    <div class="rpg-flash rpg-flash-success">✦ {{ session('success') }}</div>
  @endif

  <div class="rpg-panel" style="max-width:640px;">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
      <p class="rpg-panel-title" style="margin-bottom:0;">Оружие</p>
      <a href="/inventory/create" class="rpg-btn" style="padding:9px 18px; font-size:11px;">
        + Создать
      </a>
    </div>

    <div class="rpg-divider"><div class="rpg-divider-gem"></div></div>

    @if($items->count() > 0)

      <div class="rpg-inventory">
        @foreach($items as $item)

          <div style="display:flex; align-items:center; gap:10px;">
            <a href="/inventory/{{ $item->id }}" class="rpg-item-card" style="flex:1;">

              {{-- Анимированная иконка предмета --}}
              <span class="rpg-item-icon">
                <x-item-icon :title="$item->title" :type="$item->type" :power="$item->power" :size="28" />
              </span>

              <div class="rpg-item-info">
                <div class="rpg-item-name">{{ $item->title }}</div>
                <div class="rpg-item-desc">
                  {{ $item->description ?: 'Нет описания' }}
                </div>
              </div>

              <div class="rpg-item-power">
                <span class="rpg-item-power-val">{{ $item->power }}</span>
                <span class="rpg-item-power-label">{{ $item->type === 'tool' ? 'эффект.' : ($item->type === 'resource' ? 'рес.' : 'урон') }}</span>
              </div>
            </a>

            <form method="POST" action="{{ route('inventory.sell', $item->id) }}" onsubmit="return confirm('Продать за {{ $item->sell_price }} 🪙?')">
              @csrf
              <button type="submit" class="rpg-btn" style="padding:9px 12px; font-size:11px; white-space:nowrap;" title="Продать за {{ $item->sell_price }} 🪙">
                {{ $item->sell_price }} 🪙
              </button>
            </form>

            <form method="POST" action="{{ route('inventory.destroy', $item->id) }}" onsubmit="return confirm('Удалить?')">
              @csrf
              @method('DELETE')
              <button type="submit" class="rpg-btn rpg-btn-danger" title="Удалить">✕</button>
            </form>
          </div>

        @endforeach
      </div>

    @else

      <div class="rpg-empty">
        <p class="rpg-empty-text">Инвентарь пуст</p>
        <a href="/inventory/create" class="rpg-btn" style="margin-top:20px; display:inline-block;">
          Создать оружие
        </a>
      </div>

    @endif

  </div>

</div>

</body>
</html>
