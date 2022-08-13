<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\Settings\StyleSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class InfoController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $info)
    {
        $code = Crypt::decryptString($info);

        $info = Info::find($code);

        $style = resolve(StyleSetting::class);

        return view('info', compact('info', 'style'));
    }
}
