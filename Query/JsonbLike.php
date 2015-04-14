<?php

namespace Boldtrn\JsonbBundle\Query;


use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class JsonbLike extends FunctionNode
{
    public $identifier = null;
    public $operator = null;
    public $value = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);

        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        // Read the Identifier
        $this->identifier = $parser->ArithmeticPrimary();

        // Read Comma
        $parser->match(Lexer::T_COMMA);

        // Read Value
        $this->value = $parser->ArithmeticPrimary();


        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return '(' .
        $this->identifier->dispatch($sqlWalker) . ' #>> ' .
        $this->value->dispatch($sqlWalker) .
        ')';
    }
}