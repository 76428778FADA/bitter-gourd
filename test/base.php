<?php

$str1 = 'abcde';
$str2 = 'fghij';
$str3 = '   fghij   ';
$str4 = '您好！';
$num1 = 1234;
$num2 = 6789;
$arr1 = [1, 2, 3, 4, 5];
$arr2 = ['a', 'b', 'c', 'd', 'e'];
$arr3 = ['a' => 'f', 'b' => 'g', 'c' => 'h', 'd' => 'i', 'e' => 'j'];
$arr4 = ['f' => 'l', 'g' => 'm', 'h' => 'n', 'i' => 'o', 'j' => 'p'];

echo '# if $str1 == $str2' . PHP_EOL;
if ($str1 == $str2) {
    echo '$str1 == $str2' . PHP_EOL;
} else {
    echo '$str1 != $str2' . PHP_EOL;
}
echo PHP_EOL;

echo '# foreach $arr1' . PHP_EOL;
foreach ($arr1 as $item) {
    echo $item . ' ';
}
echo PHP_EOL . PHP_EOL;

echo '# for $arr2' . PHP_EOL;
for ($i = 0; $i < count($arr2); $i++) {
    echo $arr2[$i] . ' ';
}
echo PHP_EOL . PHP_EOL;

echo '# switch $str1' . PHP_EOL;
switch ($str1) {
    case "abcde":
        echo "abcde!";
        break;
    case "fghij":
        echo "fghij!";
        break;
    default:
        echo '??';
}
echo PHP_EOL . PHP_EOL;

echo '# while $arr2' . PHP_EOL;
$i = 0;
while ($i < count($arr2)) {
    echo $arr2[$i] . ' ';
    $i++;
}
echo PHP_EOL . PHP_EOL;

echo '# array_merge $arr1 $arr2' . PHP_EOL;
print_r(array_merge($arr1, $arr2));
echo PHP_EOL . PHP_EOL;

echo '# count $arr1' . PHP_EOL;
echo count($arr1) . PHP_EOL;
echo PHP_EOL;

echo '# array_push $arr1' . PHP_EOL;
$tArr1 = $arr1;
array_push($tArr1, 6, 7, 8, 9);
print_r($tArr1);
echo PHP_EOL . PHP_EOL;

echo '# trim $str3' . PHP_EOL;
echo trim($str3) . PHP_EOL;
echo PHP_EOL;

echo '# mb_strlen $str4' . PHP_EOL;
echo mb_strlen($str4) . PHP_EOL;
echo PHP_EOL;

echo '# str_shuffle $str1' . PHP_EOL;
echo str_shuffle($str1) . PHP_EOL;
echo PHP_EOL;

echo '# time' . PHP_EOL;
echo time() . PHP_EOL;
echo PHP_EOL;