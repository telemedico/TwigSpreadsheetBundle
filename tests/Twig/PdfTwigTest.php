<?php

namespace MewesK\TwigSpreadsheetBundle\Tests\Twig;

use Exception;

/**
 * Class PdfTwigTest.
 */
class PdfTwigTest extends BaseTwigTest
{
    /**
     * @return array
     */
    public function formatProvider(): array
    {
        return [['pdf']];
    }

    //
    // Tests
    //

    /**
     * @param string $format
     *
     * @throws Exception
     *
     * @dataProvider formatProvider
     */
    public function testBasic($format)
    {
        $path = $this->getDocument('cellProperties', $format);

        static::assertFileExists($path, 'File does not exist');
        static::assertGreaterThan(0, filesize($path), 'File is empty');
    }
}
