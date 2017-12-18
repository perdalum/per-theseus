<?php require_once ('../../php/functions.php');

page_header(
    array(
        'title' => 'Per Møldrup-Dalum | Articles', 
        'header' => 'PER MØLDRUP-DALUM', 
        'stylesheets' => array('../../css/main.css')));
?>

<h1>Hiding Stuff in Other Stuff</h1>
<p><em>April i5, 2013</em></p>
<h2>The Set-up</h2>
<p>
At my company some of my colleagues have been developing a tool for cross correlating sound files. What this tool actually does and how it does it, can be studied at <a href="https://github.com/openplanets/scape-xcorrsound">its Github page</a>. Basically the tool compares two versions of the same audio file and detects whether they represent the same sound or not. The usage scenario for this tool is to test for migration errors when migrating a sound file form one format to another.
</p>

<p>
We were given the challenge of trying to fool this tool with the goal of improving it by finding gaps in its ability to detect migration errors. If you give such a challenge to a bunch of nerds, they deliver and when the price for fooling it would be an Easter egg, be ready for a lot of submitted files.
</p>
<h2>The Idea</h2>
<p>
Of course I also wanted to take part in the fun and after a couple of days of brooding I got an idea (I’m a big fan of <a href="http://www.youtube.com/watch?v=f84n5oFoZBc">Hammock Driven Development</a> so remember to sleep on a problem). For some years I’ve been wanting to learn how steganography works in pratice and this seemed like the perfect opportunity. Not that steganography would be part of or a risk in any real world migrations, but more on that in the concluding section.
</p>

<p>
So, what should I hide in the digital representation of the sound? Well, the sound bite started with the Huey Lewis and the News song The Power of Love which was used in the Back to the Future movie so I found this image of that movie’s poster
</p>


<div class="display-image">
<a href="back-to-the-future-poster.jpg">
<img class="display" alt="back-to-the-future-poster" src="back-to-the-future-poster.jpg"/>
</a>
</div>

<h2>The Research</h2>
<p>
A couple of years ago I read the <a href="http://blog.wolfram.com/2010/07/08/doing-spy-stuff-with-mathematica/">Doing Spy Stuff with Mathematica</a> article that explains a lot about how to do embed your own bits in a stream of bytes with out affecting the analog data of the digital representation. As the article shows how to embed an image within another image, I still needed more knowledge as I wanted to use a WAV file as the <em>carrier</em> data.
</p>

<p>
When searching the web I stumbled upon <a href="http://www.codeproject.com/Articles/6960/Steganography-VIII-Hiding-Data-in-Wave-Audio-Files">Steganograpgy VIII - Hiding Data in Wave Audio Files</a> which actually presented an implementation, albeit in C# and I wanted to do it in <em>Mathematica</em>. Still from the article I learned that a Wave file has a header consisting of 22 bytes. (Well, now that I write this I’m unsure whether it’s 22 bytes or 22 16 bit words? My solution isn’t affected by this as I use a header length of 22 16 bit words – alas, I had to work with a deadline.)
</p>
<h2>The Implementation</h2>
<p>
Here follows a step-by-step description of how to hide bits in an WAVE file using <em>Mathematica</em>. It might not be the best solution, but it works.
</p>
<h4>Encoding the data</h4>
<p>
To embed an image using this technique we need the image data as a text string. To read an image from the web an convert it to a string, use the following expression
</p>
<pre lang="Mathematica">
imgURL="http://www.okprintit.com/wp-content/uploads/2011/06/back-to-the-future-poster.jpg";
imageString = ExportString[Import[imgURL],"JPG"];</pre>
<p>
Next I want to read a WAVE audio file as a list of 16 bit words.
</p>
<pre lang="Mathematica">
audioFile="/Users/perdalum/Desktop/challenge.wav";
carrierSound = BinaryReadList[audiofile, "UnsignedInteger16"];</pre>
<p>
I then split this list into the header and the data part. The header needs to be output as is while the data part will be modified to carry the <code>imageString</code>.
</p>
<pre lang="Mathematica">
header = carrierSound[[1;;22]];
data = carrierSound[[23;;]];</pre>
<p>
I want to hide my data in the least significant bit of every 16 bit word or at least for as many words as nessecary dependent on the size of my own data. To make it easy to combine my own data and the carrier data, I reset every one of the least significant of the carrier data bits by and’ing them with 1111111111111110
</p>
<pre lang="Mathematica">truncatedData = BitAnd[data, 2^^1111111111111110];</pre>
<p>
The <code>n^^a</code> notation in <em>Mathematica</em> means that the number <em>a</em> is represented using base <em>n</em>.
</p>

<p>
To make it easy to extract the embedded data from the carrier, I’ll put the length of this embedded data into the first part of the carrier data. I get the length of my data represented by character codes with the simple <code>Length</code> funtion. That value is then converted to binary digits and then left padded with zeros to ensure they use 32 bits. All this is done with this expression
</p>
<pre lang="Mathematica">lengthCode = PadLeft[
    IntegerDigits[
        Length[ToCharacterCode[imageString]],
    2],
32];</pre>
<p>
Now the message that I would like to hide is the combination of the length of the data and the data it self. The data to embed is transformed into a long list of 1s and 0s this way
</p>
<pre lang="Mathematica">dataAsBinary =
    Flatten[ (* one long list of 1s and 0s *)
        IntegerDigits[ (* convert to 8-bit binary *)
            ToCharacterCode[imageString], 2, 8]];</pre>
