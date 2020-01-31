<?php
declare(strict_types=1);

namespace CodeInc\HumanReadableFileSize;

use NumberFormatter;


/**
 * Class HumanReadableFileSize
 *
 * @package CodeInc\HumanReadableFileSize
 * @copyright 2020 Code Inc. <https://www.codeinc.co>
 * @author Joan Fabrégat <joan@codeinc.co>
 */
class HumanReadableFileSize
{
    private string $byteSymbol = 'B';
    private bool $spaceBeforeUnit = false;
    private bool $useBinaryKilos = true;
    private ?NumberFormatter $numberFormatter = null;

    /**
     * @param NumberFormatter $numberFormatter
     */
    public function setNumberFormatter(NumberFormatter $numberFormatter):void
    {
        $this->numberFormatter = $numberFormatter;
    }

    /**
     * Uses an international number formatter for the file size.
     *
     * @link https://www.php.net/manual/class.numberformatter.php
     * @param string $locale
     * @param int $style
     */
    public function useNumberFormatter(string $locale, int $style = NumberFormatter::DECIMAL):void
    {
        $this->setNumberFormatter(new NumberFormatter($locale, $style));
    }

    /**
     * @return NumberFormatter
     */
    public function getNumberFormatter():NumberFormatter
    {
        return $this->numberFormatter;
    }

    /**
     * Sets the byte symbol.
     *
     * @param string $byteSymbol
     */
    public function setByteSymbol(string $byteSymbol):void
    {
        $this->byteSymbol = $byteSymbol;
    }

    /**
     * Returns byte symbol (by default 'B').
     *
     * @return string
     */
    public function getByteSymbol():string
    {
        return $this->byteSymbol;
    }

    /**
     * Uses binary kilo bytes composed of 1024 bytes.
     *
     * @param bool $value
     */
    public function useBinaryKilos(bool $value = true):void
    {
        $this->useBinaryKilos = $value;
    }

    /**
     * Uses decimal kilo bytes composed of 1000 bytes.
     *
     * @param bool $value
     */
    public function useDecimalKilos(bool $value = true):void
    {
        $this->useBinaryKilos = !$value;
    }

    /**
     * @param bool $spaceBeforeUnit
     */
    public function setSpaceBeforeUnit(bool $spaceBeforeUnit = true):void
    {
        $this->spaceBeforeUnit = $spaceBeforeUnit;
    }

    /**
     * @return bool
     */
    public function hasSpaceBeforeUnit():bool
    {
        return $this->spaceBeforeUnit;
    }

    /**
     * Returns the number of bytes per kilo used for computations.
     *
     * @return int
     */
    public function getBytesPeyKilo():int
    {
        return $this->useBinaryKilos ? 1024 : 1000;
    }

    /**
     * Computes a human readable size.
     *
     * @param int $bytes
     * @param int $decimals
     * @return string
     */
    public function compute(int $bytes, int $decimals = 2):string
    {
        $factor = floor((strlen((string)$bytes) - 1) / 3);
        $number = sprintf("%.{$decimals}f", $bytes / pow($this->getBytesPeyKilo(), $factor));
        if ($this->numberFormatter) {
            $number = $this->numberFormatter->format($number);
        }
        return $number.($this->spaceBeforeUnit ? ' ' : '').@$this->getUnits()[$factor];
    }

    /**
     * Returns all available sizes with the current label.
     *
     * @return array
     */
    public function getUnits():array
    {
        return [
            $this->byteSymbol,
            'K'.$this->byteSymbol,
            'M'.$this->byteSymbol,
            'G'.$this->byteSymbol,
            'T'.$this->byteSymbol,
            'P'.$this->byteSymbol,
            'E'.$this->byteSymbol,
            'Z'.$this->byteSymbol,
            'Y'.$this->byteSymbol
        ];
    }

    /**
     * Static helper. Computes a human readable size.
     *
     * @param int $bytes
     * @param int $decimals
     * @return string
     */
    public static function getHumanSize(int $bytes, int $decimals = 2):string
    {
        return (new self)->compute($bytes, $decimals);
    }
}