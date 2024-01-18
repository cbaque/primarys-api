<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

use App\Models\Business;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try {
            $user = auth()->user();
            $userBusiness = Business::find($user->business_id);

            return response_data($userBusiness->users, Response::HTTP_OK, 'Datos Leídos correctamente.');
        } catch (\Exception $ex) {
            return response_data([], Response::HTTP_INTERNAL_SERVER_ERROR, 'Error al procesa la petición');
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {

            $business_id = $user = auth()->user()->business_id;
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'business_id' => $business_id
            ]);

            return response_data($user, Response::HTTP_CREATED, 'Usuario creado correctamente.');
        } catch (\Exception $ex) {
            return response_data([], Response::HTTP_INTERNAL_SERVER_ERROR, 'Error al crear usuarios, consulte con administrador');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('user::edit');
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
