<?php

namespace BitterGourd\NodeVisitor\Func;

use PhpParser\Node;
use PhpParser\ParserFactory;

class Time
{

    function __invoke(Node\Expr\FuncCall $node)
    {
        $code = <<<EOF
            <?php
                intval(explode(' ', microtime())[1]);
EOF;
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $ast = $parser->parse(trim($code));

        /** @var Node\Stmt\Expression $newNode */
        $newNode = $ast[0];

        $newNode->expr->setAttribute('converted', true);

        return $newNode->expr;
    }

}