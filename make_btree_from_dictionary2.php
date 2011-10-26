<?php
include('lib/Btree.php');

$btree = new Btree();

$file = fopen('dictionary2.txt','r');
if(!$file)
    throw new Exception('Cant find file dictionary.txt');

$words = fgets($file);
$words = explode(',', $words);
fclose($file);

foreach($words as $word){
    $btree->insert($word);
    echo '.';
}


$btree_file = fopen('btree_serialized.txt', 'w+');
fwrite($btree_file, serialize($btree));
fclose($btree_file);

echo "\nBTree serialized and saved to btree_serialized.txt\n";

?>
