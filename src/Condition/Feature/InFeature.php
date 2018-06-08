<?php


namespace MaciejKosiarski\XmlFinder\Condition\Feature;

use MaciejKosiarski\XmlFinder\Condition\ConditionFeature;

/**
 * Class InFeature
 * @package MaciejKosiarski\XmlFinder\Condition\Feature
 * @author  Maciej Kosiarski <mks@moleo.pl>
 */
class InFeature extends ConditionFeature
{
	public function getAsString(): string
	{
		$values = '[';

		foreach ($this->getValue() as $value) {
			$values .= 'contains('.$this->getKey() . ',' . ((is_numeric($value)) ? $value : '"' . $value . '"') . ') or ';
		}

		return rtrim($values, ' or') .']';
	}
}