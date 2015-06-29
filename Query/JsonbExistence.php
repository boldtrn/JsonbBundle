<?php

namespace Boldtrn\JsonbBundle\Query;


use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * Class JsonbContains
 *
 * JsonbAtGreater ::= "JSONB_AG" "(" LeftHandSide "," RightHandSide ")"
 *
 * This will be converted to: "( LeftHandSide @> RightHandSide )"
 *
 * @package Boldtrn\JsonbBundle\Query
 * @author Robin Boldt <boldtrn@gmail.com>
 */
class JsonbExistence extends FunctionNode
{
    public $leftHandSide = null;
    public $rightHandSide = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->leftHandSide = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->rightHandSide = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        // We use a workaround to allow this statement in a WHERE. Doctrine relies on the existence of an ComparisonOperator
        return '(' .
        $this->leftHandSide->dispatch($sqlWalker) . ' ? ' .
        $this->rightHandSide->dispatch($sqlWalker) .
        ')';
    }
}