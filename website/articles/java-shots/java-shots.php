<?php require_once ('../../php/functions.php');

page_header(
    array(
        'title' => 'Per Møldrup-Dalum | Articles', 
        'header' => 'PER MØLDRUP-DALUM', 
        'stylesheets' => array('../../css/main.css')));
?>

<h1>Java Shots</h1>
<p><em>September 5, 2014</em></p>
<p>
I work in a Java shop. I'm also a command line guy. I know Bash, Tcsh, a bit of Perl (Perl 6 looks especially interesting, even more so when presented by Damian Conway!), a bit of Python. I love dangling in LISP-like and other functional languages. I also like the idea of squeezing every last CPU cycle out of the hardware, wherefore C and C++ sometimes draws my attention.
</p>

<p>
BUT
</p>

<p>
I work in a Java shop. Java is a very effcient platform and I've got no intentions on bashing that language. I mean, it's Turing-complete, right? And the Hotspot compiler makes it very fast. Sometimes I just get the feeling of not being in a Java shop, but in a Maven shop. In an "Everything is a God Damn Object"-shop. In a <X> Framework shop.
</p>

<p>
BUT
</p>

<p>
I'm a command line guy and I like writing small programs, scratching the small itches that working as a programmer brings along. I also know that to become good at something you need to do focused practise. I want to be good at Java. So, today I realised that for a long time I have been pondering on how I could scratch those everyday itches using Java.
</p>

<p>
Then at some point later today I got an idea.
</p>

<p>
I could write small Java programs as usual, as if they were scripts, compile them and stick them into a ~/javaClasses directory and add that directory to the CLASSPATH env variable. Combine that with a dynamic Bash completion function and I've got something that's almost as easy to use as a plain Bash|Perl|Python script.
</p>

<pre>
_java()
{
    local cur=${COMP_WORDS[COMP_CWORD]}
    commands=$(for f in $(find ~/javaClasses/ -type f|egrep -v '\$[0-9]'); do echo $(basename $f .class); done|xargs)

    COMPREPLY=( $(compgen -W "$commands" -- $cur) )
}
complete -F _java java
complete -F _java j
</pre>

<p>
When I create a new program, just do ". ~/bin/javaclasses_completion" and the program can be auto completed as an argument to "java". Actually I've also got the "alias j=java" Bash alias.
</p>

<pre>
$ j &lt;TAB&gt;
</pre>

gives all available Java utility programs. 

<p>
I think that will work for me!
</p>

<?php page_footer(true); ?>
