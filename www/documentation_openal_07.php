<? require('_include/header.php'); ?>

<div style="margin: 0px 0px 10px 10px; width: 240px; float: right; border: 1px solid #000000;">
	<table border="0" cellpadding="3" cellspacing="0">
    	<tr>
      		<td width="100%" style="text-align: center; background-color: #cccccc; font-weight: bold; border-bottom: 1px solid #000000;" colspan="2">Other Articles in the Series</td>
    	</tr>
    	<tr>
    	    <td valign="top">&middot;</td>
    	    <td width="100%" style="text-align: left;"><a href="documentation_openal_01.php">Lesson 1: Single Static Source</a></td>
        </tr>
    	<tr>
    	    <td valign="top">&middot;</td>
    	    <td width="100%" style="text-align: left;"><a href="documentation_openal_02.php">Lesson 2: Looping and Fade-away</a></td>
        </tr>
    	<tr>
    	    <td valign="top">&middot;</td>
    	    <td width="100%" style="text-align: left;"><a href="documentation_openal_03.php">Lesson 3: Multiple Sources</a></td>
        </tr>
    	<tr>
    	    <td valign="top">&middot;</td>
    	    <td width="100%" style="text-align: left;"><a href="documentation_openal_04.php">Lesson 4: A Closer Look at ALC</a></td>
        </tr>
    	<tr>
        	<td valign="top">&middot;</td>
    	    <td width="100%" style="text-align: left;"><a href="documentation_openal_05.php">Lesson 5: Sources Sharing Buffers</a></td>
        </tr>
    	<tr>
    	    <td valign="top">&middot;</td>
    	    <td width="100%" style="text-align: left;"><a href="documentation_openal_06.php">Lesson 6: Advanced Loading and Error Handles</a></td>
        </tr>
    	<tr>
    	    <td valign="top">&middot;</td>
    	    <td width="100%" style="text-align: left;"><a href="documentation_openal_07.php">Lesson 7: The Doppler Effect</a></td>
        </tr>
    </table>
</div>

<h1>OpenAL Lesson 7: The Doppler Effect</h1>
<p>
    <i>
		Author: <a href="mailto:lightonthewater@hotmail.com">Jesse Maurais</a> | From: <a href="http://www.devmaster.net/articles.php?catID=6" target="_blank">devmaster.net</a><br/>
    	Modified for LWJGL by: <a href="mailto:brian@matzon.dk">Brian Matzon</a>
	</i>
</p>

<p>
	I know this will be boring review for anyone with a course in high school
	physics, but lets humour ourselves. The Doppler effect can be a very tricky
	concept for some people, but it is a logical process, and kind of interesting
	when you get right down to it. To begin understanding the Doppler effect we
	first must start to understand what a "sound" really is. Basically a sound is
	your minds interpretation of a compression wave that is traveling through the
	air. Whenever the air becomes disturbed it starts a wave which compresses the
	air particles around it. This wave travels outward from it's point of origin.
	Consider the following diagram.
</p>

<p>
	<img border="0" src="_gfx/tutorials/openal/devmaster/sound_waves.jpg" align="left" width="150" height="132" alt="" border="0"/>In this diagram
	(on the left) the big red "S" stands for the sources position, and the big
	red "L" stands for (you guessed it), the Listener's position. Both source and
	Listener are not moving. The source is emitting compression waves outward, which
	are represented in this diagram by the blue circles. The Listener is
	experiencing the sound exactly as it is being made in this diagram. The Doppler
	effect is not actually present in this example since there is no motion; the
	Doppler effect only describes the warping of sound due to motion.</p>
	<p>What you should try to do is picture this diagram animated. When the source
	emits a wave (the circles) it will look as though it is growing away from it's
	point of origin, which is the sources position. A good example of a similar
	effect is the ripples in a pond. When you throw a pebble into a calm body of
	water it will emit waves which constantly move away from the point of impact.
	Believe it or not this occurs from the exact same physical properties. But what
	does this have to do with the Doppler effect? Check out the next diagram (on the
	right).
</p>

<p style="clear: right;">
	<img border="0" src="_gfx/tutorials/openal/devmaster/doppler_effect.jpg" align="right" width="150" height="132" alt="" border="0"/>Wow, what's going on here? The source is now in motion, indicated by the
	little red arrow. In fact the source is now moving towards the Listener with an
	implied velocity. Notice particularly that the waves (circles) are being
	displaced inside each other. The displacement follows the approximate path of
	the source which emits them. This is the key to the Doppler effect. Essentially
	what has happened is that the source has emitted a wave at different points in
	it's path of travel. The waves it emits do not move with it, but continue on
	their own path of travel from the point they were emitted.
</p>

<p>
	So how does this effect the perceived sound by the Listener? Well, notice too
	in the last diagram that the waves (circles) that are between the source and the
	Listener are kind of compressed together. This will cause the sound waves to run
	together, which in turn causes the perceived sound seem like it's faster. What
	we are talking about here is frequency. The distances between the waves effects
	the frequency of the sound. When the source that emits the sound is in motion,
	it causes a change in frequency. You may notice too that distance between the
	waves varies at different points in space. For example, on the opposite side of
	the moving source (anywhere along the previous path of travel) the distances are
	actually wider, so the frequency will be lower (the distance and frequency have
	an inverse relationship). What this implies is that the frequency perceived by
	the Listener is relative to where the Listener is standing.
</p>

