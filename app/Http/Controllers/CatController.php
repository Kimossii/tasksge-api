<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CatController extends Controller
{
    protected $base;

    public function __construct()
    {
        $this->base = config('services.catapi.base_uri');
    }
    //
    public function mostrarGatos()
    {
        $response = Http::withHeaders([
            'x-api-key' => config('services.catapi.key'),
        ])->get(config('services.catapi.base_uri') . 'images/search', [
                    'limit' => 5,
                ]);

        if ($response->successful()) {
            $gatos = $response->json();
            return view('pages.cats.index', compact('gatos'));
        }

        return response()->json(['erro' => 'Erro ao consumir a API.'], 500);
    }

    public function listarRacas()
    {
        $res = Http::withHeaders(['x-api-key' => config('services.catapi.key')])
            ->get($this->base . 'breeds');

        return view('pages.cats.breeds', ['racas' => $res->json()]);
    }
    public function imagensPorRaca($id)
    {
        $res = Http::withHeaders(['x-api-key' => config('services.catapi.key')])
            ->get($this->base . 'images/search', ['breed_ids' => $id, 'limit' => 5]);

        return view('pages.cats.filtered-images', ['gatos' => $res->json()]);
    }

    public function listarCategorias()
    {
        $res = Http::withHeaders(['x-api-key' => config('services.catapi.key')])
            ->get($this->base . 'categories');

        return view('pages.cats.categories', ['categorias' => $res->json()]);
    }

    public function imagensPorCategoria($id)
    {
        $res = Http::withHeaders(['x-api-key' => config('services.catapi.key')])
            ->get($this->base . 'images/search', ['category_ids' => $id, 'limit' => 5]);

        return view('pages.cats.filtered-images', ['gatos' => $res->json()]);
    }

    public function favoritarImagem(Request $request)
    {
        $res = Http::withHeaders(['x-api-key' => config('services.catapi.key')])
            ->post($this->base . 'favourites', [
                'image_id' => $request->input('image_id'),
                'sub_id' => 'usuario123'
            ]);

        return back()->with('status', 'Imagem favoritada!');
    }
    public function listarFavoritos()
    {
        $response = Http::withHeaders([
            'x-api-key' => config('services.catapi.key'),
        ])->get($this->base . 'favourites', [
                    'sub_id' => 'usuario123', // mesmo sub_id usado ao favoritar
                ]);

        if ($response->successful()) {
            $favoritos = $response->json();
            return view('pages.cats.favoritos', compact('favoritos'));
        }

        return response()->json(['erro' => 'Erro ao buscar favoritos.'], 500);
    }

}
