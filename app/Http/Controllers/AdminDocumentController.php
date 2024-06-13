<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Datatables;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class AdminDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.document.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.document.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:documents',
        ];
        $messages = [
            'name.required' => 'Bạn phải nhập tên.',
            'name.unique' => 'Tên đã tồn tại.',
        ];
        $request->validate($rules,$messages);

        //Create new Document
        $document = new Document();
        $document->name = $request->name;
        $document->save();

        Alert::toast('Thêm loại giấy tờ mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.documents.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $document = Document::findOrFail($id);

        return view('admin.document.edit', ['document' => $document]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'name' => 'required|unique:departments,name,'.$id,
        ];
        $messages = [
            'name.required' => 'Bạn phải nhập tên.',
            'name.unique' => 'Tên đã tồn tại.',
        ];
        $request->validate($rules,$messages);

        //Update Document
        $document = Document::findOrFail($id);
        $document->name = $request->name;
        $document->save();

        Alert::toast('Sửa loại giấy tờ mới thành công!', 'success', 'top-right');
        return redirect()->route('admin.documents.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $document->destroy($id);

        Alert::toast('Xóa loại giấy tờ thành công!', 'success', 'top-right');
        return redirect()->route('admin.documents.index');
    }

    public function anyData()
    {
        $documents = Document::select(['id', 'name'])->orderBy('id', 'asc')->get();
        return Datatables::of($documents)
            ->addIndexColumn()
            ->editColumn('name', function ($documents) {
                return $documents->name;
            })
            ->addColumn('actions', function ($documents) {
                $action = '<a href="' . route("admin.documents.edit", $documents->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                           <form style="display:inline" action="'. route("admin.documents.destroy", $documents->id) . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" name="submit" onclick="return confirm(\'Bạn có muốn xóa?\');" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    <input type="hidden" name="_token" value="' . csrf_token(). '"></form>';
                return $action;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
