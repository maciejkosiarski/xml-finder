<?php


namespace MaciejKosiarski\XmlFinder\Condition\Feature;

use MaciejKosiarski\XmlFinder\Condition\ConditionFeature;

/**
 * Class NotInFeature
 * @package MaciejKosiarski\XmlFinder\Condition\Feature
 * @author  Maciej Kosiarski <mks@moleo.pl>
 */
class NotInFeature extends ConditionFeature
{
	public function getAsString(): string
	{
		$values = '[';

		foreach (explode(',', $this->getValue()) as $value) {
			$values .= $this->stickConditionPart($value);
		}

		return rtrim($values, ' and') .']';
	}

	private function stickConditionPart(string $value)
	{
		return 'not(contains('.$this->getKey() . ',' . ((is_numeric($value)) ? $value : '"' . $value . '"') . ')) and ';
	}
}