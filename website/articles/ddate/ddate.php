<?php require_once ('../../php/functions.php');

page_header(
    array(
        'title' => 'Per Møldrup-Dalum | Articles', 
        'header' => 'PER MØLDRUP-DALUM', 
        'stylesheets' => array('../../css/main.css')));
?>

<h1>ddate</h1>
<p><em>October 26, 2013</em></p>
<p>
For a rather long time I've had Textexpander installed but as time went by only one class of expansion remained in use. That class is date and time expansions. E.g. my most used expansion abbreviation was <em>ddate</em> that expanded to <em>{year}-{month}-{day}</em> so that I easily could create date stamps when writing journals and logfiles. 
</p>

<p>In the recent months I've been trying to eliminate unnessacary cruft from my Mac in form of extensions, apps and what not. When the time came to Textexpander I realised that I really needed the ddate abbreviation but didn't want a complete app for just that one functionality.
</p>

<p>
Applescript is one of the things that sets Mac OS (both the old ones and OS X) aside from its brother and sisters in the OS families. A global script language that can both control applications and the underlying operating system. It's pure genious — until you actual need to program in that Applescript language.
</p>

<p>
I've tried programming in Comal-80, BASIC, Pascal, C, FORTRAN, Forth, LISP, LOGO, C++, Beta, Java, Scala, Ruby, Python, Perl, Tcl, Mathematica, R, Haskel, Erlang, but Applescript stands alone as the most wierd language both syntax wise, environment, and the way you approach a programming task. Still, it's fun.
</p>

<p>
Let's hack…
</p>

<p>
Create a new Automator Service that receives <em>no input in every program</em>. Add a "Run Applescript" action with the following code
</p>
<pre>
on run {input, parameters}
	
	set theDate to (current date)
	
	set theDateString to (year of theDate &amp; "-" &amp; (month of theDate as number) &amp; "-" &amp; the day of theDate) as string
	
	-- save the clipboard
	set theClipboard to the clipboard
	
	— put the date on the clipboard
	set the clipboard to theDateString
	— paste the clipboard
	tell application "System Events" to keystroke (the clipboard)
	
	— restore the clipboard
	set the clipboard to theClipboard
	return input
end run
</pre>

<p>
Save the Automator action in a good place, e.g. ~/Library/Scripts. You will then have the ddate action available on the Services menu in every application. Next step is to add a keyboard shortcut. This is done by selecting the Services Preferences and adding a shortcut.
</p>

<div class="display-image">
<a href="ddate-service.png">
<img class="display" alt="ddate-service" src="ddate-service.png"/>
</a>
</div>

<?php page_footer(true); ?>
