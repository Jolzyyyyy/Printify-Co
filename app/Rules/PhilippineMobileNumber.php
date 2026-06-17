<?php

namespace App\Rules;

use App\Services\PhilippinePhoneNumber;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhilippineMobileNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! PhilippinePhoneNumber::isValidMobile($value)) {
            $fail('The :attribute must be a valid Philippine mobile number, such as 09171234567 or +639171234567.');
        }
    }
}
