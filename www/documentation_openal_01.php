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

<h1>Single Static Source: Lesson 1</h1>
<p>
    <i>
		Author: <a href="mailto:lightonthewater@hotmail.com">Jesse Maurais</a> | From: <a href="http://www.devmaster.net/articles.php?catID=6" target="_blank">devmaster.net</a><br/>
    	Modified for LWJGL by: <a href="mailto:brian@matzon.dk">Brian Matzon</a>
	</i>
</p>

<p>
	Welcome to the exciting world of OpenAL! OpenAL is still in a stage of
	growth, and even though there is an ever larger following to the API it
	still hasn't reached it's full potential. One of the big reasons for this is
	that there is still not yet hardware acceleration built in for specific
	cards. However, Creative Labs is a major contributor to the OpenAL project
	and also happens to be one of the largest soundcard manufacturers. So there
	is a promise of hardware accelerated features in the near future. OpenAL's
	only other major contributor, Loki, has gone the way of the dinosaur. So the
	future of OpenAL on Linux platforms is uncertain. You can still obtain the
	Linux binaries on some more obscure websites.
</p>

<p>
	OpenAL has also not been seen in many major commercial products, which may
	have also hurt it's growth. As far as I know the only pc game to use OpenAL
	has been Metal Gear 2 (although recently I've discovered that Unreal 2 does
	as well). The popular modeling program, Blender3D, was also known to use
	OpenAL for all it's audio playback. Aside from these however the only other
	OpenAL uses have been in the sdk examples and a few obscure tutorials on the
	internet.
</p>

<p>
	But lets face it, OpenAL has a lot of potential. There are many other audio
	libraries that claim to work with the hardware on a lower level (and this
	may be true), but the designers of OpenAL did several things in it's design
	which make it a superior API. First of all they emulated the OpenGL API
	which is one of the best ever designed. The API style is flexible, so
	different coding methods and hardware implementations will take advantage of
	this. People who have had a lot of experience with OpenGL will be able to
	pick up OpenAL quite fast. OpenAL also has the advantage of creating 3D
	surround sound which a lot of other API's cannot boast. On top of all of
	that it also has the ability to extend itself into EAX and AC3 flawlessly.
	To my knowledge no other audio library has that capability.
</p>

<p>
	If you still haven't found a reason here to use OpenAL then here's another.
	It's just cool. It's a nice looking API and will integrate well into your
	code. You will be able to do many cool sound effects with it. But before we
	do that we have to learn the basics.
</p>

<p>
	So let's get coding!
</p>

<pre class="code" style="clear: right;">
<span class="codeKeyword">import</span> java.io.IOException;
<span class="codeKeyword">import</span> java.nio.FloatBuffer;
<span class="codeKeyword">import</span> java.nio.IntBuffer;

<span class="codeKeyword">import</span> org.lwjgl.BufferUtils;
<span class="codeKeyword">import</span> org.lwjgl.LWJGLException;
<span class="codeKeyword">import</span> org.lwjgl.openal.AL;
<span class="codeKeyword">import</span> org.lwjgl.openal.AL10;
<span class="codeKeyword">import</span> org.lwjgl.util.WaveData;

