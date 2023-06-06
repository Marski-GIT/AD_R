<?php

declare(strict_types=1);

namespace adRespect\Models;

use adRespect\Exceptions\CalculatorException;

readonly class CurrencyCalculatorModel
{
    private int|float $amount;
    private int|float $currencyFrom;
    private int|float $currencyFor;

    public function __construct(array $rate, int|float $amount)
    {
        $this->currencyFrom = $rate['from'];
        $this->currencyFor = $rate['for'];

        $this->amount = $amount;
    }

    /**
     * @throws CalculatorException
     */
    public function calculate(): float|int
    {
        $temp = $this->amount * $this->currencyFrom;

        if ($this->currencyFrom === 0) {
            throw new CalculatorException('Dzielenie przez zero.', 400);
        }

        return $temp / $this->currencyFor;
    }
}