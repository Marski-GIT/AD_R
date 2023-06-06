<?php

declare(strict_types=1);

namespace adRespect\Models;

use adRespect\Exceptions\ApiException;
use adRespect\Interfaces\{ApiNBPInterface, TableNBP};
use CurlHandle;

readonly class ApiNBPModel implements ApiNBPInterface
{
    const API_URL = 'http://api.nbp.pl/api/exchangerates/tables/';
    private false|CurlHandle $curl;

    public function __construct()
    {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
        ]);
    }

    /**
     * @description fetches tables A from the NBP api.
     * @return TableNBP An object with table data.
     * @throws ApiException
     */
    function getTableA(): TableNBP
    {
        curl_setopt($this->curl, CURLOPT_URL, self::API_URL . 'A');
        $response = curl_exec($this->curl);
        $responseCode = (int)curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        curl_close($this->curl);

        if ($responseCode !== 200) {
            throw new ApiException('Błąd pobierania tabeli A NBP', $responseCode);
        }

        return new TableModel($response);
    }

    /**
     * @description fetches tables B from the NBP api.
     * @return TableNBP An object with table data.
     * @throws ApiException
     */
    public function getTableB(): TableNBP
    {
        curl_setopt($this->curl, CURLOPT_URL, self::API_URL . 'B');
        $response = curl_exec($this->curl);
        $responseCode = (int)curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        curl_close($this->curl);

        if ($responseCode !== 200) {
            throw new ApiException('Błąd pobierania tabeli B NBP', $responseCode);
        }

        return new TableModel($response);
    }
}