<?php


namespace BitterGourd;

use PhpParser\ParserFactory;
use PhpParser\Node;

class Common
{

    /**
     * @param $string
     * @return Node|null
     */
    public static function stringNToFuncN($string)
    {
        $binString = bin2hex($string);

        $code = <<<EOF
            <?php
            call_user_func(function () {
                return hex2bin('$binString');
            });
EOF;
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
        $ast = $parser->parse(trim($code));
        /** @var Node\Stmt\Expression $newNode */

        $node = $ast[0];

        return $node->expr;
    }

    static public function generateVarName()
    {
        return sprintf('v%s', uniqid());
    }

}
