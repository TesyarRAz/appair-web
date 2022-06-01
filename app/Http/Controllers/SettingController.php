<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Setting\UpdateSettingPriceRequest;
use App\Settings\PriceSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index', [
            'price' => resolve(PriceSetting::class)
        ]);
    }

    public function update(Request $request, $setting)
    {
        abort_unless(in_array($setting, ['price']), 404);

        return app()->call([$this, 'update' . ucfirst(strtolower($setting))]);
    }

    public function updatePrice(UpdateSettingPriceRequest $request)
    {
        $data = $request->validated();

        resolve(PriceSetting::class)->fill($data)->save();
        
        alert()->success('Harga berhasil diperbarui');

        return to_route('admin.settings.index');
    }
}
