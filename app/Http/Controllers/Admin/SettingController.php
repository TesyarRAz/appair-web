<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdateGeneralRequest;
use App\Http\Requests\Admin\Setting\UpdateSettingPriceRequest;
use App\Http\Requests\Admin\Setting\UpdateStyleRequest;
use App\Jobs\NormalizeTool;
use App\Jobs\UploadFile;
use App\Settings\GeneralSetting;
use App\Settings\PriceSetting;
use App\Settings\StyleSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index', [
            'price' => resolve(PriceSetting::class),
            'style' => resolve(StyleSetting::class),
        ]);
    }

    public function update($setting)
    {
        abort_unless(in_array($setting, ['price', 'style', 'general']), 404);

        return app()->call([$this, 'update' . ucfirst(strtolower($setting))]);
    }

    public function tools($setting)
    {
        abort_unless(in_array($setting, ['normalize']), 404);

        return app()->call([$this, 'tools' . ucfirst(strtolower($setting))]);
    }

    public function updatePrice(UpdateSettingPriceRequest $request)
    {
        $data = $request->validated();

        resolve(PriceSetting::class)->fill($data)->save();
        
        alert()->success('Harga berhasil diperbarui');

        return to_route('admin.settings.index');
    }

    public function updateStyle(UpdateStyleRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('app_image')) {
            $data['app_image'] = UploadFile::dispatchSync($request->file('app_image'), 'styles');
        }

        if ($request->hasFile('bg_image')) {
            $data['bg_image'] = UploadFile::dispatchSync($request->file('bg_image'), 'styles');
        }

        resolve(StyleSetting::class)->fill($data)->save();

        alert()->success('Style berhasil diperbarui');

        return to_route('admin.settings.index');
    }

    public function updateGeneral(UpdateGeneralRequest $request)
    {
        $data = $request->validated();

        resolve(GeneralSetting::class)->fill($data)->save();

        alert()->success('Pengaturan berhasil diperbarui');

        return to_route('admin.settings.index');
    }

    public function toolsNormalize()
    {
        NormalizeTool::dispatch();

        alert()->success('Berhasil normalize data');

        return to_route('admin.settings.index');
    }
}
