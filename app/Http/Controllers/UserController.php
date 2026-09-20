<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        $user = $this->findUser();
        if (session('user_id') && !$user) {
            session()->forget('user_id');
        }
        return view('user.home', compact('user'));
    }

    public function username(Request $request)
    {
        $request->validate(['name' => 'required|string|min:1|max:255']);
        $user = User::firstOrCreate(['name' => trim($request->name)]);
        session(['user_id' => $user->id]);
        return redirect('/');
    }

    public function findUser(): ?User
    {
        $userId = session('user_id');
        return $userId ? User::find($userId) : null;
    }

    public function logout()
    {
        session()->flush();
        session()->regenerate();

        return redirect('/');
    }

    public function mineGold()
    {
        $user = $this->findUser();
        if (!$user) {
            return redirect('/')->with('error', 'Пожалуйста, войдите в игру');
        }

        // Проверяем наличие инструмента (кирки) в инвентаре игрока
        $tool = $user->items()
            ->whereHas('catalog', fn($q) => $q->where('type', 'tool'))
            ->with('catalog')
            ->first();

        if (!$tool) {
            return back()->with('error', 'Для добычи золота нужна кирка! Скрафтите её в кузнице из дерева и камня/железа.');
        }

        $isIron = str_contains($tool->title, 'Железная');
        $amount = $isIron ? rand(30, 60) : rand(12, 25);

        $user->increment('coins', $amount);

        return back()->with('success', "Используя инструмент «{$tool->title}», вы добыли в шахте {$amount} 🪙 золота!");
    }

    public function coins()
    {
        return $this->mineGold();
    }

    public function gather()
    {
        $user = $this->findUser();
        if (!$user) {
            return redirect('/')->with('error', 'Пожалуйста, войдите в игру');
        }

        // Ресурсы в каталоге: 1 - Дерево, 2 - Камень, 3 - Железо
        $resourceId = rand(1, 3);
        $user->items()->create(['catalog_id' => $resourceId]);

        $resource = Catalog::find($resourceId);
        $resourceName = $resource ? $resource->name : 'Ресурс';

        return back()->with('success', "Вы добыли ресурс: «{$resourceName}»!");
    }
}
