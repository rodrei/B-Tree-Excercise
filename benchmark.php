<?php
    include('lib/Btree.php');
    
    function loadBtree(){
        echo "Loading Serialized BTree... \n";

        $file = @fopen('btree_serialized.txt', 'r');
        if(!$file){
            echo "btree_serialized.txt file not found.\nMake sure you run make_btree_from_dictionary2.php first or uncompress btree_serialized.tar.gz\n";
            exit;
        }
        $str = fread($file, 99999999);
        $btree = unserialize($str);
        echo "Btree loaded! \n";
        return $btree;
    }
    
    function runBenchmark(){
        $btree = loadBtree();
        $existing_words = array('SKANKY', 'WEEKEND', 'EQUIVOCATION', 'PONDERABLE', 'WHEEDLING', 'SLEEK');
        $non_existing_words = array('!!KKK', '!!KDJFKD', 'DFKJDF', 'Z!DF');


        $start = microtime_float();

        foreach($existing_words as $word){
            if(!$btree->hasValue($word))
                throw new Exception('BTREE not working');
        }

        foreach($non_existing_words as $word){
            if($btree->hasValue($word))
                throw new Exception('BTREE not working');
        }

        $end = microtime_float();

        $total_time = ($end-$start);
        $avg_time = $total_time/10;
        echo "Searched 10 words in $total_time seconds\n";
        echo "Average word search time: $avg_time seconds\n";
    }
    
    
    
    function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    runBenchmark();
?>
