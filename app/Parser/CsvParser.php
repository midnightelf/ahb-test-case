<?php

namespace App\Parser;

use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class CsvParser
{
    private $stream;
    private array $records;

    public function __construct(
        private string $path,
        private string $separator = ";",
        private string $enclosure = "'",
    ) {
        $this->setStream();
        $this->resolveRecords();
    }

    protected function setStream(): void
    {
        $this->stream = $this->getStream();
    }

    /**
     * @throws FileNotFoundException
     * @return resource
     */
    protected function getStream()
    {
        $resource = fopen($this->path, "r");

        if (!$resource) {
            throw new FileNotFoundException($this->path);
        }

        return $resource;
    }

    protected function closeStream(): bool
    {
        return fclose($this->stream);
    }

    protected function resolveRecords(): void
    {
        $handle = $this->getStream();
        $data = [];
        $records = [];

        if ($handle !== false) {
            while (($data = $this->getCsv()) !== false) {
                $records[] = $data;
            }

            $this->closeStream();
        }

        $this->records = $records;
    }

    public function getRecords(): array
    {
        return $this->records;
    }

    protected function getCsv(): array|false
    {
        return fgetcsv(
            stream: $this->stream,
            separator: $this->separator,
            enclosure: $this->enclosure,
        );
    }
}
