<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\InfoDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Info\StoreInfoRequest;
use App\Http\Requests\Admin\Info\UpdateInfoRequest;
use App\Http\Requests\Other\CKEditorUploadImageRequest;
use App\Jobs\UploadFile;
use App\Models\Info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class InfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InfoDataTable $dataTable)
    {
        return $dataTable->render('admin.info.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInfoRequest $request)
    {
        $data = $request->validated();

        $data['image'] = UploadFile::dispatchSync($request->file('image'), 'images/info');

        $info = Info::create($data);

        if (blank($data['url']))
        {
            $info->update(['url' => route('info', Crypt::encryptString($info['id']))]);
        }

        alert()->success('Info created successfully.', 'Success');

        return to_route('admin.info.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function show(Info $info)
    {
        return response($info);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function edit(Info $info)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInfoRequest $request, Info $info)
    {
        $data = $request->validated();

        if ($request->hasFile('image'))
        {
            $data['image'] = UploadFile::dispatchSync($request->file('image'), 'images/info');
        }
        
        if (blank($data['url']))
        {
            $info->update(['url' => route('info', Crypt::encryptString($info['id']))]);
        }

        $info->update($data);

        alert()->success('Info updated successfully.', 'Success');

        return to_route('admin.info.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function destroy(Info $info)
    {
        $info->delete();

        alert()->success('Info deleted successfully.', 'Success');

        return to_route('admin.info.index');
    }

    public function upload(CKEditorUploadImageRequest $request)
    {
        $data = $request->validated();

        $data['upload'] = dispatch_sync(resolve(UploadFile::class, [
            'file' => $data['upload'],
            'folder' => 'images/info',
        ]));

        $function_number = $request->CKEditorFuncNum;

        return response("<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '" . Storage::disk('public')->url($data['upload']) ."', '');</script>");
    }
}
