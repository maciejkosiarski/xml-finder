<?php


namespace MaciejKosiarski\XmlFinder\Condition;

/**
 * Class AndCondition
 * @package MaciejKosiarski\XmlFinder\Condition
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class AndCondition extends Condition
{
	public function __toString(): string
	{
		return $this->getAsString();
	}
}