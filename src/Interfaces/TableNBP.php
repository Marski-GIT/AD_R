<?php

declare(strict_types=1);

namespace adRespect\Interfaces;

interface  TableNBP
{
    public function __construct(string $request);

    public function getType(): string;

    public function getTableNumber(): string;

    public function getPublicationDate(): string;

    public function getRates(): array;
}