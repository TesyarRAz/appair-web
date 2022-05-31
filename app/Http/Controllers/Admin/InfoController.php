<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\InfoDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Info\StoreInfoRequest;
use App\Http\Requests\Admin\Info\UpdateInfoRequest;
use App\Models\Info;
use Illuminate\Http\Request;
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

        if ($request->hasFile('image')) {
            $data['image'] = $request->image
            ->storeAs(
                implode('/', [
                    'images',
                    'info',
                ]),
                $request->image->hashName(),
                'public',
            );
        }

        Info::create($data);

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

        if ($request->hasFile('image')) {
            $data['image'] = $request->image
            ->storeAs(
                implode('/', [
                    'images',
                    'info',
                ]),
                $request->image->hashName(),
                'public',
            );
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

    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|file',
            'CKEditorFuncNum' => 'required|numeric'
        ]);

        $response = $request->upload
        ->storeAs(
            implode('/', [
                'images',
                'info',
            ]),
            $request->upload->hashName(),
            'public',
        );

        $function_number = $request->CKEditorFuncNum;

        return response("<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '" . Storage::disk('public')->url($response) ."', '');</script>");
    }
}
