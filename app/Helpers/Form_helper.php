<?php

use CodeIgniter\Validation\Validation;

function display_error(Validation $validation, string $field): bool|string
{
    if ($validation->hasError($field)) {
        return $validation->getError($field);
    }
    else {
        return false;
    }
}
