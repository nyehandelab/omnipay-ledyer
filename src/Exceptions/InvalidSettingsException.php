<?php

namespace Nyehandel\Omnipay\Ledyer\Exceptions;

use Omnipay\Common\Exception\OmnipayException;


/**
 * Invalid Settings Exception
 *
 * Thrown when the settings object is invalid or missing required fields.
 */
class InvalidSettingsException extends \Exception implements OmnipayException
{
}
