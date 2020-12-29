<?php

namespace BitterGourd\NodeVisitor\Func;

use BitterGourd\Common;
use PhpParser\Node;
use PhpParser\ParserFactory;

class Trim
{

    function __invoke(Node\Expr\FuncCall $node)
    {
        $args = $node->args;
        $endName1 = Common::generateVarName();
        $endName2 = Common::generateVarName();

        $code = <<<EOF
            <?php
                call_user_func(function (\$str, \$charlist = " \t\n\r\0\x0B") {
                    \$a = str_split(\$charlist);
                    \$b = \$str;
                    for (\$i = 0; \$i < mb_strlen(\$str); \$i++) {
                        \$s = mb_substr(\$str, \$i, 1);
                        if (array_search(\$s, \$a) === false) {
                            goto $endName1;
                        } else {
                            \$b = mb_substr(\$b, 1);
                        }
                    }
                    $endName1:
                    \$b = strrev(\$b);
                    \$str = \$b;
                    for (\$i = 0; \$i < mb_strlen(\$str); \$i++) {
                        \$s = mb_substr(\$str, \$i, 1);
                        if (array_search(\$s, \$a) === false) {
                            goto $endName2;
                        } else {
                            \$b = mb_substr(\$b, 1);
                        }
                    }
                    $endName2:
                    \$b = strrev(\$b);
                    return \$b;
                }, \$a);
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