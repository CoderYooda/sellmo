<?php

namespace App\Http\Controllers\Develop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeedController extends Controller
{
    /**
     * @return View
     */
    public function index() : View
    {
        return view('develop.seed.index');
    }

    /**
     * @return void
     */
    public function products(Request $request)
    {
        Product::factory()->count($request->get('count'))->create([
            'company_id' => $request->get('company_id'),
        ]);

    }
}
