<?php

declare(strict_types=1);

namespace adRespect\Enums;

enum HttpCode: int
{
    case CODE_100 = 100;
    case CODE_101 = 101;
    case CODE_103 = 103;
    case CODE_200 = 200;
    case CODE_201 = 201;
    case CODE_202 = 202;
    case CODE_203 = 203;
    case CODE_204 = 204;
    case CODE_205 = 205;
    case CODE_206 = 206;
    case CODE_300 = 300;
    case CODE_301 = 301;
    case CODE_302 = 302;
    case CODE_303 = 303;
    case CODE_304 = 304;
    case CODE_305 = 305;
    case CODE_307 = 307;
    case CODE_308 = 308;
    case CODE_400 = 400;
    case CODE_401 = 401;
    case CODE_402 = 402;
    case CODE_403 = 403;
    case CODE_404 = 404;
    case CODE_405 = 405;
    case CODE_406 = 406;
    case CODE_407 = 407;
    case CODE_408 = 408;
    case CODE_409 = 409;
    case CODE_410 = 410;
    case CODE_411 = 411;
    case CODE_412 = 412;
    case CODE_413 = 413;
    case CODE_414 = 414;
    case CODE_415 = 415;
    case CODE_416 = 416;
    case CODE_417 = 417;
    case CODE_418 = 418;
    case CODE_425 = 425;
    case CODE_426 = 426;
    case CODE_500 = 500;
    case CODE_501 = 501;
    case CODE_502 = 502;
    case CODE_503 = 503;
    case CODE_504 = 504;
    case CODE_505 = 505;

    public static function getText(int $code): string
    {
        return match ($code) {
            self::CODE_100->value => 'Continue',
            self::CODE_101->value => 'Switching Protocols',
            self::CODE_103->value => 'Early Hints',
            self::CODE_200->value => 'OK',
            self::CODE_201->value => 'Created',
            self::CODE_202->value => 'Accepted',
            self::CODE_203->value => 'Non-Authoritative Information',
            self::CODE_204->value => 'No Content',
            self::CODE_205->value => 'Reset Content',
            self::CODE_206->value => 'Partial Content',
            self::CODE_300->value => 'Multiple Choices',
            self::CODE_301->value => 'Moved Permanently',
            self::CODE_302->value => 'Moved Temporarily',
            self::CODE_303->value => 'See Other',
            self::CODE_304->value => 'Not Modified',
            self::CODE_305->value => 'Use Proxy',
            self::CODE_307->value => 'Temporary Redirect',
            self::CODE_308->value => 'Permanent Redirect',
            self::CODE_400->value => 'Bad Request',
            self::CODE_401->value => 'Unauthorized',
            self::CODE_402->value => 'Payment Required',
            self::CODE_403->value => 'Forbidden',
            self::CODE_404->value => 'Not Found',
            self::CODE_405->value => 'Method Not Allowed',
            self::CODE_406->value => 'Not Acceptable',
            self::CODE_407->value => 'Proxy Authentication Required',
            self::CODE_408->value => 'Request Time-out',
            self::CODE_409->value => 'Conflict',
            self::CODE_410->value => 'Gone',
            self::CODE_411->value => 'Length Required',
            self::CODE_412->value => 'Precondition Failed',
            self::CODE_413->value => 'Request Entity Too Large',
            self::CODE_414->value => 'Request-URI Too Large',
            self::CODE_415->value => 'Unsupported Media Type',
            self::CODE_416->value => 'Range Not Satisfiable',
            self::CODE_417->value => 'Expectation Failed',
            self::CODE_418->value => 'I\'m a teapot',
            self::CODE_425->value => 'Too Early',
            self::CODE_426->value => 'Upgrade Required',
            self::CODE_500->value => 'Internal Server Error',
            self::CODE_501->value => 'Not Implemented',
            self::CODE_502->value => 'Bad Gateway',
            self::CODE_503->value => 'Service Unavailable',
            self::CODE_504->value => 'Gateway Time-out',
            self::CODE_505->value => 'HTTP Version not supported',
            default               => exit('Unknown http status code "' . htmlentities((string)$code) . '"'),
        };
    }
}