<p>
	The motion of the Listener can also affect the frequency. This one is a
	little harder to picture though. If the source is still, and the Listener is
	moving toward the source, then the perceived frequency by the Listener will be
	warped in the same exact manner that we described for the moving source.
</p>

<p>
	If you still have trouble picturing this, consider the following two diagrams:
</p>

<p align="center">
	<img border="0" src="_gfx/tutorials/openal/devmaster/sin_wave.jpg" width="255" height="135" alt="" border="0"/>  
	<img border="0" src="_gfx/tutorials/openal/devmaster/compress_sin_wave.jpg" width="255" height="135" alt="" border="0"/>
</p>

<p>
	These two diagrams will represent the sound in the form of a sine wave. Look
	at the first one. Think of the peaks as the instance of the wave. The very top
	point of the wave will be the same as the instance of the blue circle in the
	previous set of diagrams. The valleys will be like the spaces in between the
	blue circles. The second diagram represents a compressed wave. When you compare
	the two you will notice an obvious difference. The second diagram simply has
	more wave occurrences in the same amount of space. Other ways of saying this are
	that they occur more often, with a greater regularity, or with a greater
	frequency.
</p>

<p>
	For anyone who is interested in some added information: The velocity of the
	waves is the speed of sound. If the velocity of the source is greater than that
	of the wave, then the source is breaking the sound barrier.
</p>

<h1>The Physics of OpenAL</h1>

<p>
	Ok, either you have understood my ramblings on the Doppler effect from above,
	or you have skipped it because you already have full knowledge of the Doppler
	effect and just want to know how it effects the OpenAL rendering pipeline. I
	think the best start to his section will be to quote the OpenAL spec directly:
</p>

<blockquote>
  <p><i>"The Doppler Effect depends on the velocities of Source and Listener
  relative to the medium, and the propagation speed of sound in that medium." -
  chapter 3, subsection 7"</i></p>
</blockquote>

<p>
	We can take this to mean that there are 3 factors which are going to affect
	the final frequency of the sound heard by the Listener. These factors are the
	velocity of the source, the velocity of the Listener, and a predefined speed of
	sound.
</p>

<p>
	When we refer to a "medium", what we mean is the kind of material that both
	the source and Listener are "in". For example, sounds that are heard from
	underwater are much different than sounds that are heard in the open air. Air
	and water are examples of different mediums. The reason that sound is so
	different between these mediums has to do with the particle density. As we said
	before, sound is nothing but the motion of particles in the air. In a medium
	with a much greater particle density the sound will be much different because
	the particles are in closer contact. When they are in closer contact it allows
	for the wave to travel much better. As an example of the opposite, think of
	outer space. In outer space there is an extremely low particle density. In fact
	there is only a few very light particles (mostly hydrogen) scattered about. This
	is why no sound can be heard from space.
</p>

<p>
	Ok, lets get back on topic. OpenAL calculates the Doppler effect internally
	for us, so we need only define a few parameters that will effect the
	calculation. We would do this in case we don't want a realistic rendering.
	Rather if want to exaggerate or deemphasize the effect. The calculation goes
	like this.
</p>

<pre class="code">
shift = DOPPLER_FACTOR * freq * (DOPPLER_VELOCITY - l.velocity) / (DOPPLER_VELOCITY + s.velocity)
</pre>

<p>
	Constants are written in all caps to differentiate. The "l" and "s" variables
	are the Listener and source respectively. "freq" is the initial unaltered
	frequency of the emitting wave, and "shift" is the altered frequency of the
	wave. The term "shift" is the proper way to address the altered frequency and
	will be used from now on. This final shifted frequency will be sampled by OpenAL
	for all audio streaming that is affected.
</p>

<p>
	We already know that we can define the velocity of both source and Listener
	by using the 'AL_VELOCITY' field to 'alListenerfv' and 'alSourcefv'. The 'freq'
	parameter comes straight from the buffer properties when it was loaded from
	file. To set the constant values the following functions are provided for us.
</p>

<pre class="code">
<span class="codeKeyword">public static native void</span> alDopplerFactor(<span class="codeKeyword">float</span> value);
<span class="codeKeyword">public static native void</span> alDopplerVelocity(<span class="codeKeyword">float</span> value);
</pre>

<p>
	For 'alDopplerFactor' any non-negative value will suffice. Passing a negative
	value will raise an error of 'AL_INVALID_VALUE', and the whole command will be
	ignored. Passing zero is a perfectly valid argument. Doing this will disable the
	Doppler effect and may in fact help overall performance (but won't be as
	realistic). The effect of the Doppler factor will directly change the magnitude
	of the equation. A value of 1.0 will not change the effect at all. Passing
	anything between 0.0 and 1.0 will minimize the Doppler effect, and anything
	greater than 1.0 will maximize the effect.
</p>
<p>
	For 'alDopplerVelocity' any non-negative non-zero value will suffice. Passing
	either a negative or a zero will raise an error of 'AL_INVALID_VALUE', and the
	whole command will be ignored. The Doppler velocity is essentially the speed of
	sound. Setting this will be like setting how fast sound can move through the
	medium. OpenAL has no sense of medium, but setting the velocity will give the
	effect of a medium. OpenAL also has no sense of units (kilometer, miles,
	parsecs), so keep that in mind when you set this value so it is consistent with
	all other notions of units that you have defined.
</p>

<? require('_include/footer.php'); ?>
