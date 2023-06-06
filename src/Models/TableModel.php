<?php

declare(strict_types=1);

namespace adRespect\Models;

use adRespect\Interfaces\TableNBP;

readonly class TableModel implements TableNBP
{
    private string $type;
    private string $tableNumber;
    private string $publicationDate;
    private array $rates;

    /**
     * @description It converts the response from the API into data.
     * @param string $response
     */
    public function __construct(string $response)
    {
        $data = json_decode($response, true);
        $data = $data[0];

        $this->type = $data['table'];
        $this->tableNumber = $data['no'];
        $this->publicationDate = $data['effectiveDate'];
        $this->rates = $data['rates'];
    }

    /**
     * @description Table type.
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @description  Table number.
     * @return string
     */
    public function getTableNumber(): string
    {
        return $this->tableNumber;
    }

    /**
     * @description  Publication date.
     * @return string
     */
    public function getPublicationDate(): string
    {
        return $this->publicationDate;
    }

    /**
     * @description A list of exchange rates of particular currencies in the table.
     * @return array
     */
    public function getRates(): array
    {
        return $this->rates;
    }
}