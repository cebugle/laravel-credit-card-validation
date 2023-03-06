<?php

namespace Cebugle\CreditCard;

use Cebugle\CreditCard\Cards\AmericanExpress;
use Cebugle\CreditCard\Cards\Dankort;
use Cebugle\CreditCard\Cards\DinersClub;
use Cebugle\CreditCard\Cards\Discovery;
use Cebugle\CreditCard\Cards\Forbrugsforeningen;
use Cebugle\CreditCard\Cards\Hipercard;
use Cebugle\CreditCard\Cards\Jcb;
use Cebugle\CreditCard\Cards\Maestro;
use Cebugle\CreditCard\Cards\Mastercard;
use Cebugle\CreditCard\Cards\Mir;
use Cebugle\CreditCard\Cards\Troy;
use Cebugle\CreditCard\Cards\UnionPay;
use Cebugle\CreditCard\Cards\Visa;
use Cebugle\CreditCard\Cards\VisaElectron;
use Cebugle\CreditCard\Exceptions\CreditCardException;

class Factory
{
    protected static $available_cards = [
        // Firs debit cards
        Dankort::class,
        Forbrugsforeningen::class,
        Maestro::class,
        VisaElectron::class,
        // Debit cards
        AmericanExpress::class,
        DinersClub::class,
        Discovery::class,
        Jcb::class,
        Hipercard::class,
        Mastercard::class,
        UnionPay::class,
        Visa::class,
        Mir::class,
        Troy::class,
    ];

    /**
     * @param  string|mixed  $card_number
     * @return \Cebugle\CreditCard\Cards\Card
     *
     * @throws \Cebugle\CreditCard\Exceptions\CreditCardException
     */
    public static function makeFromNumber($card_number)
    {
        return self::determineCardByNumber($card_number);
    }

    /**
     * @param  string|mixed  $card_number
     * @return mixed
     *
     * @throws \Cebugle\CreditCard\Exceptions\CreditCardException
     */
    protected static function determineCardByNumber($card_number)
    {
        foreach (self::$available_cards as $card) {
            if (preg_match($card::$pattern, $card_number)) {
                return new $card($card_number);
            }
        }

        throw new CreditCardException('Card not found.');
    }
}
