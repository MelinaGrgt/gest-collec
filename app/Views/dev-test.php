<pre>
<?php
if (isset($files)) {
    print_r($files);
}
?>
</pre>
<pre>
<?php
if (isset($data)){
    print_r($data);
}
?>
</pre>
<?php
$depart = [2,5];
$final = [4,5,6];
print_r($depart);
print_r($final);
$supp = array();
$add = array();
foreach ($depart as $d) {
    if (!in_array($d, $final)) {
        $supp[] = $d;
    }
}
$final = array_diff($final, $depart);
print_r($supp);
print_r($final);