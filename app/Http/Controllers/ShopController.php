<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function user(): ?User
    {
        $userId = session('user_id');
        return $userId ? User::find($userId) : null;
    }

    public function index()
    {
        $user = $this->user();
        if (!$user) {
            return redirect('/')->with('error', 'Пожалуйста, войдите в игру');
        }

        $goods = Catalog::shopItems()->get();
        return view('shop.index', compact('user', 'goods'));
    }

    public function buy(int|string $id)
    {
        $user = $this->user();
        if (!$user) {
            return redirect('/')->with('error', 'Пожалуйста, войдите в игру');
        }

        $catalogItem = Catalog::findOrFail($id);

        if ($user->coins < $catalogItem->price) {
            return back()->with('error', "Недостаточно золота! Стоимость: {$catalogItem->price} 🪙, у вас в кошельке: {$user->coins} 🪙.");
        }

        DB::transaction(function () use ($user, $catalogItem) {
            $user->decrement('coins', $catalogItem->price);
            $user->items()->create(['catalog_id' => $catalogItem->id]);
        });

        return back()->with('success', "Вы успешно приобрели «{$catalogItem->name}» за {$catalogItem->price} 🪙!");
    }
}
