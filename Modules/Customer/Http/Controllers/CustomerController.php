<?php

namespace Modules\Customer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use App\Models\People;
use App\Models\Customer;
use App\Models\Business;

class CustomerController extends Controller
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

            return response_data($userBusiness->customers()->with('people')->get(), Response::HTTP_OK, 'Datos Leídos correctamente.');
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
        return view('customer::create');
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
            $people = People::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'email' => $request->email,
                'dni' => $request->dni
            ]);

            $customer = Customer::create([
                'business_id' => $business_id,
                'people_id' => $people->id
            ]);

            return response_data($people, Response::HTTP_CREATED, 'Cliente creado correctamente.');
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
        return view('customer::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        try {

            $customer = Customer::find($id);
            if (empty($customer)) {
                throw new \ErrorException( 'Cliente no existe');
            }

            $customer = $customer->people;
            return response_data($customer, Response::HTTP_OK, 'Cliente Leído correctamente.');

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

            $customer = Customer::find($id);
            if (empty($customer)) {
                throw new \ErrorException( 'Cliente no existe');
            }

            if ($customer->people) {
                $customer->people->name = $request->name;
                // $customer->people->dni = $request->dni;
                $customer->people->phone = $request->phone;
                $customer->people->email = $request->email;
                $customer->people->address = $request->address;

                $customer->people->save();
            }

            return response_data($customer->people, Response::HTTP_OK, 'Cliente Actualizado correctamente.');

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

            $customer = Customer::find($id);
            if (empty($customer)) {
                throw new \ErrorException( 'Cliente existe');
            }

            $customer->people->delete();
            $customer->delete();

            return response_data($customer, Response::HTTP_OK, 'Cliente Eliminado correctamente.');

        } catch (\Exception $ex) {
            return response_data([], Response::HTTP_INTERNAL_SERVER_ERROR, $ex->getMessage());
        }
    }
}
