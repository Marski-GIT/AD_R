<?php

declare(strict_types=1);

namespace adRespect\Middlewares;

final class Escape
{
    private static array $exceptions = ['pagination'];

    /**
     * @description Escape HTML characters for the view.
     * @param mixed $data
     * @return bool|array|string
     */
    public static function view(mixed $data): bool|array|string
    {
        $type = gettype($data);
        return match ($type) {
            'array'  => self::escapeArray($data),
            'string' => self::escapeString($data),
            default  => $data
        };
    }

    /**
     * @description Searching for a string in an array.
     * @param array $params
     * @return array
     */
    private static function escapeArray(array $params): array
    {
        $clearParams = [];
        foreach ($params as $key => $param) {

            if (in_array($key, self::$exceptions)) {
                $clearParams[$key] = $param;
                continue;
            }

            $type = gettype($param);
            $clearParams[$key] = match ($type) {
                'array'  => self::escapeArray($param),
                'string' => self::escapeString($param),
                default  => $param
            };
        }
        return $clearParams;
    }

    /**
     * @description Escapes HTML characters found in a string.
     * @param string $data
     * @return string
     */
    private static function escapeString(string $data): string
    {
        $data = trim($data);
        return htmlspecialchars($data, ENT_IGNORE, 'UTF-8');
    }
}