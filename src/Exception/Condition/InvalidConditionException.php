<?php

namespace MaciejKosiarski\XmlFinder\Exception\Condition;

/**
 * Class InvalidConditionException
 * @package MaciejKosiarski\XmlFinder\Exception\Condition
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class InvalidConditionException extends \Exception
{
	public function __construct($condition)
	{
		parent::__construct(sprintf('Condition (%s) has more than 3 elements', $condition));
	}
}