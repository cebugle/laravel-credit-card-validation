<?php

namespace Cebugle\CreditCard;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CardExpirationYear implements ValidationRule
{
    const MSG_CARD_EXPIRATION_YEAR_INVALID = 'validation.credit_card.card_expiration_year_invalid';

    /**
     * CardExpirationYear constructor.
     *
     * @param  string  $month
     */
    public function __construct(
        protected string $month
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $response = (new ExpirationDateValidator($value, $this->month))
            ->isValid();

        if ($response === false) {
            $fail(static::MSG_CARD_EXPIRATION_YEAR_INVALID)->translate();
        }
    }
}