<span class="codeKeyword">public class</span> Lesson1 {
<span class="codeComment">  /** Buffers hold sound data. */</span>
  IntBuffer buffer = BufferUtils.createIntBuffer(1);

<span class="codeComment">  /** Sources are points emitting sound. */</span>
  IntBuffer source = BufferUtils.createIntBuffer(1);
</pre>

<p>
	Those familiar with OpenGL know that it uses "texture objects" (or "texture
	names") to handle textures used by a program. OpenAL does a similar thing
	with audio samples. There are essentially 3 kinds of objects in OpenAL. A
	buffer which stores all the information about how a sound should be played
	and the sound data itself, and a source which is a point in space that emits
	a sound. It's important to understand that a source is not itself an audio
	sample. A source only plays back sound data from a buffer bound to it. The
	source is also given special properties like position and velocity.
</p>

<p>
	The third object which I have not mentioned yet is the listener. There is
	only one listener which represents where 'you' are, the user. The listener
	properties along with the source properties determine how the audio sample
	will be heard. For example their relative positions will determine the
	intensity of the sound.
</p>

<pre class="code">
<span class="codeComment">  /** Position of the source sound. */</span>
  FloatBuffer sourcePos = BufferUtils.createFloatBuffer(3).put(<span class="codeKeyword">new</span> float[] { 0.0f, 0.0f, 0.0f });

<span class="codeComment">  /** Velocity of the source sound. */</span>
  FloatBuffer sourceVel = BufferUtils.createFloatBuffer(3).put(<span class="codeKeyword">new</span> float[] { 0.0f, 0.0f, 0.0f });

<span class="codeComment">  /** Position of the listener. */</span>
  FloatBuffer listenerPos = BufferUtils.createFloatBuffer(3).put(<span class="codeKeyword">new</span> float[] { 0.0f, 0.0f, 0.0f });

<span class="codeComment">  /** Velocity of the listener. */</span>
  FloatBuffer listenerVel = BufferUtils.createFloatBuffer(3).put(<span class="codeKeyword">new</span> float[] { 0.0f, 0.0f, 0.0f });

<span class="codeComment">  /** Orientation of the listener. (first 3 elements are "at", second 3 are "up") */</span>
  FloatBuffer listenerOri =
      BufferUtils.createFloatBuffer(6).put(<span class="codeKeyword">new</span> float[] { 0.0f, 0.0f, -1.0f,  0.0f, 1.0f, 0.0f });
</pre>

<p>
	In the above code we specify the position and velocity of the source and
	listener objects. These NIO Buffers are vector based Cartesian coordinates.<br/><br/>
	<i><b>Note:</b> LWJGL uses the position, limit and capacity properties of
	NIO buffers to determine where to index the data and how many elements to
	get/set. It is therefore crucial that these limits are set correctly. In the
	above case we would have to flip each of the buffers so their position and
	limit is set correctly. A newly created buffer will have its position set to
	0 and its limit to its capacity.</i>
</p>

<pre class="code">
<span class="codeComment">  /**
   * boolean LoadALData()
   *
   *  This function will load our sample data from the disk using the Alut
   *  utility and send the data into OpenAL as a buffer. A source is then
   *  also created to play that buffer.
   */</span>
  <span class="codeKeyword">int</span> loadALData() {
</pre>

<p>
	Here we will create a function that loads all of our sound data from a file.<br/><br/>
	<i><b>Note:</b> The original tutorial uses ALUT to load wave data. ALUT is
	not available in the LWJGL binding, due to license issues. You may use the
	<code>WaveData</code> class to load sound files instead.</i>
</p>

<pre class="code">
<span class="codeComment">    // Load wav data into a buffer.</span>
    AL10.alGenBuffers(buffer);

    <span class="codeKeyword">if</span>(AL10.alGetError() != AL10.AL_NO_ERROR)
      <span class="codeKeyword">return</span> AL10.AL_FALSE;

    WaveData waveFile = WaveData.create("FancyPants.wav");
    AL10.alBufferData(buffer.get(0), waveFile.format, waveFile.data, waveFile.samplerate);
    waveFile.dispose();
</pre>

<p>
	The function 'alGenBuffers' will create the buffer objects and store them in
	the variable we passed it. It's important to do an error check to make sure
	everything went smoothly. There may be a case in which OpenAL could not
	generate a buffer object due to a lack of memory. In this case it would set
	the error bit.
</p>

<p>
	The WaveData class is very helpful here. It opens up the file for us and
	gives us all the information we need to create the buffer. And after we have
	attached all this data to the buffer it will help use dispose of the data.
	It all works in a clean and efficient manner.
</p>

<pre class="code">
    <span class="codeComment">// Bind the buffer with the source.</span>
    AL10.alGenSources(source);

    <span class="codeKeyword">if</span> (AL10.alGetError() != AL10.AL_NO_ERROR)
      <span class="codeKeyword">return</span> AL10.AL_FALSE;

    AL10.alSourcei(source.get(0), AL10.AL_BUFFER,   buffer.get(0) );
    AL10.alSourcef(source.get(0), AL10.AL_PITCH,    1.0f          );
    AL10.alSourcef(source.get(0), AL10.AL_GAIN,     1.0f          );
    AL10.alSource (source.get(0), AL10.AL_POSITION, sourcePos     );
    AL10.alSource (source.get(0), AL10.AL_VELOCITY, sourceVel     );
</pre>

<p>
	We generate a source object in the same manner we generated the buffer
	object. Then we define the source properties that it will use when it's in
	playback. The most important of these properties is the buffer it should
	use. This tells the source which audio sample to playback. In this case we
	only have one so we bind it. We also tell the source it's position and
	velocity which we defined earlier.
</p>

<p>
	One more thing on 'alGenBuffers' and 'alGenSources'. In some example code I
	have seen these functions will return an integer value for the number of
	buffers/sources created. I suppose this was meant as an error checking
	feature that was left out in a later version. If you see this done in other
	code don't use it yourself. If you want to do this check, use 'alGetError'
	instead (like we have done above).
</p>

<pre class="code">
    <span class="codeComment">// Do another error check and return.</span>
    <span class="codeKeyword">if</span> (AL10.alGetError() == AL10.AL_NO_ERROR)
      <span class="codeKeyword">return</span> AL10.AL_TRUE;

    <span class="codeKeyword">return</span> AL10.AL_FALSE;
</pre>

<p>
	To end the function we just do one more check to make sure all is well, then
	we return success.
</p>

<pre class="code">
<span class="codeComment">  /**
   * void setListenerValues()
   *
   *  We already defined certain values for the Listener, but we need
   *  to tell OpenAL to use that data. This function does just that.
   */</span>
  <span class="codeKeyword">void</span> setListenerValues() {
    AL10.alListener(AL10.AL_POSITION,    listenerPos);
    AL10.alListener(AL10.AL_VELOCITY,    listenerVel);
    AL10.alListener(AL10.AL_ORIENTATION, listenerOri);
  }
</pre>

<p>
	We created this function to update the listener properties.
</p>

<pre class="code">
<span class="codeComment">  /**
   * void killALData()
   *
   *  We have allocated memory for our buffers and sources which needs
   *  to be returned to the system. This function frees that memory.
   */</span>
  <span class="codeKeyword">void</span> killALData() {
    AL10.alDeleteSources(source);
    AL10.alDeleteBuffers(buffer);
  }
</pre>

<p>
	This will be our shutdown procedure. It is necessary to call this to release
	all the memory and audio devices that our program may be using.
</p>

<pre class="code">
  <span class="codeKeyword">public static void</span> main(String[] args) {
    <span class="codeKeyword">new</span> Lesson1().execute();
  }
</pre>

<p>
	This is our main entry point. We just create our <code>Lesson1</code>
	instance and call the execute method.
</p>

<pre class="code">
  <span class="codeKeyword">public void</span> execute() {
    <span class="codeComment">// Initialize OpenAL and clear the error bit.</span>
    <span class="codeKeyword">try</span>{
    AL.create();
    } <span class="codeKeyword">catch</span> (LWJGLException le) {
    le.printStackTrace();
      <span class="codeKeyword">return</span>;
    }
    AL10.alGetError();
</pre>

<p>
	The function 'AL.create()' will setup everything that OpenAL needs to do for
	us. Basically 'AL.create()' creates a single OpenAL context through Alc and
	sets it to current. On the Windows platform it initializes DirectSound. We
	also do an initial call to the error function to clear it. Every time we
	call 'alGetError' it will reset itself to 'AL_NO_ERROR'.
</p>

<pre class="code">
<span class="codeComment">    // Load the wav data.</span>
    <span class="codeKeyword">if</span>(loadALData() == AL10.AL_FALSE) {
      System.out.println("Error loading data.");
      <span class="codeKeyword">return</span>;
    }

    setListenerValues();
</pre>

<p>
	We will check to see if the wav files loaded correctly. If not we must exit
	the program. Then we update the listener values.
</p>

<pre class="code">
    <span class="codeComment">// Loop.</span>
    <span class="codeKeyword">char</span> c = ' ';
    <span class="codeKeyword">while</span>(c != 'q') {
      <span class="codeKeyword">try</span> {
      c = (<span class="codeKeyword">char</span>) System.in.read();
      } <span class="codeKeyword">catch</span> (IOException ioe) {
      c = 'q';
      }

      <span class="codeKeyword">switch</span>(c) {
        // Pressing 'p' will begin playing the sample.
        <span class="codeKeyword">case</span> 'p': AL10.alSourcePlay(source.get(0)); <span class="codeKeyword">break</span>;

        // Pressing 's' will stop the sample from playing.
        <span class="codeKeyword">case</span>'s': AL10.alSourceStop(source.get(0)); <span class="codeKeyword">break</span>;

        // Pressing 'h' will pause the sample.
        <span class="codeKeyword">case</span> 'h': AL10.alSourcePause(source.get(0)); <span class="codeKeyword">break</span>;
      };
    }
    killALData();
  }
}
</pre>

<p>
	This is the interesting part of the tutorial. It's a very basic loop that
	lets us control the playback of the audio sample. Pressing 'p' will replay
	the sample, pressing 's' will stop the sample, and pressing 'h' will pause
	the sample. Pressing 'q' will exit the program. When done, we kill all data
	loaded into buffers and delete any source objects created.
</p>

<p>
	Well there it is. Your first delve into OpenAL. I hope it was made simple
	enough for you. It may have been a little too simple for the 1337 h4X0r, but
	we all got to start somewhere. Things will get more advanced as we go along.
</p>

<p>
	Download source code and resources for this lesson <a href="_files/tutorials/openal_devmaster_lesson1.zip">here</a>.
</p>

<? require('_include/footer.php'); ?>
