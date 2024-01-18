<?php

namespace Modules\Products\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use App\Models\Business;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try {
            $user = auth()->user();
            $productsBusiness = Business::find($user->business_id);

            return response_data($productsBusiness->with('products')->get(), Response::HTTP_OK, 'Datos Leídos correctamente.');
        } catch (\Exception $ex) {
            return response_data([], Response::HTTP_INTERNAL_SERVER_ERROR, 'Error al procesar la petición');
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('products::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {
            $business_id = auth()->user()->business_id;
            $product = Product::create([
                'barcode' => $request->barcode,
                'description' => $request->description,
                'purchase_price' => $request->purchase_price,
                'sale_price' => $request->sale_price,
                'existence' => $request->existence,
                'business_id' => $business_id
            ]);


            return response_data($product, Response::HTTP_CREATED, 'Producto creado correctamente.');
        } catch (\Exception $ex) {
            return response_data([], Response::HTTP_INTERNAL_SERVER_ERROR, $ex->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('products::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('products::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
