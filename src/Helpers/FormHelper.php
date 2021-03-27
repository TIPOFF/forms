<?php

declare(strict_types=1);

/**
 * Convert a route slug into a dynamic controller name
 *
 * Example: 'on-the-run'
 * Output: OnTheRunController
 *
 * @param string $slug
 * @return string
 */
function toControllerSlug(String $slug)
{
    $words = explode('-', $slug);
    $name = '';
    foreach ($words as $word) {
        $name .= ucfirst($word);
    }
    return $name . 'Controller';
}
