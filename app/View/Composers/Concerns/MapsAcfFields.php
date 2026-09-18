<?php

namespace App\View\Composers\Concerns;

use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Roots\Acorn\View\Composers\Concerns\AcfFields;

trait MapsAcfFields
{
    use AcfFields;

    protected function acf($postId = null): array
    {
        if (! function_exists('get_fields')) {
            return [];
        }

        $fields = get_fields($postId);

        if (! is_array($fields) || $fields === []) {
            return [];
        }

        return collect($this->fields($postId))
            ->mapWithKeys(function ($value, $key) {
                if ($value instanceof Fluent) {
                    $value = $value->toArray();
                }

                return [Str::camel($key) => $value];
            })
            ->filter(fn ($value) => $value !== null && $value !== false && $value !== '' && $value !== [])
            ->all();
    }

    protected function imageUrl($image): string
    {
        if (is_object($image)) {
            return (string) ($image->url ?? '');
        }

        return is_array($image) && ! empty($image['url']) ? $image['url'] : '';
    }

    protected function imageAlt($image): string
    {
        if (is_object($image)) {
            return (string) ($image->alt ?? '');
        }

        return is_array($image) && ! empty($image['alt']) ? $image['alt'] : '';
    }
}
