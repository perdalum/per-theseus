<?php require_once ('../../php/functions.php');

page_header(
    array(
        'title' => 'Per Møldrup-Dalum | Articles', 
        'header' => 'PER MØLDRUP-DALUM', 
        'stylesheets' => array('../../css/main.css')));
?>

<h1>Never miss another xkcd</h1>
<p><em>Maj 8, 2014</em></p>
<p>
Lately I’ve been forgetting to check xkcd thereby not being in on the loop
at my office. Therefore:
</p>

<pre>
#!/usr/local/bin/MathematicaScript -script

(* get today's xkcd as it is defined in it's JSON data *)
json=Import["http://xkcd.com/info.0.json", "JSON"];

Export[$HomeDirectory <> "/Data/xkcd.png",
    Labeled[
        Import["img" /. json,"PNG"], (* get the comic strip *)
        Style[
            "alt" /. json,           (* extract the alt-text *)
            Background->LightYellow]]]
</pre>

<p>
A launchd configuration, created with 
<a title="Lingon" href="https://itunes.apple.com/dk/app/lingon/id411211026?l=da&amp;mt=12">Lingon</a>,
to refresh the image file each day and a 
<a title="GeekTool" href="http://projects.tynsoe.org/en/geektool/">GeekTool</a> 
setup that places the daily generated image on the top left corner of my Desktop.
</p> 

<p>
<div class="display-image">
<a href="never-miss-xkcd.png">
<img class="display" alt="Desktop, Vim, and Mathematica" src="never-miss-xkcd.png" >
</a>
<p class="img-caption">
Desktop, Vim, and Mathematica
</p>
</div>
</p>


<?php page_footer(true); ?>
