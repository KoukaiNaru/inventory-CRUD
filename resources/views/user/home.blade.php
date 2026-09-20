<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grave of Kings</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="rpg-page">

    <header class="rpg-header">
        <div class="rpg-crest"></div>
        <h1 class="rpg-title">Grave of Kings</h1>
        <p class="rpg-subtitle">Текстовая RPG</p>
    </header>

    @if(session('success'))
        <div class="rpg-flash rpg-flash-success">✦ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="rpg-flash rpg-flash-error">✦ {{ session('error') }}</div>
    @endif

    @if($user)

        <div class="rpg-panel">
            <div class="rpg-welcome">
                <p class="rpg-welcome-name">⚔ {{ $user->name }}</p>
                <div style="display:flex; justify-content:center; gap:20px; margin-top:8px; font-family:'Cinzel',serif; font-size:13px; color:var(--gold-bright);">
                    <span>Уровень: <strong>{{ $user->level }}</strong></span>
                    <span>Монеты: <strong>{{ $user->coins }} 🪙</strong></span>
                </div>
                <p class="rpg-welcome-tagline" style="margin-top:10px;">Ваш голос эхом разносится по всему королевству...</p>
            </div>

            <div class="rpg-divider">
                <div class="rpg-divider-gem"></div>
            </div>

            <nav class="rpg-nav">

                {{-- Инвентарь --}}
                <a href="{{ route('inventory.list') }}" class="rpg-nav-item">
                    <span class="rpg-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="24" height="24" fill="currentColor">
                            <path d="M465.4 192L431.1 144L209 144L174.7 192L465.4 192zM96 212.5C96 199.2 100.2 186.2 107.9 175.3L156.9 106.8C168.9 90 188.3 80 208.9 80L431 80C451.7 80 471.1 90 483.1 106.8L532 175.3C539.8 186.2 543.9 199.2 543.9 212.5L544 480C544 515.3 515.3 544 480 544L160 544C124.7 544 96 515.3 96 480L96 212.5z"/>
                        </svg>
                    </span>
                    <div>
                        <div class="rpg-nav-label">Инвентарь</div>
                        <div class="rpg-nav-desc">Посмотреть и разобрать снаряжение</div>
                    </div>
                    <span class="rpg-nav-arrow">›</span>
                </a>

                {{-- Ковка и крафт --}}
                <a href="{{ route('inventory.create') }}" class="rpg-nav-item">
                    <span class="rpg-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" width="24" height="24" fill="currentColor">
                            <path d="M246.9 82.3L271 67.8C292.6 54.8 317.3 48 342.5 48C379.3 48 414.7 62.6 440.7 88.7L504.6 152.6C519.6 167.6 528 188 528 209.2L528 240.1L547.7 259.8C563.3 244.2 588.6 244.2 604.3 259.8C620 275.4 619.9 300.7 604.3 316.4L540.3 380.4C524.7 396 499.4 396 483.7 380.4C468 364.8 468.1 339.5 483.7 323.8L464 304L433.1 304C411.9 304 391.5 295.6 376.5 280.6L327.4 231.5C312.4 216.5 304 196.1 304 174.9L304 162.2C304 151 298.1 140.5 288.5 134.8L246.9 109.8C236.5 103.6 236.5 88.6 246.9 82.4zM50.7 466.7L272.8 244.6L363.3 335.1L141.2 557.2C116.2 582.2 75.7 582.2 50.7 557.2C25.7 532.2 25.7 491.7 50.7 466.7z"/>
                        </svg>
                    </span>
                    <div>
                        <div class="rpg-nav-label">Кузница</div>
                        <div class="rpg-nav-desc">Выковать новое оружие или создать по рецепту</div>
                    </div>
                    <span class="rpg-nav-arrow">›</span>
                </a>

                {{-- Торговая лавка --}}
                <a href="{{ route('shop.index') }}" class="rpg-nav-item">
                    <span class="rpg-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="24" height="24" fill="currentColor">
                            <path d="M546.2 9.7c-5.6-12.5-21.6-13-28.3-1.2L424.3 176H151.7L58.1 8.5C51.4-3.3 35.4-2.8 29.8 9.7L1.1 73.8c-3.4 7.6-1.5 16.5 4.6 22.1L96 177.3V448c0 35.3 28.7 64 64 64h256c35.3 0 64-28.7 64-64V177.3l90.3-81.4c6.1-5.5 8-14.5 4.6-22.1L546.2 9.7z"/>
                        </svg>
                    </span>
                    <div>
                        <div class="rpg-nav-label">Торговая лавка</div>
                        <div class="rpg-nav-desc">Купить редкое оружие и инструменты</div>
                    </div>
                    <span class="rpg-nav-arrow">›</span>
                </a>

            </nav>

            <div class="rpg-divider">
                <div class="rpg-divider-gem"></div>
            </div>

            <div style="display:flex; flex-direction:column; gap:10px;">
                <form method="POST" action="{{ route('gather') }}">
                    @csrf
                    <button type="submit" class="rpg-btn rpg-btn-full">
                        🌲 Добыть ресурсы (Дерево, Камень, Железо)
                    </button>
                </form>

                <form method="POST" action="{{ route('mine') }}">
                    @csrf
                    <button type="submit" class="rpg-btn rpg-btn-full" style="background:#251908;">
                        ⛏ Добыча золота в шахте (требуется кирка)
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="rpg-form" style="margin-top:8px;">
                    @csrf
                    <button type="submit" class="rpg-btn rpg-btn-ghost rpg-btn-full" style="color:var(--text-dim);">
                        Выйти
                    </button>
                </form>
            </div>
        </div>

    @else

        <div class="rpg-panel">
            <p class="rpg-panel-title">Войдите в игру</p>

            <p style="text-align:center; font-style:italic; color:var(--text-dim); margin-bottom:20px; font-size:14px;">
                Введите имя своего героя
            </p>

            <form method="POST" action="{{ route('username') }}" class="rpg-form">
                @csrf
                <div class="rpg-input-group">
                    <label class="rpg-label" for="name">Имя героя</label>
                    <input
                        class="rpg-input"
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Введите имя..."
                        autocomplete="off"
                        value="{{ old('name') }}"
                        required
                    >
                </div>
                <button type="submit" class="rpg-btn rpg-btn-full">
                    ⚔ Войти
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

    @endif

</div>

</body>
</html>
