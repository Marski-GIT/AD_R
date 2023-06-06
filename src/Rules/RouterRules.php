<?php

declare(strict_types=1);

namespace adRespect\Rules;

final class RouterRules
{
    public static array $rules = [];

    public static function set(string $group, string $pattern, array $links, array $params = [], array $type = []): void
    {
        self::$rules[$group]['pattern'] = $pattern;
        self::$rules[$group]['links'] = $links;
        self::$rules[$group]['params'] = $params;
        self::$rules[$group]['types'] = $type;
    }

    /**
     * @description Returns a link for the selected group and route.
     * @param string $group Route group.
     * @param string $link Route key parameter.
     * @return string
     */
    public static function viewLink(string $group, string $link): string
    {
        return getenv('SITE_URL') . self::$rules[$group]['links'][$link][0];
    }

    public static function getRute(string $group, string $link): string
    {
        return self::$rules[$group]['links'][$link][0];
    }
}

/**
 * @description Route group.
 */
RouterRules::set('page', '<page>', [
    'home'         => ['', 'home'],
    'calculation'  => ['kalkulator', 'calculation'],
    'updateCurses' => ['aktualizuj-kursy', 'updateCurses'],
], [
    'page'   => 'page',
    'action' => 'action',
]);