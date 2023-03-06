<?php

namespace Cebugle\CreditCard;

use Closure;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;

class CardCvc implements ValidationRule
{
    public function __construct(
        protected string $cardNumber
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $response = Factory::makeFromNumber($this->cardNumber)->isValidCvc($value);

            if ($response === false) {
                $fail('validation.credit_card.card_cvc_invalid')->translate();
            }
        } catch (Exception $ex) {
            $fail('validation.credit_card.card_cvc_invalid')->translate();
        }
    }
}
