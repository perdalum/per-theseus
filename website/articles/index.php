<?php require_once ('../php/functions.php');

page_header(
    array(
        'title' => 'Per Møldrup-Dalum | Home', 
        'header' => 'PER MØLDRUP-DALUM', 
        'stylesheets' => array('../css/main.css')));
?>

<h1 style="text-align:center;">Some writings</h1>
 
<dl>

<dt><a href="a-stack-of-books">A Stack of Books</a></dt>
<dd>A challenge to read all unread books</dd>

<dt><a href="Book_analysis">Naive and experimental analysis of authorship</a></dt>
<dd>A first experiment on how to analyse authorship of books using Mathematica</dd>

<dt><a href="IMG_1115.JPG">A Half-naked Ned Flanders</a></dt>
<dd>Ned Flanders is hiding in a LEGO city</dd>

<dt><a href="java-shots">Java Shots</a></dt>
<dd>Using Java for ad-hoc utility programs</dd>

<dt><a href="never-miss-xkcd">Never Again Forget xkcd</a></dt>
<dd>Lately I’ve been forgetting to check xkcd thereby not being in on the loop at my office. So I implemented som Mathematica code to help me.</dd>

<dt><a href="history-of-the-internet">Internettets historie</a></dt>
<dd>Min fortælling om internettets historie</dd>

<dt><a href="ddate">ddate</a></dt>
<dd>Writing a global abbreviation for Mac OS X</dd>

<dt><a href="hiding-stuff-in-stuff">Hiding Stuff in Stuff</a></dt>
<dd>Using Steganography and Mathematica for fooling an audio migration Q/A program</dd>

<dt><a href="city-with-seagulls">City With Seagulls</a></dt>
<dd>Playing with <a href="http://www.fiftythree.com/paper">Paper from 53</a> </dd>

<dt><a href="christmass-visit-by-aage">Julebesøg af Åge 2013</a></dt>
<dd>Nissen fra Frederiks børnehaven  besøger familien</dd>

<dt><a href="sandbox">sandbox</a></dt>
<dd>testing, testing, testing</dd>

</dl>

<script language="Javascript">
var modified = new Date(document.lastModified);
document.write("<center><i><div style='color:lightgrey;font-size:9pt;'>Last changed on " + modified.toISOString() + "</div></i></center>");
// 
</script>

<?php page_footer(true); ?>
