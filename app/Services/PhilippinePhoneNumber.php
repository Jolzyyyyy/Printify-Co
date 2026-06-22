<?php

namespace App\Services;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;

class PhilippinePhoneNumber
{
    public static function normalize(mixed $value): ?string
    {
        $value = self::clean($value);

        if ($value === '') {
            return null;
        }

        if (! self::isValidMobile($value)) {
            return null;
        }

        $phone = self::parse($value);

        return $phone ? self::util()->format($phone, PhoneNumberFormat::E164) : null;
    }

    public static function isValidMobile(mixed $value): bool
    {
        $value = self::clean($value);

        if ($value === '') {
            return false;
        }

        $phone = self::parse($value);

        if (! $phone) {
            return false;
        }

        $util = self::util();
        $type = $util->getNumberType($phone);

        $normalized = $util->format($phone, PhoneNumberFormat::E164);

        return $util->isValidNumberForRegion($phone, 'PH')
            && in_array($type, [PhoneNumberType::MOBILE, PhoneNumberType::FIXED_LINE_OR_MOBILE], true)
            && preg_match('/^\+639\d{9}$/', $normalized) === 1;
    }

    private static function parse(string $value): mixed
    {
        try {
            return self::util()->parse($value, 'PH');
        } catch (NumberParseException) {
            return null;
        }
    }

    private static function clean(mixed $value): string
    {
        $value = trim((string) $value);

        return preg_replace('/[^\d+]/', '', $value) ?? '';
    }

    private static function util(): PhoneNumberUtil
    {
        return PhoneNumberUtil::getInstance();
    }
}
