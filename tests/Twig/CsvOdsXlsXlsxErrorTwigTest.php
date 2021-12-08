<?php

namespace MewesK\TwigSpreadsheetBundle\Tests\Twig;

use Exception;
use Twig\Error\SyntaxError;
use TypeError;

/**
 * Class CsvOdsXlsXlsxErrorTwigTest.
 */
class CsvOdsXlsXlsxErrorTwigTest extends BaseTwigTest
{
    /**
     * @return array
     */
    public function formatProvider(): array
    {
        return [['csv'], ['ods'], ['xls'], ['xlsx']];
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
    public function testDocumentError(string $format)
    {
        $this->expectException(SyntaxError::class);
        $this->expectExceptionMessage('Node "MewesK\TwigSpreadsheetBundle\Twig\Node\DocumentNode" is not allowed inside of Node "MewesK\TwigSpreadsheetBundle\Twig\Node\SheetNode"');

        $this->getDocument('documentError', $format);
    }

    /**
     * @param string $format
     *
     * @throws Exception
     *
     * @dataProvider formatProvider
     */
    public function testDocumentErrorTextAfter(string $format)
    {
        $this->expectException(SyntaxError::class);
        $this->expectExceptionMessage('Node "Twig_Node_Text" is not allowed after Node "MewesK\TwigSpreadsheetBundle\Twig\Node\DocumentNode"');

        $this->getDocument('documentErrorTextAfter', $format);
    }

    /**
     * @param string $format
     *
     * @throws Exception
     *
     * @dataProvider formatProvider
     */
    public function testDocumentErrorTextBefore(string $format)
    {
        $this->expectException(SyntaxError::class);
        $this->expectExceptionMessage('Node "Twig_Node_Text" is not allowed before Node "MewesK\TwigSpreadsheetBundle\Twig\Node\DocumentNode"');

        $this->getDocument('documentErrorTextBefore', $format);
    }

    /**
     * @param string $format
     *
     * @throws Exception
     *
     * @dataProvider formatProvider
     */
    public function testStartCellIndexError(string $format)
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument 1 passed to MewesK\TwigSpreadsheetBundle\Wrapper\PhpSpreadsheetWrapper::startCell() must be of the type integer');

        $this->getDocument('cellIndexError', $format);
    }

    /**
     * @param string $format
     *
     * @throws Exception
     *
     * @dataProvider formatProvider
     */
    public function testStartRowIndexError(string $format)
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Argument 1 passed to MewesK\TwigSpreadsheetBundle\Wrapper\PhpSpreadsheetWrapper::startRow() must be of the type integer');

        $this->getDocument('rowIndexError', $format);
    }

    /**
     * @param string $format
     *
     * @throws Exception
     *
     * @dataProvider formatProvider
     */
    public function testSheetError(string $format)
    {
        $this->expectException(SyntaxError::class);
        $this->expectExceptionMessage('Node "MewesK\TwigSpreadsheetBundle\Twig\Node\RowNode" is not allowed inside of Node "MewesK\TwigSpreadsheetBundle\Twig\Node\DocumentNode"');

        $this->getDocument('sheetError', $format);
    }
}
