<?php

namespace MewesK\TwigExcelBundle\Twig\TokenParser;

use MewesK\TwigExcelBundle\Twig\Node\XlsFooterNode;
use Twig_Node_Expression_Array;
use Twig_Node_Expression_Constant;
use Twig_Token;
use Twig_TokenParser;

/**
 * Class XlsFooterTokenParser
 *
 * @package MewesK\TwigExcelBundle\Twig\TokenParser
 */
class XlsFooterTokenParser extends Twig_TokenParser
{
    /**
     * @param Twig_Token $token
     *
     * @return XlsFooterNode
     * @throws \Twig_Error_Syntax
     */
    public function parse(Twig_Token $token)
    {
        $type = new Twig_Node_Expression_Constant('footer', $token->getLine());
        if (!$this->parser->getStream()->test(Twig_Token::PUNCTUATION_TYPE) && !$this->parser->getStream()->test(Twig_Token::BLOCK_END_TYPE)) {
            $type = $this->parser->getExpressionParser()->parseExpression();
        }

        $properties = new Twig_Node_Expression_Array([], $token->getLine());
        if (!$this->parser->getStream()->test(Twig_Token::BLOCK_END_TYPE)) {
            $properties = $this->parser->getExpressionParser()->parseExpression();
        }

        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);
        $tokenParser = $this; // PHP 5.3 fix
        $body = $this->parser->subparse(function(Twig_Token $token) use ($tokenParser) { return $token->test('end'.$tokenParser->getTag()); }, true);
        $this->parser->getStream()->expect(Twig_Token::BLOCK_END_TYPE);

        return new XlsFooterNode($type, $properties, $body, $token->getLine(), $this->getTag());
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return 'xlsfooter';
    }
}
