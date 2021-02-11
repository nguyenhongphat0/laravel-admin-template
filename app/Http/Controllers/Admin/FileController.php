<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\FileService;

class FileController extends Controller
{
    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function preview($fileName = '')
    {
        if (!$fileContent = $this->getFileContent($fileName, config('setting.directory_uploads'))) {
            abort(404);
        }

        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $headers = [];

        if ($ext) {
            switch ($ext) {
                case 'pdf':
                    $headers = ['Content-Type' => 'application/pdf'];
                    break;
            }
        }

        return response()->stream(function () use ($fileContent) {
            echo $fileContent;
        }, 200, $headers);
    }

    protected function getFileContent($fileName, $url)
    {
        if (!$fileName) {
            return false;
        }

        $filePath = $url . '/' . $fileName;
        $storage = Storage::disk('public');

        if (!$storage->exists($filePath)) {
            return false;
        }

        return $storage->get($filePath);
    }

    public function upload(Request $request, $type = 'file')
    {
        $filePath = config('setting.directory_uploads');
        $name = 'fileUpload';

        if ($type == 'image') {
            $name = 'imageUpload';
        }

        if ($fileName = $this->fileService->upload($request->file($name), $filePath)) {
            return response()->json([
                'status' => 200,
                'fileName' => $fileName
            ]);
        }

        return response()->json();
    }

    public function blob($fileName)
    {
        $headers =[
            'Content-Type' => 'blob',
        ];
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if (strtolower($ext) == 'pdf') {
            $headers =[
                'Content-Type' => 'application/pdf',
            ];
        }
        if (!$fileContent = $this->getFileContent($fileName, config('setting.directory_uploads'))) {
            abort(404);
        }
        return response()->streamDownload(function () use ($fileContent) {
            echo $fileContent;
        }, null, $headers);
    }

    public function delete(Request $request)
    {
        $key = $request->input('key');
        return response()->json([
            'status' => 200,
        ]);
    }
}
