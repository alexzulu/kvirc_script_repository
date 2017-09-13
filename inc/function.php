<?php
function array_sort_by_column(&$array, $column, $direction = SORT_ASC) {
    $reference_array = array();

    foreach($array as $key => $row) {
        $reference_array[$key] = $row[$column];
    }
    $array_lowercase = array_map('strtolower', $reference_array);
    array_multisort($array_lowercase, $direction, $array);
}

function phpist_get_array_by_key ($array, $key){
    foreach ($array as $val){
        $ret[] = $val[$key];
    }
    return $ret;
}
?>
