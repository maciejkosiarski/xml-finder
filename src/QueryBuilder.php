<?php

namespace MaciejKosiarski\XmlFinder;

use MaciejKosiarski\XmlFinder\Condition\Condition;
use MaciejKosiarski\XmlFinder\Condition\ConditionFactory;

/**
 * Class QueryBuilder
 * @package MaciejKosiarski\XmlFinder
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class QueryBuilder
{
	/**
	 * @var XmlFinder
	 */
	private $xmlFinder;
	/**
	 * @var Condition[]
	 */
	private $conditions = [];

	/**
	 * @var \ArrayObject
	 */
	private $parameters;

	/**
	 * @var ConditionFactory
	 */
	private $factory;

	/**
	 * @var string
	 */
	private $query;

	/**
	 * QueryBuilder constructor.
	 * @param XmlFinder        $finder
	 * @param ConditionFactory $factory
	 */
	public function __construct(XmlFinder $finder, ConditionFactory $factory)
	{
		$this->xmlFinder  = $finder;
		$this->parameters = new \ArrayObject();
		$this->factory    = $factory;
	}

	/**
	 * @return Condition[]
	 */
	public function getConditions(): array
	{
		return $this->conditions;
	}

	/**
	 * @param string $condition
	 * @return QueryBuilder
	 * @throws Exception\Condition\InvalidConditionException
	 * @throws Exception\Condition\InvalidOperatorException
	 */
	public function where(string $condition): QueryBuilder
	{
		$this->add($condition);

		return $this;
	}

	/**
	 * @param string $condition
	 * @return QueryBuilder
	 * @throws Exception\Condition\InvalidConditionException
	 * @throws Exception\Condition\InvalidOperatorException
	 */
	public function andWhere(string $condition): QueryBuilder
	{
		$this->add($condition, 'and');

		return $this;
	}

	/**
	 * @param string $condition
	 * @return QueryBuilder
	 * @throws Exception\Condition\InvalidConditionException
	 * @throws Exception\Condition\InvalidOperatorException
	 */
	public function orWhere(string $condition): QueryBuilder
	{
		$this->add($condition, 'or');

		return $this;
	}

	/**
	 * @param string      $condition
	 * @param null|string $type
	 * @throws Exception\Condition\InvalidConditionException
	 * @throws Exception\Condition\InvalidOperatorException
	 */
	private function add(string $condition, ?string $type = null): void
	{
		$this->conditions[] = $this->factory->create($condition, $type);
	}

	/**
	 * @param $key
	 * @param $value
	 * @return QueryBuilder
	 */
	public function setParameter($key, $value): QueryBuilder
	{
		$this->parameters->offsetSet($key, $value);

		return $this;
	}

	/**
	 * @return QueryBuilder
	 */
	public function getQuery(): QueryBuilder
	{
		foreach ($this->conditions as $condition) {
			if (!$condition->hasValue()) {
				$condition->setValue($this->parameters->offsetGet($condition->getParameter()));

				if (!is_array($condition->getValue())) {
					if (!is_numeric($condition->getValue())) {
						$condition->setValue('"' . $condition->getValue() . '"');
					}
				}
			}
		}

		$this->buildXpath($this->conditions);

		return $this;
	}

	/**
	 * @return array
	 */
	public function getResult(): array
	{
		return $this->xmlFinder->getData()->xpath($this->query);
	}

	/**
	 * @param Condition[] $conditions
	 */
	private function buildXpath(array $conditions): void
	{
		$this->query = '/'. $this->xmlFinder->getData()->getName() .'/';

		foreach ($conditions as $condition) {
			$this->query .= (string)$condition;
		}
	}
}