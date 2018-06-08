<?php

declare(strict_types=1);

namespace MaciejKosiarski\XmlFinder;

use MaciejKosiarski\XmlFinder\Condition\ConditionFactory;
use MaciejKosiarski\XmlFinder\Exception\FileNotFoundException;
use MaciejKosiarski\XmlFinder\Exception\InvalidXmlException;

/**
 * Class XmlFinder
 * @author Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class XmlFinder
{
	/**
	 * @var \SimpleXMLElement
	 */
	private $data;

	/**
	 * @var QueryBuilder
	 */
	private $queryBuilder;

	/**
	 * XmlFinder constructor.
	 * @param null $xmlSource
	 * @throws InvalidXmlException
	 * @throws FIleNotFoundException
	 */
	public function __construct($xmlSource = null)
	{
		if (!is_null($xmlSource)) {
			$path      = pathinfo($xmlSource);
			$extension = isset($path['extension']) ? $path['extension'] : null;

			if ($extension != 'xml') {
				throw new InvalidXmlException($extension);
			}

			$this->import($xmlSource);

			$this->queryBuilder = new QueryBuilder($this, new ConditionFactory());
		}
	}

	/**
	 * import data from file
	 *
	 * @param $xmlFile string
	 * @return bool
	 * @throws FileNotFoundException
	 */
	private function import(?string $xmlFile = null): bool
	{
		if (!is_null($xmlFile)) {
			if (file_exists($xmlFile)) {
				$this->data = (simplexml_load_file($xmlFile));
				return true;
			}
		}

		throw new FIleNotFoundException();
	}

	/**
	 * @return \SimpleXMLElement
	 */
	public function getData(): \SimpleXMLElement
	{
		return $this->data;
	}

	/**
	 * @return QueryBuilder
	 */
	public function getQueryBuilder(): QueryBuilder
	{
		return $this->queryBuilder;
	}
}