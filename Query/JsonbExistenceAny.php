<?php

namespace Boldtrn\JsonbBundle\Query;


use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * Class JsonbExistenceAny
 *
 * JsonbExistenceAny ::= "JSONB_EX_ANY" "(" LeftHandSide "," RightHandSide ")"
 *
 * This will be converted to: "jsonb_exists_any( LeftHandSide, RightHandSide )"
 *
 * RightHandSide is a PHP array
 * @example in WHERE clause: JSONB_EX_ANY(blogPost.tags, :tags) = TRUE
 *
 * @package Boldtrn\JsonbBundle\Query
 * @author Robin Boldt <boldtrn@gmail.com>
 * @author Pierre Boissinot <pierre.boissinot@outlook.fr>
 */
class JsonbExistenceAny extends FunctionNode
{
    public $leftHandSide;
    public $rightHandSide;

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->leftHandSide = $parser->StringPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->rightHandSide = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker)
    {
        // We use a workaround to allow this statement in a WHERE. Doctrine relies on the existence of an ComparisonOperator
        return 'jsonb_exists_any(' .
        $this->leftHandSide->dispatch($sqlWalker) .', '.
        'ARRAY['.$this->rightHandSide->dispatch($sqlWalker) . ']'.
        ')';
    }
}
