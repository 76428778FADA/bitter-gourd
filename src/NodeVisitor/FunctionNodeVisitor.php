<?php

namespace BitterGourd\NodeVisitor;

use BitterGourd\Common;
use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;

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

    private function f_array_merge(Node\Expr\FuncCall $node)
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

    private function f_count(Node\Expr\FuncCall $node)
    {
        $code = <<<EOF
            <?php
            call_user_func(function(\$v,\$mode=0){
                \$s = 0;
                foreach (\$v as \$i) {
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

    private function f_array_push(Node\Expr\FuncCall $node)
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

    private function f_trim(Node\Expr\FuncCall $node)
    {

        $args = $node->args;

        $code = <<<EOF
            <?php
                call_user_func(function (\$str, \$charlist = " \t\n\r\0\x0B") {
                    \$a = str_split(\$charlist);
                    \$b = \$str;
                    for (\$i = 0; \$i < mb_strlen(\$str); \$i++) {
                        \$s = mb_substr(\$str, \$i, 1);
                        if (array_search(\$s, \$a) === false) {
                            break;
                        } else {
                            \$b = mb_substr(\$b, 1);
                        }
                    }
                    \$b = strrev(\$b);
                    \$str = \$b;
                    for (\$i = 0; \$i < mb_strlen(\$str); \$i++) {
                        \$s = mb_substr(\$str, \$i, 1);
                        if (array_search(\$s, \$a) === false) {
                            break;
                        } else {
                            \$b = mb_substr(\$b, 1);
                        }
                    }
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

    private function f_strlen(Node\Expr\FuncCall $node)
    {

        $args = $node->args;

        $code = <<<EOF
            <?php
                call_user_func(function (\$v) {
                    \$s = 0;
                    while (true) {
                        if (mb_substr(\$v, \$s, 1) == '') {
                            break;
                        } else {
                            \$s++;
                        }
                    }
                    return \$s;
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

    private function f_mb_strlen(Node\Expr\FuncCall $node)
    {
        return $this->f_strlen($node);
    }

    private function f_str_shuffle(Node\Expr\FuncCall $node)
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
