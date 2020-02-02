Bitter Gourd
==========

It is a PHP source code obfuscator, it can make PHP code dirty and hard to read, so far, it is only a development version.

Features
--------

 * No dependence.
 * For any PHP framework.
 * **Overall performance may be reduced by 1% -?%.**

Quick Start
-----------

    git clone https://github.com/imsheng/bitter-gourd.git
    
    cd bitter-gourd
    
    composer install
    
    php bin/console -h
    or
    php bin/console -p/my_project
    or
    php bin/console -f/test.php


Example
-----------
before
```php
<?php

$str='abc';
if ($str=='abc')
{
    echo "abc";
}

$favcolor="red";
switch ($favcolor)
{
case "red":
    echo "red!";
    break;
case "blue":
    echo "blue!";
    break;
default:
    echo '??';
}

$c=count([1,2,3]);
```
after
```php
<?php

${call_user_func(function () {
    $b = array('t', 's', 'r');
    return $b[1] . $b[0] . $b[2];
})} = call_user_func(function () {
    $b = array('c', 'a', 'b');
    return $b[1] . $b[2] . $b[0];
});
switch (${call_user_func(function () {
    $b = array('r', 't', 's');
    return $b[2] . $b[1] . $b[0];
})} == call_user_func(function () {
    $b = array('b', 'c', 'a');
    return $b[2] . $b[0] . $b[1];
})) {
    case false:
        goto var_3cc28eda4671dbf7aa218a290eaa1a47;
    case true:
        echo "abc";
        goto var_3cc28eda4671dbf7aa218a290eaa1a47;
    default:
        goto var_3cc28eda4671dbf7aa218a290eaa1a47;
}
var_3cc28eda4671dbf7aa218a290eaa1a47:
${call_user_func(function () {
    $b = array('r', 'c', 'l', 'v', 'a', 'o', 'f');
    return $b[6] . $b[4] . $b[3] . $b[1] . $b[5] . $b[2] . $b[5] . $b[0];
})} = "red";
if (${call_user_func(function () {
    $b = array('o', 'c', 'v', 'a', 'f', 'l', 'r');
    return $b[4] . $b[3] . $b[2] . $b[1] . $b[0] . $b[5] . $b[0] . $b[6];
})} == "red") {
    echo "red!";
    $v30720d7907a85edd2618d558bf972f6a = true;
}
if (${call_user_func(function () {
    $b = array('o', 'c', 'v', 'a', 'f', 'l', 'r');
    return $b[4] . $b[3] . $b[2] . $b[1] . $b[0] . $b[5] . $b[0] . $b[6];
})} == "blue") {
    echo "blue!";
    $v30720d7907a85edd2618d558bf972f6a = true;
}
if ($v30720d7907a85edd2618d558bf972f6a == false) {
    echo call_user_func(function () {
        $b = array('?');
        return $b[0] . $b[0];
    });
    $v30720d7907a85edd2618d558bf972f6a = true;
}
$c = call_user_func(function ($v, $mode = 0) {
    $s = 0;
    foreach ($v as $i) {
        $s++;
    }
    return $s;
}, [1, 2, 3]);
```

捐助
-----------
每天都为房子发愁，头发都白了 首付还没有着落。-_-!

|  <img src="https://www.web3721.com/alipay.jpg" width="300">   | <img src="https://www.web3721.com/wechat.png" width="300">   |
|  ----  | ----  |
