<?php

namespace App\Services\API;

class ErrorCode
{
    // Общие xxx

    /** Некорректный запрос */
    public const BAD_REQUEST = 400;

    /** Требуется авторизация */
    public const UNAUTHORIZED = 401;

    /** Нет доступа */
    public const FORBIDDEN = 403;

    /** Не найдено */
    public const NOT_FOUND = 404;

    /** Метод не доступен из-за ограничений */
    public const NOT_ALLOWED = 405;

    /** Недоступно для клиента апи */
    public const NOT_ACCEPTABLE = 406;

    /** Ошибка ввода, невалидные данные */
    public const NOT_VALID = 422;

    /** Ошибка */
    public const SERVER_ERROR = 500;

    /** Сервис недоступен  */
    public const SERVICE_UNAVAILABLE = 503;
}
