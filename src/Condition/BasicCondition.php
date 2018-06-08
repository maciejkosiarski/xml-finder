<?php

namespace MaciejKosiarski\XmlFinder\Condition;

/**
 * Interface BasicCondition
 * @package MaciejKosiarski\XmlFinder\Condition
 */
interface BasicCondition
{
	const FEATURES = [
		'='     => 'default',
		'!='    => 'default',
		'>'     => 'default',
		'<'     => 'default',
		'in'    => 'in',
		'notIn' => 'notIn',
	];

	/**
	 * @return string
	 */
	public function getAsString(): string;

	public function getKey(): string;

	public function getValue();
}