<?php

class helpers
{
    function permutations($pool, $r = null) 
    {
        $n = count($pool);
    
        if ($r == null) {
            $r = $n;
        }
    
        if ($r > $n) {
            return;
        }
    
        $indices = range(0, $n - 1);
        $cycles = range($n, $n - $r + 1, -1); // count down
    
        yield array_slice($pool, 0, $r);
    
        if ($n <= 0) {
            return;
        }
    
        while (true) {
            $exit_early = false;
            for ($i = $r;$i--;$i >= 0) {
                $cycles[$i]-= 1;
                if ($cycles[$i] == 0) {
                    // Push whatever is at index $i to the end, move everything back
                    if ($i < count($indices)) {
                        $removed = array_splice($indices, $i, 1);
                        array_push($indices, $removed[0]);
                    }
                    $cycles[$i] = $n - $i;
                } else {
                    $j = $cycles[$i];
                    // Swap indices $i & -$j.
                    $i_val = $indices[$i];
                    $neg_j_val = $indices[count($indices) - $j];
                    $indices[$i] = $neg_j_val;
                    $indices[count($indices) - $j] = $i_val;
                    $result = [];
                    $counter = 0;
                    foreach ($indices as $indx) {
                        array_push($result, $pool[$indx]);
                        $counter++;
                        if ($counter == $r) break;
                    }
                    yield $result;
                    $exit_early = true;
                    break;
                }
            }
            if (!$exit_early) {
                break; // Outer while loop
            }
        }
    }
}
?>