<?php

namespace BitterGourd\NodeVisitor\Func;

use PhpParser\Node;
use PhpParser\ParserFactory;

class StrShuffle
{

    function __invoke(Node\Expr\FuncCall $node)
    {

        $args = $node->args;

        $code = <<<EOF
            <?php
            call_user_func(function (\$v) {
                \$arr = [];
                for (\$i = 0; \$i < mb_strlen(\$v); \$i++) {
                    \$arr[] = mb_substr(\$v, \$i, 1);
                }
                shuffle(\$arr);
                return implode('', \$arr);
            }, '');
EOF;
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $ast = $parser->parse(trim($code));

        /** @var Node\Stmt\Expression $newNode */
        $newNode = $ast[0];

        $newNode->expr->args = array_merge([$newNode->expr->args[0]], $args);

        $newNode->expr->setAttribute('converted', true);

        return $newNode->expr;
    }

}