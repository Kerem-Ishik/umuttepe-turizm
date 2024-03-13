<?php

use CodeIgniter\Validation\Validation;

function display_error(Validation|array $validation, string $field): bool|string
{
    if ($validation instanceof Validation) {
        return $validation->hasError($field) ? $validation->getError($field) : false;
    }
    else {
        return $validation[$field] ?? false;
    }
}
