<?php

declare(strict_types=1);

namespace MewesK\TwigSpreadsheetBundle\Twig\NodeVisitor;

use MewesK\TwigSpreadsheetBundle\Twig\Node\BaseNode;
use MewesK\TwigSpreadsheetBundle\Twig\Node\DocumentNode;
use Twig\Environment;
use Twig\Error\SyntaxError;
use Twig\Node\Node;
use Twig\Node\TextNode;
use Twig\NodeVisitor\AbstractNodeVisitor;

use function get_class;

/**
 * Class SyntaxCheckNodeVisitor.
 */
class SyntaxCheckNodeVisitor extends AbstractNodeVisitor
{
    /**
     * @var array
     */
    protected $path = [];

    /**
     * {@inheritdoc}
     */
    public function getPriority(): int
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     *
     * @throws SyntaxError
     */
    protected function doEnterNode(Node $node, Environment $env): Node
    {
        try {
            if ($node instanceof BaseNode) {
                $this->checkAllowedParents($node);
            } else {
                $this->checkAllowedChildren($node);
            }
        } catch (SyntaxError $e) {
            // reset path since throwing an error prevents doLeaveNode to be called
            $this->path = [];
            throw $e;
        }

        $this->path[] = get_class($node);

        return $node;
    }

    /**
     * {@inheritdoc}
     */
    protected function doLeaveNode(Node $node, Environment $env): ?Node
    {
        array_pop($this->path);

        return $node;
    }

    /**
     * @param Node $node
     *
     * @throws SyntaxError
     */
    private function checkAllowedChildren(Node $node)
    {
        $hasDocumentNode = false;
        $hasTextNode = false;

        /**
         * @var Node $currentNode
         */
        foreach ($node->getIterator() as $currentNode) {
            if ($currentNode instanceof TextNode) {
                if ($hasDocumentNode) {
                    throw new SyntaxError(
                        sprintf(
                            'Node "%s" is not allowed after Node "%s".',
                            TextNode::class,
                            DocumentNode::class
                        )
                    );
                }
                $hasTextNode = true;
            } elseif ($currentNode instanceof DocumentNode) {
                if ($hasTextNode) {
                    throw new SyntaxError(
                        sprintf(
                            'Node "%s" is not allowed before Node "%s".',
                            TextNode::class,
                            DocumentNode::class
                        )
                    );
                }
                $hasDocumentNode = true;
            }
        }
    }

    /**
     * @param BaseNode $node
     *
     * @throws SyntaxError
     */
    private function checkAllowedParents(BaseNode $node)
    {
        $parentName = null;

        // find first parent from this bundle
        foreach (array_reverse($this->path) as $className) {
            if (strpos($className, 'MewesK\\TwigSpreadsheetBundle\\Twig\\Node\\') === 0) {
                $parentName = $className;
                break;
            }
        }

        // allow no parents (e.g. macros, includes)
        if ($parentName === null) {
            return;
        }

        // check if parent is allowed
        foreach ($node->getAllowedParents() as $className) {
            if ($className === $parentName) {
                return;
            }
        }

        throw new SyntaxError(
            sprintf(
                'Node "%s" is not allowed inside of Node "%s".',
                get_class($node),
                $parentName
            )
        );
    }
}
