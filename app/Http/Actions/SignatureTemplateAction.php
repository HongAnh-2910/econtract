<?php

namespace App\Http\Actions;


use App\Models\SignatureTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SignatureTemplateAction
{
    protected $signatureTemplate;

    public function __construct(SignatureTemplate $signatureTemplate)
    {
        $this->signatureTemplate = $signatureTemplate;
    }

    public function create($request)
    {
        if ($request->type != 2) {
            $newSignatureTemplate = $this->signatureTemplate->create([
                'name' => $request->name,
                'signature' => $request->signatureData,
                'user_id' => Auth::user()->id
            ]);
        } else {
            $file = $request->file;
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/signatures/'), $fileName);
            $newSignatureTemplate = $this->signatureTemplate->create([
                'name' => $request->name,
                'path' => $fileName,
                'type' => $request->type,
                'user_id' => Auth::user()->id,
            ]);
        }
        if ($newSignatureTemplate) {
            Session::flash('message', 'Tạo chữ ký thành công!');
        } else {
            Session::flash('error_message', 'Tạo chữ ký không thành công. Vui lòng kiểm tra lại!');
        }
    }

    public function show($status)
    {
        if ($status == config('statuses.trash')) {
            return $this->showDelete();
        } else {
            return $this->showRecord();
        }
    }

    public function delete($id)
    {
        $status = $this->signatureTemplate->find($id)->delete();
        if ($status) {
            Session::flash('message', 'Xoá chữ ký thành công!');
        } else {
            Session::flash('error_message', 'Xoá chữ ký không thành công. Vui lòng kiểm tra lại!');
        }
    }

    public function restore($id)
    {
        $status = $this->restoreRecord($id);
        if ($status) {
            Session::flash('message', 'Khôi phục chữ ký thành công!');
        } else {
            Session::flash('error_message', 'Khôi phục chữ ký không thành công. Vui lòng kiểm tra lại!');
        }
    }

    public function showDelete()
    {
        return $this->signatureTemplate->onlyTrashed()->where('user_id', Auth::user()->id)->get();
    }

    public function showRecord()
    {
        return Auth::user()->signatureTemplates->sortByDesc('created_at');
    }

    public function restoreRecord($id)
    {
        return $this->signatureTemplate->onlyTrashed()->where('id', $id)->restore();
    }
}