<p>
I can now create the complete list of bits for embedding in the carrier data by joining the header with the data and left padding uptil the length of the carrier data.
</p>
<pre lang="Mathematica">secretBits = PadRight[Join[lengthCode, dataAsBinary],
    Length[truncatedData]];</pre>
<p>
To actual combine the secretBits with the carrier data I just add the two lists up
</p>
<pre lang="Mathematica">newdata = truncatedData + secretBits;</pre>
<p>
The new audio file is written to disk like this
</p>
<pre lang="Mahtematica">newFile = "/Users/perdalum/Desktop/challenge-changed.wav";

BinaryWrite[newFile,
    Join[header, newData],
    "UnsignedInteger16"];

Close[newFile];</pre>
<h4>Decoding the data</h4>
<p>
It’s much easier to decode a hidden message then encoding. I start by reading the binary data in the same way as before
</p>
<pre lang="Mathematica">encodedFile = "/Users/perdalum/Desktop/challenge-changed.wav";
encodedCarrierSound = BinaryReadList[fname, "UnsignedInteger16"];</pre>
<p>
Then I ignore the WAVE header
</p>
<pre lang="Mathematica">encodedData = encodedCarrierSound[[23 ;;]];</pre>
<p>
The hidden bits including any right padded 0-bits is extracted by bit and’ing every 16 bit word sound sample with 0000000000000001 and flattening that list and gathering the bits in bytes (8 bit words)
</p>
<pre lang="Mathematica">hiddenBytes = Partition[Flatten[BitAnd[encodedData, 1]],8];</pre>
<p>
To extract the hidden data we need the length of that data
</p>
<pre lang="Mathematica">messageLength = FromDigits[Flatten[hiddenBytes[[1 ;; 4]]], 2];</pre>
<p>
At last we can convert from character code to actual data by converting every byte in the from binary to decimal using<code>FromDigits</code> and again converting that list of character codes to characters using <code>FromCharacterCode</code>
</p>
<pre lang="Mathematica">hiddenData = FromCharacterCode[
    FromDigits[#, 2] &amp; /@ hiddenBytes[[5 ;; messageLength + 4]]]]</pre>
<p>
In <em>Mathematica</em> that data can be displayed in the GUI by importing it as an image
</p>
<pre lang="Mathematica">ImportString[hiddenData,"JPG"]</pre>
<p>
That was fun!
</p>
<h2>Conclusion</h2>
<p>
The above hackery actually succeded in fooling the migration Q/A tool and enabling me to bring home some chocolate Easter bunnies for my wife (as a small token of me not talking to her for a couple of evenings when hacking on this).
</p>

<p>
Does it have any real applications? Well, if you created a company that did audio migrations for archiving institutions, you would be able to hide, and thereby preserve, your own data at the archiving institution without them knowing.
</p>

<p>
Analog data is, oposite to digital data, rather incensitive to very small changes. In digital data, i.e. the Linux kernel, even a one bit change can render the data corrupt. When changing one bit in every sound sample of analog audio data represented as digital data neither the human ear nor our migration Q/A tool can detect any difference (The tool can actual detect the change if the sensitivity of the tool is turned to 11 :-). This feature can, like I’ve shown, be used for storing data or it can originate from bit-rot or a errorprone migration process.
</p>
<h2>Funtions</h2>
<pre lang="Mathematica">

encodeMessage[carrierFileName_String, message_String, encodedFilename_String] := Module[
    {carrierSound,
     header,
     data,
     truncatedData,
     lengthCode,
     secretBits,
     codedData},

    (* Start by reading the WAVE audio file as a list of 16 bits words *)
    carrierSound = BinaryReadList[carrierFileName, "UnsignedInteger16"];

    (* The WAVE file format is described on
       http://www.codeproject.com/Articles/6960/Steganography-VIII-Hiding-Data-in-Wave-Audio-Files. A WAVE file header is 22 bytes long
     *)
    header = carrierSound[[1 ;; 22]];

    (* the rest of the file is the data in which we can embed the message *)
    data = carrierSound[[23 ;;]];
    truncatedData = BitAnd[data, 2^^1111111111111110];

    (* to make it easy to decode the message, I put the length of the message in the first four bytes *)
    lengthCode = PadLeft[

    IntegerDigits[Length[ToCharacterCode[message]],2], 32];

    secretBits = PadRight[
        Join[
            lengthCode,
            Flatten[IntegerDigits[ToCharacterCode[message], 2, 8]]],
        Length[truncatedData]];

    (* combine the carrier and the message *)
    codedData = truncatedData + secretBits;

    (* create a new file with the embedded message *)
    BinaryWrite[encodedFilename, Join[header, codedData], "UnsignedInteger16"];
    Close[encodedFilename]]

decodeMessage[fname_String] := Module[
    {encodedCarrierSound,
     encodedData,
     message,
     messageLength},

    encodedCarrierSound = BinaryReadList[fname, "UnsignedInteger16"];

    (* Ignore the WAVE header *)
    encodedData = encodedCarrierSound[[23 ;;]];

    (* flatten and gather in new bytes *)
    message = Partition[Flatten[BitAnd[encodedData, 1]], 8];

    (* the length of the actual message is in the first four bytes *)
    messageLength = FromDigits[Flatten[message[[1 ;; 4]]], 2];

    FromCharacterCode[FromDigits[#, 2] &amp; /@ message[[5 ;; messageLength + 4]]]]</pre>

<?php page_footer(true); ?>
