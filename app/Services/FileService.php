<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FileService
{
    private $storage;

    public function __construct()
    {
        $this->storage = Storage::disk('public');
    }

    public function upload($file, $filePath)
    {
        try {
            if ($file instanceof UploadedFile) {
                $originName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $originExtension = $file->getClientOriginalExtension();

                preg_match('/.([0-9]+) /', microtime(), $uniqid);
                $fileName = sprintf($originName . '_%s.%s', date('Ymd') . $uniqid[1], $originExtension);
                $this->storage->putFileAs($filePath, $file, $fileName);

                return $fileName;
            }
        } catch (\Exception $exception) {
            writeLogging($exception);
        }

        return false;
    }

    public function delete($file)
    {
        try {
            if ($file) {
                $path = config('setting.directory_uploads');
                $result = $this->storage->delete("$path$file");
                return $result;
            }
        } catch (\Throwable $th) {
            writeLogging($th);
        }
        return false;
    }

    public function zip($files, $zipname)
    {
        try {
            $zip = new ZipArchive();
            $prefix = $this->storage->getAdapter()->getPathPrefix().config('setting.directory_uploads');
            $zipname = $prefix.$zipname;
            $zip->open($zipname, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            foreach ($files as $file) {
                if ($file) {
                    $zip->addFile($prefix.$file, $file);
                }
            }
            $zip->close();
            return true;
        } catch (\Throwable $th) {
            writeLogging($th);
        }
        return false;
    }
}
