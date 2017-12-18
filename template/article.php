<?php require_once ('../../php/functions.php');

page_header(
    array(
        'title' => 'Per Møldrup-Dalum | Articles', 
        'header' => 'PER MØLDRUP-DALUM', 
        'stylesheets' => array('../../css/main.css'),
        'use_math' => 'yes')); // or no
?>

<h1>TITLE</h1>
<em>12 marts 2014</em>

<h2>Image</h2>
<center><img src="./img.png" width = "80%"/>

<h2>Code</h2>
<pre lang="R">
foo <- 12.2

bar <- function(a, b) {
  a + 2 * b
}
</pre>

<h2>Math</h2>
<p>
When \(a \ne 0\), there are two solutions to \(ax^2 + bx + c = 0\) and they are
$$x = {-b \pm \sqrt{b^2-4ac} \over 2a}.$$
</p>

<a href="#top">Tilbage til toppen af siden</a>

<?php page_footer(true); ?>
