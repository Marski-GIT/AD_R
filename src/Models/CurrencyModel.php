<?php

declare(strict_types=1);

namespace adRespect\Models;

use adRespect\Exceptions\AppException;
use adRespect\Interfaces\TableNBP;
use adRespect\Middlewares\DB;
use mysqli;

readonly class CurrencyModel
{
    private mysqli $mysqli;

    /**
     * @throws AppException
     */
    public function __construct()
    {
        $this->mysqli = DB::connect();
    }

    /**
     * @description  Creates an entry in the database.
     * @param TableNBP $table
     * @return string Returns the running status
     */
    public function create(TableNBP $table): string
    {
        return $this->createTable($table);
    }

    /**
     * @description Generating a table with exchange rates.
     * @return array
     */
    public function read(): array
    {
        $result = $this->mysqli->query('SELECT table_number, table_type, DATE_FORMAT(effective_date, "%Y-%m-%d") AS effective_date, currency, code, mid FROM `currency_rate_type`
                                                LEFT JOIN exchange_rates ON exchange_rates.id_currency_rate_type = currency_rate_type.id_currency_rate_type 
                                                ORDER BY table_type, effective_date;');
        return [
            'rows' => $result->num_rows,
            'list' => $result->fetch_all(MYSQLI_ASSOC)
        ];
    }

    public function getCalculatedExchange(): array
    {
        $result = $this->mysqli->query('SELECT * FROM calculated_exchange_rate ORDER BY created_at DESC limit 10');

        return [
            'rows' => $result->num_rows,
            'list' => $result->fetch_all(MYSQLI_ASSOC)
        ];
    }

    public function setCalculatedExchange(int|float $calculation, int|float $rateFrom, array $request, $rateFor): int
    {
        $stmt = $this->mysqli->prepare('INSERT INTO calculated_exchange_rate (currency_from, currency_for, amount_from, amount_for, amount) VALUE (?,?,?,?,?)');
        $stmt->bind_param('ssddd', $request['currency']['from'], $request['currency']['for'], $rateFrom, $rateFor, $calculation);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function getExchangeRate(string $curseName): int|float
    {
        $stmt = $this->mysqli->prepare('SELECT mid FROM exchange_rates
                                                    LEFT JOIN currency_rate_type ON currency_rate_type.id_currency_rate_type = exchange_rates.id_currency_rate_type
                                                WHERE code = ?
                                                ORDER BY effective_date DESC limit 1');
        $stmt->bind_param('s', $curseName);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!!$result->num_rows) {
            $result = $result->fetch_assoc();
            return $result['mid'];
        }

        return 1;
    }

    public function getNames(): array
    {
        $data = [];
        $result = $this->mysqli->query('SELECT DISTINCT code, currency, table_type FROM exchange_rates
                                                LEFT JOIN currency_rate_type ON currency_rate_type.id_currency_rate_type = exchange_rates.id_currency_rate_type
                                                ORDER BY code');

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[$row['table_type']][] = $row;
            }
        }

        return [
            'rows' => $result->num_rows,
            'list' => $data
        ];
    }

    /**
     * @description Initiates adding data from the API.
     * @param TableNBP $table
     * @return string Process response.
     */
    private function createTable(TableNBP $table): string
    {
        $message = 'Baza zawiera aktualne kursy.';

        if ($this->checkNumberIsThere($table->getTableNumber())) {
            $id = $this->createRateType($table);
            if ($id) {
                $this->createExchangeRate($id, $table->getRates());
                $message = 'Poprawnie zaktualizowano kursy.';
            }
        }

        return $message;
    }

    /**
     * @description Checks if such a table already exists. If I don't add it.
     * @param string $tableNumber The ID of the retrieved table
     * @return bool
     */
    private function checkNumberIsThere(string $tableNumber): bool
    {
        $stmt = $this->mysqli->prepare('SELECT table_number FROM currency_rate_type WHERE table_number =?');
        $stmt->bind_param('s', $tableNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        return !$result->num_rows;
    }

    /**
     * @description Creates database entries with fetched table type and number.
     * @param TableNBP $table
     * @return int|bool
     */
    private function createRateType(TableNBP $table): int|bool
    {
        $tableNumber = $table->getTableNumber();
        $tableType = $table->getType();
        $tableEffectiveDate = $table->getPublicationDate();

        $stmt = $this->mysqli->prepare('INSERT INTO currency_rate_type (table_number, table_type, effective_date) VALUE (?,?,?)');
        $stmt->bind_param('sss', $tableNumber, $tableType, $tableEffectiveDate);
        $stmt->execute();

        return $stmt->insert_id;
    }

    /**
     * @description Creates database entries with fetched exchange rate values.
     * @param int $id The row ID from the table currency_rate_type
     * @param array $rates Exchange rate values
     * @return void
     */
    private function createExchangeRate(int $id, array $rates): void
    {
        $stmt = $this->mysqli->prepare('INSERT INTO exchange_rates (id_currency_rate_type, currency, code, mid) VALUE (?,?,?,?)');

        foreach ($rates as $row) {
            $stmt->bind_param('issd', $id, $row['currency'], $row['code'], $row['mid']);
            $stmt->execute();
        }
    }

}