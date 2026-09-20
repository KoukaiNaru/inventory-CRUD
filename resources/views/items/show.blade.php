<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $item->title }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="rpg-page">

  <header class="rpg-header">
    <h1 class="rpg-title">{{ $item->title }}</h1>
    <p class="rpg-subtitle">Информация о предмете</p>
  </header>

  <a href="/inventory/list" class="rpg-back">← Назад</a>

  <div class="rpg-panel" style="max-width:480px;">

    <div class="rpg-divider"><div class="rpg-divider-gem"></div></div>

    <div style="display:flex; justify-content:center; margin: 10px 0 20px;">
      <div style="padding: 16px; border: 1px solid var(--border); background: #0c0905; border-radius: 4px; box-shadow: inset 0 0 15px rgba(0,0,0,0.8), 0 0 14px rgba(201,168,76,0.15);">
        <x-item-icon :title="$item->title" :type="$item->type" :power="$item->power" :size="64" />
      </div>
    </div>

    <div style="text-align:center; margin-bottom:20px;">
      <p style="font-size:13px; color:var(--text-dim); margin-bottom:6px;">
        {{ $item->type === 'tool' ? 'Эффективность добычи' : ($item->type === 'resource' ? 'Количество/Свойство' : 'Сила урона') }}
      </p>
      <p style="font-size:42px; font-family:'Cinzel',serif; color:var(--gold); line-height:1;">{{ $item->power }}</p>
    </div>

    @if($item->description)
      <p style="text-align:center; color:var(--text-main); font-style:italic; margin-bottom:20px;">
        {{ $item->description }}
      </p>
    @endif

    <div class="rpg-divider"><div class="rpg-divider-gem"></div></div>

    <form method="POST" action="{{ route('inventory.sell', $item->id) }}" style="margin-bottom:12px;">
      @csrf
      <button type="submit" class="rpg-btn rpg-btn-full">
        Продать торговцу за {{ $item->sell_price }} 🪙
      </button>
    </form>

    <form method="POST" action="{{ route('inventory.destroy', $item->id) }}" onsubmit="return confirm('Удалить этот предмет?')">
      @csrf
      @method('DELETE')
      <button type="submit" class="rpg-btn rpg-btn-danger rpg-btn-full">
        Удалить предмет
      </button>
    </form>

  </div>

</div>

</body>
</html>
