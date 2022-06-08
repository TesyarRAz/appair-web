<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CustomerDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customer\ImportCustomerRequest;
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

        if (blank($data['password']))
            unset($data['password']);

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

    public function import(ImportCustomerRequest $request)
    {
        $request->validated();

        $data = $request->berkas->get();

        $rows = explode(PHP_EOL, trim($data));

        $result = [];

        foreach ($rows as $row)
        {
            if (empty(trim($row))) continue;
            
            $cells = explode($request->delimiter, trim($row));

            if (count($cells) < 2)
            {
                return back()->with('status', 'Cell CSV minimal 2, untuk nama dan email');
            }
            
            // Filter Jika Rows Kosong, Bisa diskip
            $empty_cells = false;
            for ($i=0; $i<3; $i++)
            {
                if (empty($cells[$i]))
                {
                    $empty_cells = true;
                }
            }

            if ($empty_cells) continue;
            // end

            $result[] = [
                'name' => trim($cells[0]),
                'email' => trim($cells[1]),
                'opsional' => [
                    'username' => isset($cells[2]) && !empty($cells[2]) ? $cells[2] : null,
                    'password' => isset($cells[3]) && !empty($cells[3]) ? $cells[3] : null,
                ]
            ];
        }

        foreach ($result as $d)
        {
            $user = User::create([
                'name' => $d['name'],
                'email' => $d['email'],
                'username' => $d['opsional']['username'] ?? ($d['opsional']['email'] ?? str()->random(6)),
                'password' => $d['opsional']['password'] ?? ($d['opsional']['email'] ?? str()->random(6)),
            ]);

            $user->assignRole('customer');

            $user->customer()->create();
        }

        return back()->with('status', 'Berhasil import guru');
    }
}
