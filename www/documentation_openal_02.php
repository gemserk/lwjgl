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

<h1>Looping and Fade-away: Lesson 2</h1>
<p>
    <i>
		Author: <a href="mailto:lightonthewater@hotmail.com">Jesse Maurais</a> | From: <a href="http://www.devmaster.net/articles.php?catID=6" target="_blank">devmaster.net</a><br/>
    	Modified for LWJGL by: <a href="mailto:brian@matzon.dk">Brian Matzon</a>
	</i>
</p>

<p>
	Hope you found the last tutorial of some use. I know I did. This will be a
	real quick and easy tutorial. It won't get too much more complicated at this
	point.
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

<span class="codeKeyword">public class</span> Lesson2 {
<span class="codeComment">  /** Buffers hold sound data. */</span>
  IntBuffer buffer = BufferUtils.createIntBuffer(1);

<span class="codeComment">  /** Sources are points emitting sound. */</span>
  IntBuffer source = BufferUtils.createIntBuffer(1);

<span class="codeComment">  /** Position of the source sound. */</span>
  FloatBuffer sourcePos = BufferUtils.createFloatBuffer(3).put(<span class="codeKeyword">new</span> float[] { 0.0f, 0.0f, 0.0f });

<span class="codeComment">  /** Velocity of the source sound. */</span>
  FloatBuffer sourceVel = BufferUtils.createFloatBuffer(3).put(<span class="codeKeyword">new</span> float[] { 0.0f, 0.0f, 0.1f });

<span class="codeComment">  /** Position of the listener. */</span>
  FloatBuffer listenerPos = BufferUtils.createFloatBuffer(3).put(<span class="codeKeyword">new</span> float[] { 0.0f, 0.0f, 0.0f });

<span class="codeComment">  /** Velocity of the listener. */</span>
  FloatBuffer listenerVel = BufferUtils.createFloatBuffer(3).put(<span class="codeKeyword">new</span> float[] { 0.0f, 0.0f, 0.0f });

<span class="codeComment">  /** Orientation of the listener. (first 3 elements are "at", second 3 are "up") */</span>
  FloatBuffer listenerOri =
      BufferUtils.createFloatBuffer(6).put(<span class="codeKeyword">new</span> float[] { 0.0f, 0.0f, -1.0f,  0.0f, 1.0f, 0.0f });
</pre>

<p>
	There is only one change in the code since the last tutorial in this first
	section. It is that we altered the sources velocity. It's 'z' field is now
	0.1.
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

    <span class="codeComment">    // Load wav data into a buffer.</span>
    AL10.alGenBuffers(buffer);

    <span class="codeKeyword">if</span>(AL10.alGetError() != AL10.AL_NO_ERROR)
      <span class="codeKeyword">return</span> AL10.AL_FALSE;

    WaveData waveFile = WaveData.create("Footsteps.wav");
    AL10.alBufferData(buffer.get(0), waveFile.format, waveFile.data, waveFile.samplerate);
    waveFile.dispose();

    <span class="codeComment">// Bind the buffer with the source.</span>
    AL10.alGenSources(source);

    <span class="codeKeyword">if</span> (AL10.alGetError() != AL10.AL_NO_ERROR)
      <span class="codeKeyword">return</span> AL10.AL_FALSE;

    AL10.alSourcei(source.get(0), AL10.AL_BUFFER,   buffer.get(0) );
    AL10.alSourcef(source.get(0), AL10.AL_PITCH,    1.0f          );
    AL10.alSourcef(source.get(0), AL10.AL_GAIN,     1.0f          );
    AL10.alSource (source.get(0), AL10.AL_POSITION, sourcePos     );
    AL10.alSource (source.get(0), AL10.AL_VELOCITY, sourceVel     );
    AL10.alSourcei(source.get(0), AL10.AL_LOOPING,  AL10.AL_TRUE  );

    <span class="codeComment">// Do another error check and return.</span>
    <span class="codeKeyword">if</span> (AL10.alGetError() == AL10.AL_NO_ERROR)
      <span class="codeKeyword">return</span> AL10.AL_TRUE;

    <span class="codeKeyword">return</span> AL10.AL_FALSE;
</pre>

<p>
	Two changes in this section. First we are loading the file "Footsteps.wav".
	We are also explicitly setting the sources 'AL_LOOPING' value to 'AL_TRUE'.
	What this means is that when the source is prompted to play it will continue
	to play until stopped. It will play over again after the sound clip has ended.
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
	Nothing has changed here.
</p>

<pre class="code">
  <span class="codeKeyword">public static void</span> main(String[] args) {
    <span class="codeKeyword">new</span> Lesson2().execute();
  }

<span class="codeComment">  /**
   *  Check for keyboard hit
   */</span>
  <span class="codeKeyword">private boolean</span> kbhit() {
    <span class="codeKeyword">try</span> {
    	<span class="codeKeyword">return</span> (System.in.available() != 0);
    } <span class="codeKeyword">catch</span> (IOException ioe) {
    }
    <span class="codeKeyword">return false</span>;
  }

  <span class="codeKeyword">public void</span> execute() {
    <span class="codeComment">// Initialize OpenAL and clear the error bit.</span>
    <span class="codeKeyword">try</span>{
    	AL.create();
    } <span class="codeKeyword">catch</span> (LWJGLException le) {
    	le.printStackTrace();
      <span class="codeKeyword">return</span>;
    }
    AL10.alGetError();

  <span class="codeComment">    // Load the wav data.</span>
    <span class="codeKeyword">if</span>(loadALData() == AL10.AL_FALSE) {
      System.out.println("Error loading data.");
      <span class="codeKeyword">return</span>;
    }

    setListenerValues();

    <span class="codeComment">// Loop.</span>
    <span class="codeKeyword">long</span> time = Sys.getTime();
    <span class="codeKeyword">long</span> elapse = 0;

    <span class="codeKeyword">while</span> (!kbhit()) {
    	elapse += Sys.getTime() - time;
    	time += elapse;

    	<span class="codeKeyword">if</span> (elapse > 5000) {
    		elapse = 0;

    		sourcePos.put(0, sourcePos.get(0) + sourceVel.get(0));
    		sourcePos.put(1, sourcePos.get(1) + sourceVel.get(1));
    		sourcePos.put(2, sourcePos.get(2) + sourceVel.get(2));

    		AL10.alSource(source.get(0), AL10.AL_POSITION, sourcePos);
    	}
    }
    killALData();
  }
}
</pre>

<p>
	The only thing that has changed in this code is the loop. Instead of playing
	and stopping the audio sample it will slowly get quieter as the sources
	position grows more distant. We do this by slowly incrementing the position
	by it's velocity over time. The time is sampled by checking the system clock
	which gives us a tick count. It shouldn't be necessary to change this, but
	if the audio clip fades too fast you might want to change 5000 to some higher
	number. Pressing <code>return</code> key will end the loop.
</p>

<p>
	Download source code and resources for this lesson <a href="_files/tutorials/openal_devmaster_lesson2.zip">here</a>.
</p>

<? require('_include/footer.php'); ?>
