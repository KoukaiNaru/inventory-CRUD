<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Item;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function user(): ?User
    {
        $userId = session('user_id');
        return $userId ? User::find($userId) : null;
    }

    public function item()
    {
        $user = $this->user();
        if (!$user) {
            return redirect('/')->with('error', 'Пожалуйста, войдите');
        }

        $items = $user->items()->with('catalog')->latest()->get();
        return view('items.info', compact('items'));
    }

    public function show(int|string $id)
    {
        $user = $this->user();
        if (!$user) {
            return redirect('/')->with('error', 'Пожалуйста, войдите');
        }

        $item = $user->items()->with('catalog')->findOrFail($id);
        return view('items.show', compact('item'));
    }

    public function create()
    {
        $user = $this->user();
        if (!$user) {
            return redirect('/')->with('error', 'Пожалуйста, войдите');
        }

        $recipes = Recipe::with(['item', 'ingredient'])->get()->groupBy('item_id');
        $userItems = $user->items()
            ->select('catalog_id', DB::raw('count(*) as total'))
            ->groupBy('catalog_id')
            ->pluck('total', 'catalog_id')
            ->toArray();

        return view('items.create', compact('recipes', 'userItems'));
    }

    public function store(Request $request)
    {
        $user = $this->user();
        if (!$user) {
            return redirect('/')->with('error', 'Пожалуйста, войдите');
        }

        $validated = $request->validate([
            'title' => 'required|string|min:2|max:255',
            'description' => 'nullable|string|max:500',
            'power' => 'required|integer|min:1|max:100',
        ]);

        $catalogItem = Catalog::firstOrCreate(
            ['name' => $validated['title']],
            [
                'type' => 'weapon',
                'power' => $validated['power'],
            ]
        );

        $user->items()->create([
            'catalog_id' => $catalogItem->id,
        ]);

        return redirect()->route('inventory.list')->with('success', "Оружие «{$catalogItem->name}» успешно выковано!");
    }

    public function craft(int|string $id)
    {
        $user = $this->user();
        if (!$user) {
            return redirect('/')->with('error', 'Пожалуйста, войдите');
        }

        $targetCatalog = Catalog::findOrFail($id);
        $recipeIngredients = Recipe::where('item_id', $id)->get();

        if ($recipeIngredients->isEmpty()) {
            return back()->with('error', 'Рецепт не найден');
        }

        foreach ($recipeIngredients as $req) {
            $count = $user->items()->where('catalog_id', $req->ingredient_id)->count();
            if ($count < $req->quantity) {
                $ingName = $req->ingredient?->name ?? 'ингредиентов';
                return back()->with('error', "Недостаточно ресурсов: требуется {$req->quantity} шт. «{$ingName}»");
            }
        }

        DB::transaction(function () use ($user, $recipeIngredients, $id) {
            foreach ($recipeIngredients as $req) {
                $idsToDelete = $user->items()
                    ->where('catalog_id', $req->ingredient_id)
                    ->limit($req->quantity)
                    ->pluck('id');
                Item::whereIn('id', $idsToDelete)->delete();
            }
            $user->items()->create(['catalog_id' => $id]);
        });

        return redirect()->route('inventory.list')->with('success', "Вы успешно создали «{$targetCatalog->name}»!");
    }

    public function sell(int|string $id)
    {
        $user = $this->user();
        if (!$user) {
            return redirect('/')->with('error', 'Пожалуйста, войдите');
        }

        $item = $user->items()->with('catalog')->findOrFail($id);
        $name = $item->title;
        $sellPrice = $item->sell_price;

        DB::transaction(function () use ($user, $item, $sellPrice) {
            $user->increment('coins', $sellPrice);
            $item->delete();
        });

        return redirect()->route('inventory.list')->with('success', "Вы продали «{$name}» за {$sellPrice} 🪙!");
    }

    public function destroy(int|string $id)
    {
        $user = $this->user();
        if (!$user) {
            return redirect('/')->with('error', 'Пожалуйста, войдите');
        }

        $item = $user->items()->with('catalog')->findOrFail($id);
        $name = $item->title;
        $item->delete();

        return redirect()->route('inventory.list')->with('success', "Предмет «{$name}» удален");
    }
}
