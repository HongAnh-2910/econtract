<?php

namespace App\Http\Controllers;

use App\Http\Actions\FileAction;
use App\Http\Requests\UploadFileRequest;
use App\Models\Application;
use App\Models\Contract;
use App\Models\File;
use App\Traits\UploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response as ResponseHttp;
use Intervention\Image\Facades\Image;

class FileController extends Controller
{
    use UploadTrait;

    protected $fileAction;
    private $file;

    public function __construct(
        FileAction $fileAction,
        File       $file
    )
    {
        $this->fileAction = $fileAction;
        $this->file = $file;
    }

    public function store(UploadFileRequest $request)
    {
        return $this->fileAction->create($request);
    }

    public function destroy($id): RedirectResponse
    {
        $this->fileAction->delete($id);

        return redirect()->back();
    }

    public function downloadFile($filename)
    {
        $path = storage_path() . '/' . 'uploads/' . $filename;
        if (file_exists($path)) {
            return response()->download($path);
        }

        abort(404);
    }

    public function downloadZipFile($contractId)
    {
        $files = File::where('contract_id', $contractId)->get();
        $fileContracts = File_contract::where('contract_id', $contractId)->get();
        $contractName = Contract::find($contractId)->code;
        $zipFileName = $contractName . '.zip';
        $zip = new \ZipArchive();
        if ($zip->open(public_path($zipFileName), \ZipArchive::CREATE) === TRUE) {
            if (count($files) > 0) {
                foreach ($files as $file) {
                    $filename = substr($file->name, strpos($file->name, '_') + 1, strlen($file->name));
                    $path = storage_path() . '/' . 'uploads/' . $file->name;
                    $zip->addFile($path, $filename);
                }
            } elseif (count($fileContracts) > 0) {
                foreach ($fileContracts as $files) {
                    $file = File::find($files->file_id);
                    $filename = substr($file->name, strpos($file->name, '_') + 1, strlen($file->name));
                    $path = storage_path() . '/' . 'uploads/' . $file->name;
                    $zip->addFile($path, $filename);
                }
            }
            $zip->close();
            return response()->download($zipFileName)->deleteFileAfterSend(true);
        }
        abort(404);
    }

    public function downloadApplicationFile($applicationId)
    {
        $application = Application::findOrFail($applicationId);
        $files = $application->files;
        $zipFileName = 'Download.zip';
        $zip = new \ZipArchive();
        if ($zip->open(public_path($zipFileName), \ZipArchive::CREATE) === TRUE) {
            foreach ($files as $file) {
                $filename = substr($file->name, strpos($file->name, '_') + 1, strlen($file->name));
                $path = storage_path() . '/' . 'applications/' . $file->name;
                $zip->addFile($path, $filename);
            }
            $zip->close();
            return response()->download($zipFileName)->deleteFileAfterSend(true);
        }
        abort(404);
    }

    public function previewPdf(Request $request, $filename)
    {
        $path = storage_path('uploads/' . $filename);
        $user = Auth::user();
        if ($request->status != config('statuses.trash')) {
            $file = $this->file::where('name', $filename)->first();
        } else {
            $file = $this->file::onlyTrashed()->where('name', $filename)->first();
        }

        if (!$file) {
            abort(404);
        }
        $fileShare = $file->userFile()->where('user_id', $user->id)->exists();
        if (file_exists($path) && $file) {
            if ($fileShare || $file->user_id == $user->id) {
                return ResponseHttp::make(file_get_contents($path), 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $filename . '"'
                ]);
            }

            abort(404);
        }

        abort(404);
    }

    public function signaturePreviewPdf($id)
    {
        $file = File::find($id);
        $path = storage_path('uploads/' . $file->name);
        return ResponseHttp::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $file->name . '"'
        ]);
    }

    public function getImageFromStorage($filename)
    {
        $storagePath = storage_path('uploads/' . $filename);

        return Image::make($storagePath)->response();
    }

    public function forceDestroy($id): RedirectResponse
    {
        $this->fileAction->forceDelete($id);

        return redirect()->back();
    }

    public function restore($id): RedirectResponse
    {
        $this->fileAction->restore($id);

        return redirect()->back();
    }

    public function updatePermission(Request $request, $id)
    {
        $this->fileAction->updatePermission($request, $id);

    }

    public function multipleDelete(Request $request): RedirectResponse
    {
        $this->fileAction->multipleDelete($request);

        return redirect()->back();
    }
}
