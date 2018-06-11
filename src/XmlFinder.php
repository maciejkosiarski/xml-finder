<?php

declare(strict_types=1);

namespace MaciejKosiarski\XmlFinder;

use MaciejKosiarski\XmlFinder\Condition\ConditionFactory;
use MaciejKosiarski\XmlFinder\Exception\FileNotFoundException;
use MaciejKosiarski\XmlFinder\Exception\InvalidXmlFileException;
use MaciejKosiarski\XmlFinder\Exception\InvalidXmlStringException;

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
	 * @param string $xmlSource
	 * @throws FileNotFoundException
	 * @throws InvalidXmlFileException
	 * @throws InvalidXmlStringException
	 */
	public function __construct(string $xmlSource)
	{
		$path      = pathinfo($xmlSource);
		$extension = isset($path['extension']) ? $path['extension'] : null;

		if (is_null($extension)) {
			$this->importString($xmlSource);
		} else {
			if ($extension != 'xml') {
				throw new InvalidXmlFileException($extension);
			}

			$this->importFile($xmlSource);
		}

		$this->queryBuilder = new QueryBuilder($this, new ConditionFactory());
	}

	/**
	 * import data from file
	 *
	 * @param $xmlFile string
	 * @return bool
	 * @throws FileNotFoundException
	 */
	private function importFile(?string $xmlFile): bool
	{
		if (file_exists($xmlFile)) {
			$this->data = (simplexml_load_file($xmlFile));
			return true;
		}

		throw new FileNotFoundException();
	}

	/**
	 * @param string $xmlString
	 * @throws InvalidXmlStringException
	 */
	private function importString(string $xmlString)
	{
		libxml_use_internal_errors(true);

		if (!simplexml_load_string($xmlString)) {
			$errors = libxml_get_errors();

			foreach ($errors as $error) {
				throw new InvalidXmlStringException($error->message, $error->level, $error->column, $error->line);
			}

			libxml_clear_errors();
		}

		$this->data = simplexml_load_string($xmlString);
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