<?php

declare(strict_types=1);

if (!function_exists('isLocalStand')) {
    function isLocalStand(): bool
    {
        return (string) config('app.env') === \App\Dictionary::APPLICATION_STAND_LOCAL;
    }
}
if (!function_exists('isStageStand')) {
    function isStageStand(): bool
    {
        return (string) config('app.env') === \App\Dictionary::APPLICATION_STAND_STAGING;
    }
}
if (!function_exists('isProductionStand')) {
    function isProductionStand(): bool
    {
        return (string) config('app.env') === \App\Dictionary::APPLICATION_STAND_PRODUCTION;
    }
}
if (!function_exists('phoneToFormat')) {
    /**
     * Приводит номер телефона к переданному формату
     * @author CoderYooda
     * @param string $phone
     * @param string $format
     * @return string|array|null
     */
    function phoneToFormat(string $phone, string $format = '7XXXXXXXXXX'): string|array|null
    {
        // Совпадение с префиксом
        $prefixMatch = [];
        $parsedPhone = $phone;
        $digitPattern = '#[0-9]#';
        $digitsMatch = [];

        // Привычная длина телефона
        // в данном регионе с префиксом
        $usualPhoneLengthWithPrefix = 11;

        preg_match($digitPattern, $parsedPhone, $prefixMatch);
        preg_match_all($digitPattern, $parsedPhone, $digitsMatch);

        // Количество цифр в переданной строке
        // соответствует привычному
        $digitsCountMatchesUsual = count($digitsMatch[0]) === $usualPhoneLengthWithPrefix;

        if (!empty($prefixMatch) && $digitsCountMatchesUsual) {
            // убираем префикс в виде семерки или восьмерки

            if ((int) $prefixMatch[0] === 7 || (int) $prefixMatch[0] === 8) {
                $parsedPhone = preg_replace($digitPattern, '', $phone, 1);
            }
        }

        $digits = [];
        preg_match_all($digitPattern, $parsedPhone, $digits);
        $digits = $digits[0];

        $formattedPhone = $format;
        while ($pos = stripos($formattedPhone, 'X') !== false) {
            $formattedPhone = preg_replace('~X~', array_shift($digits), $formattedPhone, 1);
        }

        return $formattedPhone;
    }
}
if (!function_exists('morph')) {
    /**
     * Склоняем словоформу | 1 штука  2 штуки  5 штук
     * @author CoderYooda
     * @param $n
     * @param $f1
     * @param $f2
     * @param $f5
     * @return mixed
     */
    function morph($n, $f1, $f2, $f5): mixed
    {
        $n = abs((int) $n) % 100;
        if ($n > 10 && $n < 20) {
            return $f5;
        }

        $n = $n % 10;
        if ($n > 1 && $n < 5) {
            return $f2;
        }

        if ((int) $n === 1) {
            return $f1;
        }

        return $f5;
    }
}
if (!function_exists('translit')) {
    /**
     * транслит строки
     *
     * @author CoderYooda
     * @param string $str
     * @return string
     */
    function translit(string $str): string
    {
        $converter = [
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        ];

        return strtr($str, $converter);
    }
}
if (!function_exists('toSlug')) {
    /**
     * Slug строки
     *
     * @author CoderYooda
     * @param string $str
     * @return string
     */
    function toSlug(string $str): string
    {
        $slug = translit($str);
        $slug = preg_replace( "/[^a-zA-ZА-Яа-я0-9\s]+/u", '', $slug );
        $slug = str_replace( " ", '', $slug );
        $slug = strtolower($slug);

        return trim($slug);
    }
}
