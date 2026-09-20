<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Торговая лавка</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="rpg-page">

    <header class="rpg-header">
        <div class="rpg-crest">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="48" height="48" fill="var(--gold)">
                <path d="M546.2 9.7c-5.6-12.5-21.6-13-28.3-1.2L424.3 176H151.7L58.1 8.5C51.4-3.3 35.4-2.8 29.8 9.7L1.1 73.8c-3.4 7.6-1.5 16.5 4.6 22.1L96 177.3V448c0 35.3 28.7 64 64 64h256c35.3 0 64-28.7 64-64V177.3l90.3-81.4c6.1-5.5 8-14.5 4.6-22.1L546.2 9.7z"/>
            </svg>
        </div>
        <h1 class="rpg-title">Торговая лавка</h1>
        <p class="rpg-subtitle">Оружие и инструменты за чистое золото</p>
    </header>

    <a href="/" class="rpg-back">← Назад в лагерь</a>

    @if(session('success'))
        <div class="rpg-flash rpg-flash-success">✦ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="rpg-flash rpg-flash-error">✦ {{ session('error') }}</div>
    @endif

    <div class="rpg-panel" style="max-width:640px;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; background:var(--bg-card); padding:14px 18px; border:1px solid var(--border);">
            <span style="font-family:'Cinzel',serif; font-size:13px; color:var(--text-dim); text-transform:uppercase; letter-spacing:0.1em;">
                Ваш кошелёк
            </span>
            <span style="font-family:'Cinzel',serif; font-size:18px; font-weight:700; color:var(--gold-bright);">
                {{ $user->coins }} 🪙
            </span>
        </div>

        <div class="rpg-divider"><div class="rpg-divider-gem"></div></div>

        <p class="rpg-panel-title" style="margin-bottom:16px;">Товары торговца</p>

        <div style="display:flex; flex-direction:column; gap:14px;">
            @foreach($goods as $good)
                @php
                    $canAfford = $user->coins >= $good->price;
                @endphp
                <div style="display:flex; justify-content:space-between; align-items:center; background:var(--bg-card); border:1px solid var(--border); padding:16px; gap:14px;">
                    <div style="display:flex; align-items:center; gap:14px;">
                        <x-item-icon :title="$good->name" :type="$good->type" :power="$good->power" :size="32" />
                        <div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span style="font-family:'Cinzel',serif; font-weight:700; color:var(--gold-bright); font-size:15px;">
                                    {{ $good->name }}
                                </span>
                                <span style="font-size:11px; padding:2px 8px; border:1px solid var(--border); color:var(--text-dim); text-transform:uppercase;">
                                    {{ $good->type === 'tool' ? 'Инструмент' : 'Оружие' }}
                                </span>
                            </div>
                            <div style="font-size:13px; color:var(--text-dim); margin-top:4px;">
                                {{ $good->type === 'tool' ? 'Эффективность добычи: +' : 'Сила урона: ' }}{{ $good->power }}
                            </div>
                        </div>
                    </div>

                    <div style="display:flex; align-items:center; gap:14px;">
                        <span style="font-family:'Cinzel',serif; font-size:15px; font-weight:700; color:var(--gold);">
                            {{ $good->price }} 🪙
                        </span>

                        <form method="POST" action="{{ route('shop.buy', $good->id) }}">
                            @csrf
                            <button
                                type="submit"
                                class="rpg-btn {{ $canAfford ? '' : 'rpg-btn-ghost' }}"
                                style="padding:8px 16px; font-size:11px;"
                                {{ $canAfford ? '' : 'disabled' }}
                            >
                                {{ $canAfford ? 'Купить' : 'Мало золота' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</div>

</body>
</html>
