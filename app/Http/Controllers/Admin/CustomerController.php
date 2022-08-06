<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CustomerDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customer\ImportCustomerRequest;
use App\Http\Requests\Admin\Customer\StoreCustomerRequest;
use App\Http\Requests\Admin\Customer\UpdateCustomerRequest;
use App\Jobs\NormalizeTool;
use App\Models\Customer;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
                    ->when($request->with == 'latestTransaksi', function($query) {
                        $query->with('latestTransaksi');
                    })
                    ->get()
                    ->append('last_meter')
            );
        }

        return $dataTable->render('admin.customer.index');
    }

    public function store(StoreCustomerRequest $request)
    {
        $data = $request->validated();

        $customer_data = Arr::only($data, [
            'rt',
            'meteran_pertama',
        ]);

        Arr::forget($data, [
            'rt',
            'meteran_pertama',
        ]);

        $user = User::create($data);
        $user->assignRole('customer');
        $user->customer()->create($customer_data);

        NormalizeTool::dispatch();

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


        $customer_data = Arr::only($data, [
            'rt',
            'meteran_pertama',
        ]);

        Arr::forget($data, [
            'rt',
            'meteran_pertama',
        ]);

        $customer->user->update($data);
        $customer->update($customer_data);

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

            if (count($cells) < 3)
            {
                return back()->with('status', 'Cell CSV minimal 2, untuk nama, rt dan meteran akhir');
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
                'rt' => trim($cells[1]),
                'meteran_pertama' => trim($cells[2]),
                'opsional' => [
                    'email' => isset($cells[3]) && !empty($cells[3]) ? $cells[3] : null,
                    'username' => isset($cells[4]) && !empty($cells[4]) ? $cells[4] : null,
                    'password' => isset($cells[5]) && !empty($cells[5]) ? $cells[5] : null,
                ]
            ];
        }

        foreach ($result as $d)
        {
            $user = User::create([
                'name' => $d['name'],
                'email' => $d['opsional']['email'],
                'username' => $d['opsional']['username'] ?? ($d['opsional']['email'] ?? str()->snake($d['name']) . '_' . str()->random(4)),
                'password' => $d['opsional']['password'] ?? ($d['opsional']['email'] ?? bcrypt('123456')),
            ]);

            $user->assignRole('customer');

            $user->customer()->create([
                'rt' => $d['rt'],
                'meteran_pertama' => $d['meteran_pertama'],
            ]);
        }

        NormalizeTool::dispatch();

        return back()->with('status', 'Berhasil import customer');
    }
}
