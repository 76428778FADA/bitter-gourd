<?php

namespace BitterGourd\NodeVisitor\Func;

use PhpParser\Node;
use PhpParser\ParserFactory;

class Hex2bin
{

    function __invoke(Node\Expr\FuncCall $node)
    {

        $code = <<<EOF
            <?php
            call_user_func(function () {
                \$str = '';
                \$h = func_get_arg(0);
                for (\$i = 0; \$i < strlen(\$h) - 1; \$i += 2)
                    \$str .= chr(hexdec(\$h[\$i] . \$h[\$i + 1]));
                return \$str;
            },\$a);
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