<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function mask_bad_words(?string $text): ?string
    {
        if ($text === null || $text === '') {
            return $text;
        }

        $badWords = ['fuck', 'shit', 'bitch', 'asshole', 'damn'];
        $pattern = '/(' . implode('|', array_map('preg_quote', $badWords)) . ')/i';

        return preg_replace_callback($pattern, function ($matches) {
            return str_repeat('*', strlen($matches[0]));
        }, $text);
    }
}
