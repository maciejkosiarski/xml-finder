<?php

namespace MaciejKosiarski\XmlFinder\Exception;

/**
 * Class InvalidXmlStringException
 * @package MaciejKosiarski\XmlFinder\Exception
 * @author  Maciej Kosiarski <mks@moleo.pl>
 */
class InvalidXmlStringException extends \Exception
{
	public function __construct(string $message, int $level, int $column, int $line)
	{
		$message = sprintf('Invalid xml string. %s, level: %d, column: %d, line: %d.', $message, $level, $column, $line) ;

		parent::__construct($message);
	}
}