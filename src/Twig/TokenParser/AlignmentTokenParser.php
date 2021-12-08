<?php

namespace MewesK\TwigSpreadsheetBundle\Twig\TokenParser;

use InvalidArgumentException;
use MewesK\TwigSpreadsheetBundle\Twig\Node\AlignmentNode;
use MewesK\TwigSpreadsheetBundle\Wrapper\HeaderFooterWrapper;
use Twig\Node\Node;

/**
 * Class AlignmentTokenParser.
 */
class AlignmentTokenParser extends BaseTokenParser
{
    /**
     * @var string
     */
    private $alignment;

    /**
     * AlignmentTokenParser constructor.
     *
     * @param array  $attributes optional attributes for the corresponding node
     * @param string $alignment
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $attributes = [], string $alignment = HeaderFooterWrapper::ALIGNMENT_CENTER)
    {
        parent::__construct($attributes);

        $this->alignment = HeaderFooterWrapper::validateAlignment(strtolower($alignment));
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public function createNode(array $nodes = [], int $lineNo = 0): Node
    {
        return new AlignmentNode($nodes, $this->getAttributes(), $lineNo, $this->getTag(), $this->alignment);
    }

    /**
     * {@inheritdoc}
     */
    public function getTag(): string
    {
        return 'xls'.$this->alignment;
    }
}
