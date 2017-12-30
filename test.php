<?php

$code = uniqid(rand(0,1));
$rand = substr(md5(microtime()),rand(0,26),6);

echo $code;
?><br /><br />
<?php
echo $rand;
