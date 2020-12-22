<?php

namespace BitterGourd\NodeVisitor\Func;

use PhpParser\Node;
use PhpParser\ParserFactory;

class ArrayPush
{

    function __invoke(Node\Expr\FuncCall $node)
    {
        $args = $node->args;
        $fArgs = array_shift($args);

        $code = <<<EOF
            <?php
                call_user_func(function () {
                    \$v = func_get_args();
                    \$aa =& \$v[0][0];
                    for (\$i = 1; \$i < count(\$v); \$i++) {
                        \$aa[] = \$v[\$i];
                    }
                    return count(\$aa);
                }, [&\$a], \$v1, \$v2);
EOF;
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $newNode = $parser->parse(trim($code));
        $newNode = $newNode[0];

        $newNode->expr->args[1]->value->items[0]->value = $fArgs;
        $newNode->expr->args = array_merge([$newNode->expr->args[0], $newNode->expr->args[1]], $args);

        $newNode->expr->setAttribute('converted', true);

        return $newNode->expr;
    }

}