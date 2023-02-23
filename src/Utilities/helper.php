<?php

use \Illuminate\Http\UploadedFile;

if (!function_exists('uploadFile')) {
    function uploadFile(UploadedFile $uploadedFile, $fileName = null, $folder = null, $disk = 'public')
    {
        $fileRef = [];
        $whitelistExtension = !empty(config('filesystems.whitelist')) ? config('filesystems.whitelist') : ["jpg", "jpeg", "png", "bmp", "pdf"];
        $extension = strtolower($uploadedFile->getClientOriginalExtension());

        $whitelistExtensionList = collect($whitelistExtension)->map(fn ($ext) => strtoupper($ext))->join(' / ');
        if (!in_array($extension, $whitelistExtension)) abort(422, "Fail berformat " . strtoupper($extension) . " tidak dapat diproses. Sila muat naik fail berformat $whitelistExtensionList sahaja.");

        if (!$uploadedFile->getSize() || $uploadedFile->getSize() >= UploadedFile::getMaxFilesize()) abort(422, "Saiz fail terlalu besar. Sila muat naik fail bersaiz 100MB atau lebih kecil.");

        $fileRef['path'] = $uploadedFile->store($folder, $disk);
        if (!$fileRef['path']) abort(500, "Gagal memuat naik fail.");
        $fileRef['name'] = empty($fileName) ? pathinfo($fileRef['path'], PATHINFO_FILENAME) : $fileName;

        // !!important: Image optimization required synchronous operation. resources does not exist yet
        // $fileRef['path'] = optimizeImage($fileRef['path']);

        // \App\Jobs\OptimizePdf::dispatch($fileRef['path']);

        return $fileRef;
    }
}

if (!function_exists('uploadFiles')) {
    function uploadFiles(array $uploadedFiles, $fileName = null, $folder = null, $disk = 'public')
    {
        $fileRefs = [];
        foreach ($uploadedFiles as $key => $uploadedFile) {
            $fileRefs[] = uploadFile($uploadedFile, $fileName . " $key", $folder, $disk);
        }
        return $fileRefs;
    }
}
