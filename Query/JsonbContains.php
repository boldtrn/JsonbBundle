<?php

namespace Boldtrn\JsonbBundle\Query;


use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class JsonbContains extends FunctionNode
{
    public $identifier = null;
    public $value = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->identifier = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_NONE);
        $parser->match(Lexer::T_GREATER_THAN);
        $this->value = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return '(' .
        $this->identifier->dispatch($sqlWalker) . ' @> ' .
        $this->value->dispatch($sqlWalker) .
        ')';
    }
}