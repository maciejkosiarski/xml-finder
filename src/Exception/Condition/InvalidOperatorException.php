<?php

namespace MaciejKosiarski\XmlFinder\Exception\Condition;

/**
 * Class InvalidOperatorException
 * @package MaciejKosiarski\XmlFinder\Exception\Condition
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class InvalidOperatorException extends \Exception
{
	public function __construct($operator)
	{
		parent::__construct(sprintf('Condition has invalid operator ("%s")', $operator));
	}
}