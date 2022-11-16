<?php

namespace App\Traits;

trait HasMarkdownFields
{
    public function renderMarkdown($field)
    {
        if($this->{$field})
        {
            return str($this->{$field})->markdown()->toHtmlString();
        }

        return null;
    }
}
