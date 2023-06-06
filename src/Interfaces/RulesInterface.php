<?php

declare(strict_types=1);

namespace adRespect\Interfaces;

interface RulesInterface
{
    public static function validation(array $data): array;
}