<? require('_include/header.php'); ?>

<h1>Frequently Asked Questions</h1>
<p>If you have a question which isn't answered here, please post it to the <a href="http://forum.lwjgl.org" target="_blank">forum</a>.</p>
<ul>
	<li><a href="#faq1">java.lang.UnsatisfiedLinkError: no lwjgl in java.library.path</a></li>
	<li><a href="#faq2">Applets and LWJGL</a></li>
	<li><a href="#faq3">OpenGL ES and LWJGL</a></li>
	<li><a href="#faq4">ByteBuffer VS. Arrays</a></li>
	<li><a href="#faq5">Lack of documentation</a></li>
</ul>
<p>
	<a name="faq1">
	<b>Q:</b> When running the examples or my own program I get a 'Exception in thread "main" java.lang.UnsatisfiedLinkError: no lwjgl in java.library.path.<br/>
	<b>A:</b> The VM cannot locate the lwjgl runtime library. Specify the path to it using -Djava.library.path=&lt;path/to/library&gt;<br/><br/>

	<a name="faq2">
	<b>Q:</b> Is it possible to use LWJGL from an Applet?<br/>
	<b>A:</b> Absolutely, please check <a href="http://lwjgl.org/wiki/doku.php/lwjgl/tutorials/applet">here</a> for more info.<br/><br/>

	<a name="faq3">
	<b>Q:</b> Will LWJGL support OpenGL ES<br/>
	<b>A:</b> OpenGL ES is basically a subset of OpenGL, and we will make the best efforts to get LWJGL running on a device. However we have yet to get our hands on one :(.<br/><br/>

	<a name="faq4">
	<b>Q:</b> Whats up with all those ByteBuffers? Why not just use arrays?<br/>
	<b>A:</b> Basically because it's the fastest way to transport data to the OpenGL layer. For more indepth discussion, <a href="http://www.lwjgl.org/forum/viewtopic.php?t=295" target="_blank">click here</a>.<br/><br/>

	<a name="faq5">
	<b>Q:</b> I have been looking all around the site, but I can't find any documentation, apart from the javadoc?<br/>
	<b>A:</b> Yes, this is a known "issue". We're only a handfull of developers doing this in our sparetime. We therefor tend to prioritize what we need, or want to work on. Documentation, alas, tend to be at the bottom of the chain. We are aware of it though...<br/><br/>
</p>

<? require('_include/footer.php'); ?>
