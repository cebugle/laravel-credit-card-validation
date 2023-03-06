<?php

namespace Cebugle\CreditCard;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Cebugle\CreditCard\Exceptions\CreditCardException;
use Cebugle\CreditCard\Exceptions\CreditCardLengthException;
use Cebugle\CreditCard\Exceptions\CreditCardChecksumException;

class CardNumber implements ValidationRule
{
    const MSG_CARD_INVALID = 'validation.credit_card.card_invalid';
    const MSG_CARD_PATTER_INVALID = 'validation.credit_card.card_pattern_invalid';
    const MSG_CARD_LENGTH_INVALID = 'validation.credit_card.card_length_invalid';
    const MSG_CARD_CHECKSUM_INVALID = 'validation.credit_card.card_checksum_invalid';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $response = Factory::makeFromNumber($value)->isValidCardNumber();

            if ($response === false) {
                $fail(self::MSG_CARD_INVALID)->translate();
            }
        } catch (CreditCardLengthException $ex) {
            $fail(self::MSG_CARD_LENGTH_INVALID)->translate();
        } catch (CreditCardChecksumException $ex) {
            $fail(self::MSG_CARD_CHECKSUM_INVALID)->translate();
        } catch (CreditCardException $ex) {
            $fail(self::MSG_CARD_INVALID)->translate();
        }
    }
}
