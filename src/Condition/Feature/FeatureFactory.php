<?php

namespace MaciejKosiarski\XmlFinder\Condition\Feature;

use MaciejKosiarski\XmlFinder\Condition\BasicCondition;
use MaciejKosiarski\XmlFinder\Condition\ConditionFeature;

/**
 * Class FeatureFactory
 * @package MaciejKosiarski\XmlFinder\Condition\Feature
 * @author  Maciej Kosiarski <mks@moleo.pl>
 */
class FeatureFactory
{
	public function create(BasicCondition $condition, string $feature): ConditionFeature
	{
		$createMethod = 'create' . ucfirst($feature) . 'Feature';

		if (method_exists($this, $createMethod)) return $this->{$createMethod}($condition);


	}

	private function createInFeature(BasicCondition $condition): InFeature
	{
		return new InFeature($condition);
	}

	private function createNotInFeature(BasicCondition $condition): NotInFeature
	{
		return new NotInFeature($condition);
	}
}