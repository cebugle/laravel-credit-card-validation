<?php

namespace Cebugle\CreditCard;

use Closure;
use Exception;
use Carbon\Carbon;
use InvalidArgumentException;
use Illuminate\Contracts\Validation\ValidationRule;

class CardExpirationDate implements ValidationRule
{
    const MSG_CARD_EXPIRATION_DATE_INVALID = 'validation.credit_card.card_expiration_date_invalid';
    const MSG_CARD_EXPIRATION_DATE_FORMAT_INVALID = 'validation.credit_card.card_expiration_date_format_invalid';

    /**
     * CardExpirationDate constructor.
     *
     * @param  string  $format  Date format
     */
    public function __construct(
        protected string $format
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            // This can throw Invalid Date Exception if format is not supported.
            Carbon::parse($value);

            $date = Carbon::createFromFormat($this->format, $value);

            $response = (new ExpirationDateValidator($date->year, $date->month))
                ->isValid();

            if ($response === false) {
                $fail(static::MSG_CARD_EXPIRATION_DATE_INVALID)->translate();
            }
        } catch (InvalidArgumentException $ex) {
            $fail(static::MSG_CARD_EXPIRATION_DATE_FORMAT_INVALID)->translate();
        } catch (Exception $ex) {
            $fail(static::MSG_CARD_EXPIRATION_DATE_INVALID)->translate();
        }
    }
}
