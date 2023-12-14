<?php

namespace App\Http\Controllers;

use App\Http\Requests\Record\RecordStoreRequest;
use App\Jobs\Record\ImportCsvRecords;
use App\Versions\V1\Repositories\RecordRepository;
use App\Versions\V1\Services\RecordService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function __construct(
        protected RecordRepository $repository,
        protected RecordService $service,
    ) {
    }

    public function index(Request $request): View
    {
        $records = $this->repository->allLoadAdditional();

        return view('welcome', ['records' => $records]);
    }

    public function bulkStore(RecordStoreRequest $request): RedirectResponse
    {
        ImportCsvRecords::dispatch($this->service->storeRecordsFile($request->file('file')));

        return back()->with('message', __('responses.success'));
    }
}
