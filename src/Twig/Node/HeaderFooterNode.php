<?php

declare(strict_types=1);

namespace MewesK\TwigSpreadsheetBundle\Twig\Node;

use InvalidArgumentException;
use MewesK\TwigSpreadsheetBundle\Wrapper\HeaderFooterWrapper;
use Twig\Compiler;

/**
 * Class HeaderFooterNode.
 */
class HeaderFooterNode extends BaseNode
{
    /**
     * @var string
     */
    private $baseType;

    /**
     * HeaderFooterNode constructor.
     *
     * @param array       $nodes
     * @param array       $attributes
     * @param int         $lineNo
     * @param string|null $tag
     * @param string      $baseType
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $nodes = [], array $attributes = [], int $lineNo = 0, string $tag = null, string $baseType = HeaderFooterWrapper::BASETYPE_HEADER)
    {
        parent::__construct($nodes, $attributes, $lineNo, $tag);

        $this->baseType = HeaderFooterWrapper::validateBaseType(strtolower($baseType));
    }

    /**
     * @param Compiler $compiler
     */
    public function compile(Compiler $compiler)
    {
        $compiler->addDebugInfo($this)
            ->write(self::CODE_FIX_CONTEXT)
            ->write(self::CODE_INSTANCE.'->startHeaderFooter(')
                ->repr($this->baseType)->raw(', ')
                ->subcompile($this->getNode('type'))->raw(', ')
                ->subcompile($this->getNode('properties'))
            ->raw(');'.PHP_EOL)
            ->subcompile($this->getNode('body'))
            ->addDebugInfo($this)
            ->write(self::CODE_INSTANCE.'->endHeaderFooter();'.PHP_EOL);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllowedParents(): array
    {
        return [
            SheetNode::class,
        ];
    }
}
