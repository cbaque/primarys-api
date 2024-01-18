<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

use App\Models\Business;
use App\Models\User;
use App\Models\People;

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

            return response_data($userBusiness->users()->with('people')->get(), Response::HTTP_OK, 'Datos Leídos correctamente.');
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
            $people = People::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'business_id' => $business_id,
                'people_id' => $people->id
            ]);

            return response_data($user, Response::HTTP_CREATED, 'Usuario creado correctamente.');
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
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {

            $user = User::find($id);
            if (empty($user)) {
                throw new \ErrorException( 'Usuario existe');
            }
            return response_data($user->with('people')->get(), Response::HTTP_OK, 'Usuario Leído correctamente.');

        } catch (\Exception $ex) {
            return response_data([], Response::HTTP_INTERNAL_SERVER_ERROR, $ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        try {

            $user = User::find($id);
            if (empty($user)) {
                throw new \ErrorException( 'Usuario existe');
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            if ($user->people) {
                $user->people->name = $request->name;
                $user->people->phone = $request->phone;
                $user->people->email = $request->email;
                $user->people->address = $request->address;

                $user->people->save();
            }

            return response_data($user, Response::HTTP_OK, 'Usuario Actualizado correctamente.');

        } catch (\Exception $ex) {
            return response_data([], Response::HTTP_INTERNAL_SERVER_ERROR, $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        try {

            $user = User::find($id);
            if (empty($user)) {
                throw new \ErrorException( 'Usuario existe');
            }

            $user->people->delete();
            $user->delete();

            return response_data($user, Response::HTTP_OK, 'Usuario Eliminado correctamente.');

        } catch (\Exception $ex) {
            return response_data([], Response::HTTP_INTERNAL_SERVER_ERROR, $ex->getMessage());
        }
    }
}
