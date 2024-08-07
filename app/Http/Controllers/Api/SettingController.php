<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Settings\GeneralSetting;
use App\Settings\PriceSetting;
use App\Settings\StyleSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $setting = resolve(PriceSetting::class);
        $general = resolve(GeneralSetting::class);
        $style = resolve(StyleSetting::class);

        return response()->json([
            'price' => $setting->toArray(),
            'general' => $general->toArray(),
            'style' => $style->toArray(),
        ]);
    }
}
