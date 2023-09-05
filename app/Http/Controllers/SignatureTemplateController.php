<?php

namespace App\Http\Controllers;

use App\Http\Actions\SignatureTemplateAction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SignatureTemplateController extends Controller
{
    protected $signatureTemplateAction;

    public function __construct(SignatureTemplateAction $signatureTemplateAction)
    {
        $this->signatureTemplateAction = $signatureTemplateAction;
    }

    public function index(Request $request)
    {
        $signatureTemplateData = $this->signatureTemplateAction->show($request->status);
        return view('dashboard.profile.signature_list', compact('signatureTemplateData'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->signatureTemplateAction->create($request);
        return redirect()->back();
    }

    public function addImage(Request $request)
    {
        $file = $request->file;
        $fileSize = $file->getSize();
        $fileSizeByKb = number_format($fileSize / 1024, 2);
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        $file->move(base_path('storage/signature_images'), $fileName);
        $url = storage_path('signature_images/' . $fileName);
        $newFile = File::create([
            'name' => $request->name,
            'path' => $url,
            'user_id' => Auth::user()->id,
        ]);
        $fileContent = base64_encode(file_get_contents($url));
    }

    public function destroy($id): RedirectResponse
    {
        $this->signatureTemplateAction->delete($id);
        return redirect()->back();
    }

    public function restore($id): RedirectResponse
    {
        $this->signatureTemplateAction->restore($id);
        return redirect()->back();
    }
}
