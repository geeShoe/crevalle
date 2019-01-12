<?php
/**
 * User: Jesse Rushlow - Geeshoe Development
 * Date: 1/12/19 - 12:16 PM
 */
declare(strict_types=1);

namespace Geeshoe\Crevalle\Exception;

use Throwable;

/**
 * Class CrevalleException
 *
 * @package Geeshoe\Crevalle\Exception
 */
class CrevalleException extends \Exception
{
    /**
     * CrevalleException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
