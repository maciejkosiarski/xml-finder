<?php

namespace MaciejKosiarski\XmlFinder\Exception;

/**
 * Class InvalidXmlFileException
 * @package MaciejKosiarski\XmlFinder\Exception
 * @author  Maciej Kosiarski <maciek.kosiarski@gmail.com>
 */
class InvalidXmlFileException extends \Exception
{
	public function __construct($extension)
	{
		parent::__construct(sprintf('Invalid source data file (.%s).', $extension));
	}
}