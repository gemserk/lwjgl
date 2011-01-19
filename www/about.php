<? require('_include/header.php'); ?>

<h1>About</h1>
<p>
	<i>Taken from a <a href="http://www.javagaming.org/cgi-bin/JGNetForums/YaBB.cgi?board=LWJGL;action=display;num=1067072465;start=31#31" target="_blank">post by Caspian</a> on Javagaming.org</i><br/><br/>
	In response to everything here I'd like to state our goals with LWJGL:
</p>
<ul>
 	<li>Speed</li>
	<li>Simplicity</li>
	<li>Ubiquity</li>
	<li>Smallness</li>
	<li>Security</li>
	<li>Robustness</li>
	<li>Minimalism</li>
</ul>
<p>
	and this will help explain how we got to where we are today and more importantly where we're going and where we're not going.
</p>

<p>
	<b>Speed</b><br/>
	The whole point of LWJGL was to bring the speed of Java rendering into the 21st century. This is why we have:
</p>
<ul>
	<li>Thrown out methods designed for efficient C programming that make no sense at all in java, such as glColor3fv.</li>
	<li>Made the library throw an exception when hardware acceleration is not available on Windows. No point in running at 5fps is there?</li>
</ul>

<p>
	<b>Ubiquity</b><br/>
	Our library is designed to work on devices as small as phones right the way up to multiprocessor rendering servers. Just because there aren't any phones or consoles yet with fast enough JVMs and 3d acceleration is neither here nor there - there will be, one day. We're carefully tailoring the library so that when it happens we'll have OpenGL ES support in there just like that. This means that:
</p>
<ul>
	<li>We had to have a very small footprint or it'll never catch on in the J2ME space at all. That's why the binary distribution is under half a meg, and that takes care of 3d sound, graphics, and IO.</li>
	<li>Even under desktop environments having a 1-2mb download just to call a few 3D functions is daft.</li>
	<li>We've worked to a lowest common denominator principle rather than attempting to design for all possibilities, but we've made sure that 99% of required uses are covered. That's why we've only got one window, and why we don't guarantee that windowed mode is even supported (it's officially a debug mode and hence we don't even supply some very basic windowy abilities that you'd get in AWT) and why we don't allow multiple thread rendering contexts.</li>
</ul>

<p>
	<b>Simplicity</b><br/>
	LWJGL needed to be simple for it to be used by a wide range of developers. We wanted relative newbies to be able to get on with it, and professionals to be able to use it professionally, maybe typically coming from a C++ background. We had to choose a paradigm that actually fits with OpenGL, and one that fits with our target platforms which ranges from PDA to desktop level. This is why:
</p>
<ul>
	<li>We aren't catering for single-buffered drawing</li>
	<li>We don't require that an instance of GL is passed around all over the place but we do not prevent this style of coding. See below for why.</li>
	<li>We removed a lot of stuff that 99% of games programmers need to know nothing about</li>
	<li>We have decided that consistency is better than complexity. Rather than allowing multiple ways to call the same methods and bloating the library we've just said, "Right, no arrays. They're slower anyway. Get used to buffers, as this is what buffers are meant to be used for."</li>
</ul>

<p>
	<b>Smallness</b><br/>
	See ubiquity above. We had to be small.
</p>
<ul>
	<li>Small == simple. The less ways there are to do something, the easier it is to learn the only way that works or is allowed.</li>
	<li>Small == our code is less buggy. Wouldn't you rather be hunting for bugs in your own code, not ours?</li>
	<li>Small == downloadable. No version nightmares. LWJGL is small enough to download with every application that uses it.</li>
	<li>Small == J2ME.</li>
</ul>

<p>
	<b>Security</b><br/>
	We realised a few months ago that no-one was going to take us seriously if we couldn't guarantee the security of the LWJGL native libraries. This is why we:
</p>
<ul>
	<li>No longer use pointers but exclusively use buffers instead</li>
	<li>Are gradually adding further checks to buffer positions and limits to ensure that the values are within allowed ranges to prevent buffer attacks</li>
</ul>

<p>
	<b>Robustness</b><br/>
	Similarly to security we have now realised that a reliable system is far more useful than a fast system. When we actually had a proper application to benchmark finally we had some real data. Many of our original design decisions were based on microbenchmarks - well, you have to start somewhere! But with a real application to benchmark we now know we can throw out asserts and replace them with a proper if (...) check and a thrown exception. We know also that we can move all that GL error checking out of native code and into Java code and we will no longer need a separate DLL for debug mode.<br/><br/>
	As for runtime exceptions, they have their place. There's not a reasonably well defined argument as to when you should use a runtime exception and when you should use a checked exception. When I made OpenGLException a checked exception all it did was end up littering my code with try {} catch {} sections - except that if you've got an OpenGLException there is very little sensible you can do to rectify it because it should never have occurred in the first place. That's why it's a runtime exception. You should simply not write code than can throw it because it is generally not recoverable nicely. However for robustness (and security) we are required to throw an exception if something is amiss. It falls, I believe, into exactly the same category of trouble as NPEs, ArrayIndexOOBs and ClassCastExceptions: should never occur but needs to be trapped somewhere.
</p>

<p>
	<b>Minimalism</b><br/>
	This is another critical factor in our design decisions. If it doesn't need to be in the library, it's not in the library. Our original aim was to produce a library that provided the bare minimum required to access the hardware that Java couldn't access, and by and large we're sticking to this mantra. The vector math code in the LWJGL is looking mighty scared at the moment because it's probably for the chop - well, at least, from the core library - as it's not an enabling technology at all, and there are numerous more fully featured alternatives. We chucked out GLU because it's mostly irrelevant to game developers except for a few functions that we really need to get redeveloped in pure Java - but basically, GLU is just a library of code built on top of the enablement layer.
</p>

<? require('_include/footer.php'); ?>
