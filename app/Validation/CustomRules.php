<?php

namespace App\Validation;

class CustomRules
{
    public function email_or_student(string $value): bool
    {
        // Email check
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        // Student code format: 22-1401
        if (preg_match('/^\d{2}-\d{4}$/', $value)) {
            return true;
        }

        return false;
    }
}