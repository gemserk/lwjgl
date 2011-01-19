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

<h1>Multiple Sources: Lesson 3</h1>
<p>
    <i>
		Author: <a href="mailto:lightonthewater@hotmail.com">Jesse Maurais</a> | From: <a href="http://www.devmaster.net/articles.php?catID=6" target="_blank">devmaster.net</a><br/>
    	Modified for LWJGL by: <a href="mailto:brian@matzon.dk">Brian Matzon</a>
	</i>
</p>

<p>
	Hello. It's been a while since my last tutorial. But better late than never
	I guess. Since I'm sure your all impatient to read the latest tutorial, I'll
	just jump right into it. What we hope to accomplish with this one is to be
	able to play more that one audio sample at a time. Very intense games have
	all kinds of stuff going on usually involving different sound clips. It
	won't be hard to implement any of this though. Doing multiple sounds is
	similar to doing just one.
</p>

<pre class="code" style="clear: right;">
<span class="codeKeyword">import</span> java.io.IOException;
<span class="codeKeyword">import</span> java.nio.FloatBuffer;
<span class="codeKeyword">import</span> java.nio.IntBuffer;
<span class="codeKeyword">import</span> java.util.Random;

<span class="codeKeyword">import</span> org.lwjgl.BufferUtils;
<span class="codeKeyword">import</span> org.lwjgl.LWJGLException;
<span class="codeKeyword">import</span> org.lwjgl.openal.AL;
<span class="codeKeyword">import</span> org.lwjgl.openal.AL10;
<span class="codeKeyword">import</span> org.lwjgl.util.WaveData;

