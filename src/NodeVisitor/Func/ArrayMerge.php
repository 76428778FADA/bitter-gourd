<?php

namespace BitterGourd\NodeVisitor\Func;

use PhpParser\Node;
use PhpParser\ParserFactory;

class ArrayMerge
{

    function __invoke(Node\Expr\FuncCall $node)
    {

        $code = <<<EOF
            <?php
            call_user_func(function () {
                \$v = func_get_args();
                \$a = [];
                foreach (\$v as \$vi) {
                    foreach (\$vi as \$k => \$i) {
                        if (is_string(\$k)) {
                            \$a[\$k] = \$i;
                        } else {
                            \$a[] = \$i;
                        }
                    }
                }
                return \$a;
            }, null, null);
EOF;
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $ast = $parser->parse(trim($code));

        /** @var Node\Stmt\Expression $newNode */
        $newNode = $ast[0];

        $nodeArgs = $node->args;

        $newNode->expr->args = array_merge([$newNode->expr->args[0]], $nodeArgs);

        $newNode->expr->setAttribute('converted', true);

        return $newNode->expr;
    }

}