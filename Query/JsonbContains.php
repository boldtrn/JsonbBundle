<?php

namespace Boldtrn\JsonbBundle\Query;


use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * Class JsonbContains
 *
 * JsonbContains ::= "JSONB_CONTAINS" "(" EntityField "," ContainsExpression ")"
 *
 * @package Boldtrn\JsonbBundle\Query
 * @author Robin Boldt <boldtrn@gmail.com>
 */
class JsonbContains extends FunctionNode
{
    public $identifier = null;
    public $value = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->identifier = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->value = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        // We use a workaround to allow this statement in a WHERE. Doctrine relies on the existence of an ComparisonOperator
        return '(' .
        $this->identifier->dispatch($sqlWalker) . ' @> ' .
        $this->value->dispatch($sqlWalker) .
        ')';
    }
}