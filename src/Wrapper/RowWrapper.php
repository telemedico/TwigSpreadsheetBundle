<?php

namespace MewesK\TwigSpreadsheetBundle\Wrapper;

use LogicException;
use Twig\Environment;

/**
 * Class SheetWrapper.
 */
class RowWrapper extends BaseWrapper
{
    /**
     * @var SheetWrapper
     */
    protected $sheetWrapper;

    /**
     * RowWrapper constructor.
     *
     * @param array $context
     * @param Environment $environment
     * @param SheetWrapper $sheetWrapper
     */
    public function __construct(array $context, Environment $environment, SheetWrapper $sheetWrapper)
    {
        parent::__construct($context, $environment);

        $this->sheetWrapper = $sheetWrapper;
    }

    /**
     * @param null|int $index
     *
     * @throws LogicException
     */
    public function start(int $index = null)
    {
        if ($this->sheetWrapper->getObject() === null) {
            throw new LogicException();
        }

        if ($index === null) {
            $this->sheetWrapper->increaseRow();
        } else {
            $this->sheetWrapper->setRow($index);
        }
    }

    /**
     * @throws LogicException
     */
    public function end()
    {
        if ($this->sheetWrapper->getObject() === null) {
            throw new LogicException();
        }

        $this->sheetWrapper->setColumn(null);
    }
}
