<?php

/**
 * This file is part of the sineld/money library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Sinan Eldem <sinan@sinaneldem.com.tr>
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @see readme.md for Documentation
 * @see https://packagist.org/packages/sineld/money Packagist
 * @see https://github.com/sineld/money GitHub
 */

namespace Sineld\Money;

class Money
{
    private $amount;
    private $taxRate = 18;
    private $decimals = 2;
    private $taxAmount = 0;
    private $localeCode = 'TRL';
    private $localeActive = false;
    private $localePrefix;
    private $localeSuffix;
    private $localePosition = 'prefix';

    /**
     * Creates a new Money instance.
     *
     * @param mixed $amount
     */
    public function make($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Set decimals size.
     *
     * @param int $decimals
     */
    public function setDecimals($decimals)
    {
        $this->decimals = is_numeric($decimals) ? $decimals : $this->decimals;

        return $this;
    }

    /**
     * Enable Locale Usage.
     *
     * @param bool $bool
     */
    public function setLocaleActive($bool)
    {
        $this->localeActive = $bool;

        return $this;
    }

    /**
     * Set Locale Code preference.
     *
     * @param mixed $code
     */
    public function setLocaleCode($code)
    {
        $this->localeCode = $code;

        return $this;
    }

    /**
     * Set Locale Position preference
     * Use "prefix" to display Locale Code on left, "suffix" for right.
     *
     * @param mixed $position
     */
    public function setLocalePosition($position)
    {
        $sides = ['prefix', 'suffix'];

        $this->localePosition = in_array($position, $sides) ? $position : $this->localePosition;

        foreach ($sides as $side) {
            if ($side == $this->localePosition) {
                $this->{'locale'.ucfirst($side)} = $this->localeCode;
            } else {
                $this->{'locale'.ucfirst($side)} = null;
            }
        }

        return $this;
    }

    /**
     * Add $numbers variable(s) value to the $amount
     * Seperate multiple variables with comma.
     *
     * @param mixed $numbers
     */
    public function sum(...$numbers)
    {
        foreach ($numbers as $number) {
            $this->amount = $this->clear($this->amount) + $this->clear($number);
        }

        return $this;
    }

    /**
     * Remove $numbers variable(s) value from the $amount
     * Seperate multiple variables with comma.
     *
     * @param mixed $numbers
     */
    public function subtract(...$numbers)
    {
        foreach ($numbers as $number) {
            $this->amount = $this->clear($this->amount) - $this->clear($number);
        }

        return $this;
    }

    /**
     * Multiply $amount with $numbers variable(s) value.
     *
     * @param mixed $numbers
     */
    public function multiply($number)
    {
        $this->amount = $this->clear(
            $this->amount
        ) * $this->clear(
            $number
        );

        return $this;
    }

    /**
     * Divide $amount with $numbers variable(s) value.
     *
     * @param mixed $numbers
     */
    public function divide($number)
    {
        $this->amount = $number != 0
            ? $this->clear($this->amount) / $this->clear($number)
            : 0;

        return $this;
    }

    /**
     * Add $percent variable to the $amount with calculated value.
     *
     * @param mixed $percent
     */
    public function addTax(int $percent = null)
    {
        $this->taxAmount = $this->clear(
            $this->amount
        ) * (
            $this->clear($percent ?? $this->taxRate) / 100
        );

        $this->amount = $this->clear($this->amount) + $this->taxAmount;

        return $this;
    }

    /**
     * Remove $percent variable to the $amount with calculated value.
     *
     * @param mixed $percent
     */
    public function removeTax(int $percent = null)
    {
        $this->taxAmount = $this->amount - (
            $this->clear($this->amount) / (
                1 + ($this->clear($percent ?? $this->taxRate) / 100)
            )
        );

        $this->amount = $this->amount - $this->taxAmount;

        return $this;
    }

    /**
     * Return $amount variable according to the locale usage.
     *
     * @param none
     */
    public function get()
    {
        $this->format();

        if ($this->localeActive) {
            return sprintf('%s%s%s', $this->localePrefix, $this->amount, $this->localeSuffix);
        }

        return $this->amount;
    }

    /**
     * Return calculated $taxAmount variable.
     *
     * @param none
     */
    public function getTax()
    {
        return $this->taxAmount;
    }

    /**
     * Return the $amount and $taxAmount variables in array.
     *
     * @param none
     */
    public function all()
    {
        return [
            'amount' => $this->get(),
            'tax' => $this->getTax(),
        ];
    }

    /**
     * Format the $amount and $taxAmount variables for a clear display.
     *
     * @param none
     */
    private function format()
    {
        $this->amount = number_format(
            floatval($this->clear($this->amount)),
            $this->decimals,
            ',',
            '.'
        );

        $this->taxAmount = number_format(
            floatval($this->clear($this->taxAmount)),
            $this->decimals,
            ',',
            '.'
        );

        return $this;
    }

    /**
     * Remove commas from $number variable to the make it available
     * for the operations.
     *
     * @param mixed $percent
     */
    private function clear($number)
    {
        return str_replace(',', '', $number);
    }
}