<span class="codeKeyword">public class</span> Lesson3 {
  <span class="codeComment">/** Maximum data buffers we will need. */</span>
  <span class="codeKeyword">public static final int</span> NUM_BUFFERS = 3;

  <span class="codeComment">/** Maximum emissions we will need. */</span>
  <span class="codeKeyword">public static final int</span> NUM_SOURCES = 3;

  <span class="codeComment">/** Index of battle sound */</span>
  <span class="codeKeyword">public static final int</span> BATTLE = 0;

  <span class="codeComment">/** Index of gun 1 sound */</span>
  <span class="codeKeyword">public static final int</span> GUN1 = 1;

  <span class="codeComment">/** Index of gun 2 sound */</span>
  <span class="codeKeyword">public static final int</span> GUN2 = 2;

<span class="codeComment">  /** Buffers hold sound data. */</span>
  IntBuffer buffer = BufferUtils.createIntBuffer(NUM_BUFFERS);

<span class="codeComment">  /** Sources are points emitting sound. */</span>
  IntBuffer source = BufferUtils.createIntBuffer(NUM_BUFFERS);

<span class="codeComment">  /** Position of the source sound. */</span>
  FloatBuffer sourcePos = BufferUtils.createFloatBuffer(3*NUM_BUFFERS);

<span class="codeComment">  /** Velocity of the source sound. */</span>
  FloatBuffer sourceVel = BufferUtils.createFloatBuffer(3*NUM_BUFFERS);

<span class="codeComment">  /** Position of the listener. */</span>
  FloatBuffer listenerPos = BufferUtils.createFloatBuffer(3).put(<span class="codeKeyword">new</span> float[] { 0.0f, 0.0f, 0.0f });

<span class="codeComment">  /** Velocity of the listener. */</span>
  FloatBuffer listenerVel = BufferUtils.createFloatBuffer(3).put(<span class="codeKeyword">new</span> float[] { 0.0f, 0.0f, 0.0f });

<span class="codeComment">  /** Orientation of the listener. (first 3 elements are "at", second 3 are "up") */</span>
  FloatBuffer listenerOri =
      BufferUtils.createFloatBuffer(6).put(<span class="codeKeyword">new</span> float[] { 0.0f, 0.0f, -1.0f,  0.0f, 1.0f, 0.0f });
</pre>

<p>
	I guess this little piece of source code will be familiar to a lot of you
	who've read the first two tutorials. The only difference is that we now have
	3 different sound effects that we are going to load into the OpenAL sound
	system.
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

    <span class="codeComment">// Load wav data into a buffer.</span>
    AL10.alGenBuffers(buffer);

    <span class="codeKeyword">if</span>(AL10.alGetError() != AL10.AL_NO_ERROR)
      <span class="codeKeyword">return</span> AL10.AL_FALSE;

    WaveData waveFile = WaveData.create("Battle.wav");
    AL10.alBufferData(buffer.get(BATTLE), waveFile.format, waveFile.data, waveFile.samplerate);
    waveFile.dispose();

    waveFile = WaveData.create("Gun1.wav");
    AL10.alBufferData(buffer.get(GUN1), waveFile.format, waveFile.data, waveFile.samplerate);
    waveFile.dispose();

    waveFile = WaveData.create("Gun2.wav");
    AL10.alBufferData(buffer.get(GUN2), waveFile.format, waveFile.data, waveFile.samplerate);
    waveFile.dispose();

    <span class="codeComment">// Bind buffers into audio sources.</span>
    AL10.alGenSources(source);

    <span class="codeKeyword">if</span> (AL10.alGetError() != AL10.AL_NO_ERROR)
      <span class="codeKeyword">return</span> AL10.AL_FALSE;

    AL10.alSourcei(source.get(BATTLE), AL10.AL_BUFFER,   buffer.get(BATTLE));
    AL10.alSourcef(source.get(BATTLE), AL10.AL_PITCH,    1.0f          );
    AL10.alSourcef(source.get(BATTLE), AL10.AL_GAIN,     1.0f          );
    AL10.alSource (source.get(BATTLE), AL10.AL_POSITION, (FloatBuffer) sourcePos.position(BATTLE*3));
    AL10.alSource (source.get(BATTLE), AL10.AL_VELOCITY, (FloatBuffer) sourceVel.position(BATTLE*3));
    AL10.alSourcei(source.get(BATTLE), AL10.AL_LOOPING,  AL10.AL_TRUE  );

    AL10.alSourcei(source.get(GUN1), AL10.AL_BUFFER,   buffer.get(GUN1));
    AL10.alSourcef(source.get(GUN1), AL10.AL_PITCH,    1.0f          );
    AL10.alSourcef(source.get(GUN1), AL10.AL_GAIN,     1.0f          );
    AL10.alSource (source.get(GUN1), AL10.AL_POSITION, (FloatBuffer) sourcePos.position(GUN1*3));
    AL10.alSource (source.get(GUN1), AL10.AL_VELOCITY, (FloatBuffer) sourceVel.position(GUN1*3));
    AL10.alSourcei(source.get(GUN1), AL10.AL_LOOPING,  AL10.AL_FALSE );

    AL10.alSourcei(source.get(GUN2), AL10.AL_BUFFER,   buffer.get(GUN2));
    AL10.alSourcef(source.get(GUN2), AL10.AL_PITCH,    1.0f          );
    AL10.alSourcef(source.get(GUN2), AL10.AL_GAIN,     1.0f          );
    AL10.alSource (source.get(GUN2), AL10.AL_POSITION, (FloatBuffer) sourcePos.position(GUN2*3));
    AL10.alSource (source.get(GUN2), AL10.AL_VELOCITY, (FloatBuffer) sourceVel.position(GUN2*3));
    AL10.alSourcei(source.get(GUN2), AL10.AL_LOOPING,  AL10.AL_FALSE );

    <span class="codeComment">// Do another error check and return.</span>
    <span class="codeKeyword">if</span> (AL10.alGetError() == AL10.AL_NO_ERROR)
      <span class="codeKeyword">return</span> AL10.AL_TRUE;

    <span class="codeKeyword">return</span> AL10.AL_FALSE;
</pre>

<p>
	This code looks quite a bit different at first, but it isn't really.
	Basically we load the file data into our 3 buffers, then lock the 3 buffers
	to our 3 sources relatively. The only other difference is that the
	"Battle.wav" (Source index 0) is looping while the rest are not.<br/><br/>
	<i><b>NOTE:</b> Notice how the buffers position is changed. Since we know a
	vector in the buffer consists of 3 floats, we use this knowledge to index
	into the buffer and position us precisely where the next vector begins. We
	could have used multiple buffers, but this is quicker, and takes up less code
    - at a slight cost of added complexity.</i>
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
	I don't think we changed anything in this code.
</p>

<pre class="code">
  <span class="codeKeyword">public static void</span> main(String[] args) {
    <span class="codeKeyword">new</span> Lesson3().execute();
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

  <span class="codeComment">  // Load the wav data.</span>
    <span class="codeKeyword">if</span>(loadALData() == AL10.AL_FALSE) {
      System.out.println("Error loading data.");
      <span class="codeKeyword">return</span>;
    }

    setListenerValues();

    <span class="codeComment">// Begin the battle sample to play.</span>
    AL10.alSourcePlay(source.get(BATTLE));

    <span class="codeComment">// Go through all the sources and check that they are playing.
    // Skip the first source because it is looping anyway (will always be playing).</span>
    <span class="codeKeyword">int</span> play;
    Random random = <span class="codeKeyword">new</span> Random();


    <span class="codeKeyword">while</span> (!kbhit()) {
      <span class="codeKeyword">for</span> (<span class="codeKeyword">int</span> i=1; i<NUM_SOURCES; i++) {
        play = AL10.alGetSourcei(source.get(i), AL10.AL_SOURCE_STATE);

        <span class="codeKeyword">if</span> (play != AL10.AL_PLAYING) {
        <span class="codeKeyword">double</span> theta = (<span class="codeKeyword">double</span>) (random.nextInt() % 360) * 3.14 / 180.0;

        sourcePos.put(i*3+0, -(<span class="codeKeyword">float</span>) (Math.cos(theta)));
        sourcePos.put(i*3+1, -(<span class="codeKeyword">float</span>) (random.nextInt()%2));
        sourcePos.put(i*3+2, -(<span class="codeKeyword">float</span>) (Math.sin(theta)));

        AL10.alSource(source.get(i), AL10.AL_POSITION, (FloatBuffer) sourcePos.position(i*3));
        AL10.alSourcePlay(source.get(i));
      }
    }
    killALData();
  }
}
</pre>

<p>
	Here is the interesting part of this tutorial. We go through each of the
	sources to make sure it's playing. If it is not then we set it to play but
	we select a new point in 3D space for it to play (just for kicks).
	And bang! We are done. As most of you have probably seen, you don't have to
	do anything special to play more than one source at a time. OpenAL will
	handle all the mixing features to get the sounds right for their respective
	distances and velocities. And when it comes right down to it, isn't that the
	beauty of OpenAL? You know that was a lot easier than I thought. I don't
	know why I waited so long to write it. Anyway, if anyone reading wants to
	see something specific in future tutorials (not necessarily pertaining to
	OpenAL, I have quite an extensive knowledge base) drop me a line at
	<a href="mailto:lightonthewater@hotmail.com">lightonthewater@hotmail.com</a>
	I plan to do tutorials on sharing buffers and the Doppler effect in some
	later tutorial unless there is request for something else.<br/><br/>
	Have fun with the code!
</p>

<p>
	Download source code and resources for this lesson <a href="_files/tutorials/openal_devmaster_lesson3.zip">here</a>.
</p>

<? require('_include/footer.php'); ?>
