<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Models\Business;
class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('auth::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('auth::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $loginData = $request->validate([
            'business' => 'required',
            'name' => 'required',
            'password' => 'required'
        ]);

        $business = Business::where('ruc', $loginData['business'])->first();
        if (!isset($business)) {
            return response_data([], Response::HTTP_METHOD_NOT_ALLOWED, 'Empresa no existe, verificar');
        }

        if (!Auth::attempt(['name' => $loginData['name'], 'password' => $loginData['password']], 'business_id', $business->id)) {
            return response_data([], Response::HTTP_METHOD_NOT_ALLOWED, 'Credenciales Incorrectas.');
        }

        $token = Auth::user()->createToken('authToken')->accessToken;

        return response_data([
            'user' => Auth::user()->name,
            'token' => $token,
        ], Response::HTTP_OK, 'Login correctamente.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('auth::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('auth::edit');
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
