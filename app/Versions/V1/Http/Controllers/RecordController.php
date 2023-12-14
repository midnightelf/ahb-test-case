<?php

namespace App\Versions\V1\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Record\RecordStoreRequest;
use App\Jobs\Record\ImportCsvRecords;
use App\Versions\V1\Services\RecordService;

class RecordController extends Controller
{
    public function __construct(
        protected RecordService $service,
    ) {
    }

    public function bulkStore(RecordStoreRequest $request)
    {
        ImportCsvRecords::dispatch($this->service->storeRecordsFile($request->file('file')));
        
        return response(['message' => __('responses.success')]);
    }
}
