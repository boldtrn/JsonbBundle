<?php

namespace Boldtrn\JsonbBundle\Query;


use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;


/**
 * Class JsonbLike
 *
 * JsonbContains ::= "JSONB_#>>" "(" LeftHandSide "," RightHandSide ")"
 *
 * This will be converted to: "( LeftHandSide #>> RightHandSide )"
 *
 * @package Boldtrn\JsonbBundle\Query
 * @author Robin Boldt <boldtrn@gmail.com>
 */
class JsonbHashGreaterGreater extends FunctionNode
{
    public $rightHandSide = null;
    public $leftHandSide = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->rightHandSide = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->leftHandSide = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return '(' .
        $this->rightHandSide->dispatch($sqlWalker) . ' #>> ' .
        $this->leftHandSide->dispatch($sqlWalker) .
        ')';
    }
}