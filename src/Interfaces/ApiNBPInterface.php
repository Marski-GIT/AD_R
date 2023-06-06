<?php

declare(strict_types=1);

namespace adRespect\Interfaces;

interface ApiNBPInterface
{
    public function getTableA(): TableNBP;

    public function getTableB(): TableNBP;
}