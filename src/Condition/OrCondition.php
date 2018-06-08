<?php


namespace MaciejKosiarski\XmlFinder\Condition;

/**
 * Class OrCondition
 * @package MaciejKosiarski\XmlFinder\Condition
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class OrCondition extends Condition
{
	public function __toString(): string
	{
		return '|' . $this->path . $this->getAsString();
	}
}