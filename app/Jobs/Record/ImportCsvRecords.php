<?php

namespace App\Jobs\Record;

use App\Builders\RecordAdditionalBuilder;
use App\Builders\RecordBuilder;
use App\Helpers\CsvHelper;
use App\Models\Record;
use App\Models\RecordAdditional;
use App\Parser\CsvParser;
use App\Versions\V1\Repositories\RecordRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ImportCsvRecords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected RecordBuilder $recordBuilder;
    protected RecordAdditionalBuilder $recordAdditionalBuilder;

    public function __construct(
        protected string $filepath,
    ) {
        $this->onQueue('import-csv-records');

        $this->recordBuilder = app(RecordBuilder::class);
        $this->recordAdditionalBuilder = app(RecordAdditionalBuilder::class);
    }

    public function handle(): void
    {
        $nextId = app(RecordRepository::class)->getNextId();
        $csv = new CsvParser($this->resolveFilepath());

        $plainRecords = $csv->getRecords();
        $plainHeaders = CsvHelper::normalizeHeaders(array_shift($plainRecords));

        $records = [];
        $recordsAdditional = [];

        foreach ($plainRecords as $record) {
            $records[] = ($newRecord = $this->buildRecord($record, ++$nextId))->toArray();
            $recordsAdditional[] = $this->buildRecordAdditional($record, $newRecord)->toArray();
        }
        /**
         * момент Г-оптимизации чтобы много мелких запросов
         * не отправлять в бд. лучше собрать и два крупных
         * запроса отправить.
         */
        $this->insertNewRecords($records, $recordsAdditional);
    }

    private function resolveFilepath(): string
    {
        return public_path('storage/' . $this->filepath);
    }

    private function buildRecord(array $record, int $nextId): Record
    {
        /**
         * в строгом случае с порядком заголовков
         * я бы взял индекс нужного заголовка сделав условно
         * Record::CSV_HEADERS<string, string> где 1ый это 
         * имя из CSV, а 2ой это имя колонки из таблицы.
         */
        return $this->recordBuilder
            ->setBuilderRecord(new Record)
            ->setId(++$nextId)
            ->setCode($record[0])
            ->setName($record[1])
            /**
             * вообще, можно было бы по нормальному 
             * сделать с этими уровнями. сделать мэни ту мэни
             * и таким образом связать а не просто в колонки запихнуть, иначе 
             * получается, что если надо будет уровни добавить, то придется 
             * еще колонку вводить что ли?? 
             */
            ->setLevel1($record[2])
            ->setLevel2($record[3])
            ->setLevel3($record[4])
            ->setPrice($record[5])
            ->setPriceSp($record[6])
            ->getBuilderRecord();
    }

    private function buildRecordAdditional(array $record, Record $newRecord)
    {
        return $this->recordAdditionalBuilder
            ->setBuilderRecordAdditional($newRecord->additional()->make())
            ->setCount($record[7])
            ->setProperties($record[8])
            ->setCanJointPurchases($record[9])
            ->setUnit($record[10])
            ->setImage($record[11])
            ->setCanDisplayOnMain($record[12])
            ->setDescription($record[13])
            ->getBuilderRecordAdditional();
    }


    private function insertNewRecords(array $records, array $additionals): void
    {
        DB::transaction(function () use ($records, $additionals) {
            Record::insert($records);
            RecordAdditional::insert($additionals);
        });
    }
}
