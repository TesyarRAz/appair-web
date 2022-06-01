<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CustomerDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customer\StoreCustomerRequest;
use App\Http\Requests\Admin\Customer\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request, CustomerDataTable $dataTable)
    {
        if ($request->ajax() && $request->type == 'select2') {
            return response(
                Customer::take(30)
                    ->with('user')
                    ->whereHas('user', function($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->get()
            );
        }

        return $dataTable->render('admin.customer.index');
    }

    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);
        $user->assignRole('customer');
        $user->customer()->create();

        alert()->success('Success', 'Customer created successfully');

        return to_route('admin.customer.index');
    }

    public function show(Customer $customer)
    {
        $customer->load('user');
        
        return response($customer);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $data = $request->validated();

        $customer->user->update($data);

        alert()->success('Success', 'Customer updated successfully');

        return to_route('admin.customer.index');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        $customer->user()->delete();

        alert()->success('Success', 'Customer deleted successfully');

        return to_route('admin.customer.index');
    }

    public function transaksi(Customer $customer)
    {
        $transaksis = $customer->transaksis()->latest()->get();

        return view('admin.customer.transaksi', compact('customer', 'transaksis'));
    }
}
