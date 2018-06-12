<?php

use PHPUnit\Framework\TestCase;
use MaciejKosiarski\XmlFinder\Exception\InvalidXmlFileException;
use MaciejKosiarski\XmlFinder\Exception\InvalidXmlStringException;
use MaciejKosiarski\XmlFinder\XmlFinder;

/**
 * Class XmlFinderTest
 * @author Maciej Kosiarski <mks@moleo.pl>
 */
class XmlFinderTest extends TestCase
{
	public function testCreatedByString()
	{
		$testSource = '<note><to>Tove</to><from>Jani</from><heading>Reminder</heading><body>Don\'t forget me this weekend!</body></note>';

		$XmlFinder = new XmlFinder($testSource);

		$this->assertInstanceOf(
			XmlFinder::class,
			$XmlFinder
		);

		$this->checkDataSource($XmlFinder);
	}

	public function testCreatedByFile()
	{
		$XmlFinder = new XmlFinder('data.xml');

		$this->assertInstanceOf(
			XmlFinder::class,
			$XmlFinder
		);

		$this->checkDataSource($XmlFinder);
	}

	public function testInvalidSource()
	{
		$this->expectException(InvalidXmlStringException::class);

		new XmlFinder('invalid source');
	}

	public function testInvalidSourceFile()
	{
		$this->expectException(InvalidXmlFileException::class);

		new XmlFinder('invalid.ext');
	}

	private function checkDataSource(XmlFinder $finder)
	{
		$this->assertInstanceOf(
			SimpleXMLElement::class,
			$finder->getData()
		);
	}
}