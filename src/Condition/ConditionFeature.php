<?php


namespace MaciejKosiarski\XmlFinder\Condition;

/**
 * Class ConditionFeature
 * @package MaciejKosiarski\XmlFinder\Condition
 * @author  Maciej Kosiarski <mks@moleo.pl>
 */
abstract class ConditionFeature implements BasicCondition
{
	/**
	 * @var Condition
	 */
	protected $condition;

	public function __construct(BasicCondition $condition)
	{
		$this->condition = $condition;
	}

	abstract function getAsString(): string;

	public function getKey(): string
	{
		return $this->condition->getKey();
	}

	public function getValue()
	{
		return $this->condition->getValue();
	}
}