<?php

namespace App\Versions\V1\Services;

use Illuminate\Http\UploadedFile;

class RecordService
{
    public function storeRecordsFile(UploadedFile $file): string
    {
        return $file->storeAs('records', $this->getRecordCsvFilename($file), 'public');
    }

    private function getRecordCsvFilename(UploadedFile $file): string
    {
        return now()->format('Y.m.d-H:i:s') . ".{$file->getClientOriginalExtension()}";
    }
}
