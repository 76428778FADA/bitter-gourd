<?php

namespace BitterGourd\NodeVisitor;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;

class FunctionNodeVisitor extends NodeVisitorAbstract
{

    public function leaveNode(Node $node)
    {
        if ($node instanceof Node\Expr\FuncCall && $node->getAttribute('converted') != true) {
            $node->setAttribute('parent', null);

            if ($node->name instanceof Node\Name && method_exists($this, 'f_' . $node->name->parts[0])) {
                return $this->{'f_' . $node->name->parts[0]}($node);
            }

            return $node;
        }
    }

    private function f_array_mergexxx(Node\Expr\FuncCall $node)
    {
        $code = <<<EOF
            <?php
            call_user_func(function(\$v){
                return \$s;
            },null);
EOF;
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $ast = $parser->parse(trim($code));

        /** @var Node\Stmt\Expression $newNode */
        $newNode = $ast[0];

        $newNode->expr->args[1] = $node->args[0];

        $newNode->expr->setAttribute('converted', true);

        return $newNode->expr;
    }

    private function f_count(Node\Expr\FuncCall $node)
    {
        $code = <<<EOF
            <?php
            call_user_func(function(\$v,\$mode=0){
                \$s=0;
                foreach(\$v as \$i){
                 \$s++;   
                }
                return \$s;
            },null);
EOF;
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $ast = $parser->parse(trim($code));

        /** @var Node\Stmt\Expression $newNode */
        $newNode = $ast[0];

        $newNode->expr->args[1] = $node->args[0];

        $newNode->expr->setAttribute('converted', true);

        return $newNode->expr;
    }


}