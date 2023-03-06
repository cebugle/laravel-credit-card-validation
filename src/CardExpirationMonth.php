<?php

namespace Cebugle\CreditCard;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CardExpirationMonth implements ValidationRule
{
    const MSG_CARD_EXPIRATION_MONTH_INVALID = 'validation.credit_card.card_expiration_month_invalid';

    /**
     * CardExpirationMonth constructor.
     *
     * @param  string  $year
     */
    public function __construct(
        protected string $year
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = (new ExpirationDateValidator($this->year, $value))
            ->isValid();

        if ($response === false) {
            $fail(static::MSG_CARD_EXPIRATION_MONTH_INVALID)->translate();
        }
    }
}
