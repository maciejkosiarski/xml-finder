<?php

namespace MaciejKosiarski\XmlFinder\Condition;

use MaciejKosiarski\XmlFinder\Exception\Condition\InvalidConditionException;
use MaciejKosiarski\XmlFinder\Exception\Condition\InvalidOperatorException;

/**
 * Class ConditionFactory
 * @package MaciejKosiarski\XmlFinder\Condition
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class ConditionFactory
{
	/**
	 * @param string      $condition
	 * @param null|string $type
	 * @return Condition
	 * @throws InvalidConditionException
	 * @throws InvalidOperatorException
	 */
	public function create(string $condition, ?string  $type = null): Condition
	{
		switch ($type) {
			case 'and':
				return new AndCondition($condition);
			case 'or':
				return new OrCondition($condition);
			default:
				return new Condition($condition);
		}
	}
}