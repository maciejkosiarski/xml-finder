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
	 * @var string
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
		$exploded = explode('.', $condition);

		$cond = end($exploded);

		$this->path = implode('/', explode('.', rtrim(str_replace($cond, '', $condition), '.')));

		$cond = explode(' ', $cond);

		if (count($cond) != 3) throw new InvalidConditionException($condition);

		$this->key = $cond[0];

		if (!array_key_exists($cond[1], self::FEATURES)) throw new InvalidOperatorException($cond[1]);

		$this->operator = $cond[1];

		if ($this->isParameterKey($cond[2])) {
			$this->parameter = substr($cond[2],1);
		} else {
			$this->value = (is_numeric($cond[2])) ? $cond[2] : '"' . $cond[2] . '"';
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

	public function setValue($value): void
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

	public function getValue(): string
	{
		return $this->value;
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