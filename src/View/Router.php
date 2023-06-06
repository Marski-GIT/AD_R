<?php

declare(strict_types=1);

namespace adRespect\View;

use adRespect\Rules\RouterRules;

final class Router
{
    private const REGEX_SEGMENT = '[^/.,;?\n]++';
    private string $url;
    private array $RouterRules;
    private array $route;

    public function __construct()
    {
        $this->route = [
            'action' => 'home',
        ];
        $this->RouterRules = RouterRules::$rules;
        $this->url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $this->compile();
    }

    public function queryUrl(): array
    {
        return $this->route;
    }

    private function compile(): void
    {
        $this->url = trim(str_replace(getenv('SITE_URL'), '', $this->url));
        foreach ($this->RouterRules as $keyRules => $valueRules) {
            if (str_contains($valueRules['pattern'], '(')) {
                $this->RouterRules[$keyRules]['pattern'] = str_replace(['(', ')'], ['(?:', ')?'], $this->RouterRules[$keyRules]['pattern']);
            }

            $this->RouterRules[$keyRules]['pattern'] = str_replace(['<', '>'], ['(?P<', '>' . self::REGEX_SEGMENT . ')'], $this->RouterRules[$keyRules]['pattern']);
            if (preg_match('#^' . $this->RouterRules[$keyRules]['pattern'] . '$#uD', $this->url, $pregResult)) {
                foreach ($valueRules['params'] as $keyParams => $valueParams) {
                    if (!isset($pregResult[$keyParams])) {
                        $this->route[$keyParams] = $this->castNumber($valueParams);
                    } else {
                        $this->route[$keyParams] = $this->castNumber($pregResult[$keyParams]);
                    }

                    if (isset($this->RouterRules[$keyRules]['types'][$keyParams])) {
                        if (!preg_match('#^' . $this->RouterRules[$keyRules]['types'][$keyParams] . '$#', $this->route[$keyParams])) {
                            $this->RouterRules = [];
                            continue 2;
                        }
                    }
                }

                foreach ($valueRules['links'] as $valueLinks) {
                    if ($this->isArray($valueLinks)) {
                        $this->route['action'] = $valueLinks[1];
                    }
                }
            }
        }
    }

    private function castNumber(mixed $value): float|int|string
    {
        if (is_numeric($value)) {
            if (is_float($value)) return (float)$value;
            return (int)$value;
        }
        return $value;
    }

    private function isArray($valueLinks): bool
    {
        foreach ($valueLinks as $links) {
            if (str_contains($this->url, $links)) {
                return true;
            }
            return false;
        }
    }
}
