<?php

declare(strict_types=1);

namespace adRespect\Rules;

use adRespect\Exceptions\CalculatorException;
use adRespect\Interfaces\RulesInterface;

final class CurrencyCalculatorRules implements RulesInterface
{
    const PATTERN_EXCHANGE_RATE = '/^[0-9]*(,[0-9]{0,2})?$/';
    const PATTERN_CURRENCY_NAMES = '/^[\w ]{3}$/';
    private static array $validData = [];

    /**
     * @description Validates the passed values.
     * @throws CalculatorException
     */
    public static function validation(array $data): array
    {
        if (empty($_POST)) {
            throw new CalculatorException('Wpisz wartości do wyliczenia.', 400);
        }

        foreach ($data['currency'] as $key => $value) {
            $value = trim($value);
            self::checkCurrencyNames($value);
            self::$validData['currency'][$key] = strtoupper($value);
        }

        $value = trim($data['amount'][0]);
        self::checkAmount($value);
        self::$validData['amount'] = self::castNumber($value);

        return self::$validData;
    }

    /**
     * @description Validates the amount.
     * @throws CalculatorException
     */
    private static function checkAmount($value): void
    {
        $match = (bool)preg_match(self::PATTERN_EXCHANGE_RATE, $value);

        if (!$match) {
            throw new CalculatorException('Wpisana wartość powinna byś dodania. Dopuszcza się dwa miejsca po przecinku.', 400);
        }
    }

    /**
     * @description Validates currency name.
     * @throws CalculatorException
     */
    private static function checkCurrencyNames($value): void
    {
        $match = (bool)preg_match(self::PATTERN_CURRENCY_NAMES, $value);

        if (!$match) {
            throw new CalculatorException('Wybierz walutę.', 400);
        }
    }

    /**
     * @description Casts a value to a number.
     * @param mixed $value
     * @return float|int|string
     */
    private static function castNumber(mixed $value): float|int|string
    {
        $value = str_replace(',', '.', $value);

        if (is_numeric($value)) {
            if (strpos($value, '.')) return (float)$value;
            return (int)$value;
        }
        return $value;
    }
}