<?php

namespace MaciejKosiarski\XmlFinder\Condition;

use MaciejKosiarski\XmlFinder\Condition\Feature\FeatureFactory;
use MaciejKosiarski\XmlFinder\Exception\Condition\InvalidConditionException;
use MaciejKosiarski\XmlFinder\Exception\Condition\InvalidOperatorException;

/**
 * Class Condition
 * @package MaciejKosiarski\XmlFinder\Condition
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class Condition implements BasicCondition
{
	/**
	 * @var string
	 */
	protected $path;

	/**
	 * @var string
	 */
	protected $key;

	/**
	 * Value to compare
	 *
	 * @var string|array
	 */
	protected $value;

	/**
	 * Parameter key to compare
	 *
	 * @var string|null
	 */
	protected $parameter;

	/**
	 * Comparison operator
	 *
	 * @var string
	 */
	protected $operator;

	/**
	 * @var FeatureFactory
	 */
	private $factory;

	/**
	 * Condition constructor.
	 * @param string      $condition
	 * @throws InvalidConditionException
	 * @throws InvalidOperatorException
	 */
	public function __construct(string $condition)
	{
		$conditionParts = end(explode('.', $condition));

		$this->path = implode('/', explode('.', rtrim(str_replace($conditionParts, '', $condition), '.')));

		$conditionParts = explode(' ', $conditionParts);

		if (count($conditionParts) != 3) throw new InvalidConditionException($condition);

		$this->key = $conditionParts[0];

		if (!array_key_exists($conditionParts[1], self::FEATURES)) throw new InvalidOperatorException($conditionParts[1]);

		$this->operator = $conditionParts[1];

		if ($this->isParameterKey($conditionParts[2])) {
			$this->parameter = substr($conditionParts[2],1);
		} else {
			$this->value = (is_numeric($conditionParts[2])) ? $conditionParts[2] : '"' . $conditionParts[2] . '"';
		}
	}

	public function __toString(): string
	{
		return $this->path . $this->getAsString();
	}

	public function getAsString(): string
	{
		if (self::FEATURES[$this->operator] === 'default') {
			return '['. $this->key . $this->operator . $this->value .']';
		}

		return $this->getFeatureFactory()
			->create($this, $this->operator)
			->getAsString();
	}

	private function isParameterKey($string): bool
	{
		if (substr($string,0,1) === ':') {
			return true;
		}

		return false;
	}

	public function hasValue(): bool
	{
		if ($this->value) return true;

		return false;
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function setValue(string $value): void
	{
		$this->value = $value;
	}

	public function getParameter(): string
	{
		return $this->parameter;
	}

	public function getKey(): string
	{
		return $this->key;
	}

	private function getFeatureFactory(): FeatureFactory
	{
		if ($this->factory) {
			return $this->factory;
		}

		$this->factory = new FeatureFactory();

		return $this->factory;
	}
}