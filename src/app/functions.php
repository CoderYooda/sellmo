<?php

declare(strict_types=1);

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
