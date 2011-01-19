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

<h1>Sources Sharing Buffers: Lesson 5</h1>
<p>
    <i>
		Author: <a href="mailto:lightonthewater@hotmail.com">Jesse Maurais</a> | From: <a href="http://www.devmaster.net/articles.php?catID=6" target="_blank">devmaster.net</a><br/>
    	Modified for LWJGL by: <a href="mailto:brian@matzon.dk">Brian Matzon</a>
	</i>
</p>

<p>
	At this point in the OpenAL series I will show one method of having your
	buffers be shared among many sources. This is a very logical and natural
	step, and it is so easy that some of you may have already done this yourself.
	If you have you may just skip this tutorial in total and move on. But for
	those keeners who want to read all of the info I've got to give, you may
	find this interesting.<br/>
	Well, here we go. I've decided to only go over bits of the code that are
	significant, since most of the code has been repeated so far in the series.
	Check out the full source code in the download.
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

<span class="codeKeyword">public class</span> Lesson5 {

  <span class="codeComment">/** Index of thunder sound */</span>
  <span class="codeKeyword">public static final int</span> THUNDER = 0;

  <span class="codeComment">/** Index of waterdrop sound */</span>
  <span class="codeKeyword">public static final int</span> WATERDROP = 1;

  <span class="codeComment">/** Index of stream sound */</span>
  <span class="codeKeyword">public static final int</span> STREAM = 2;

  <span class="codeComment">/** Index of rain sound */</span>
  <span class="codeKeyword">public static final int</span> RAIN = 2;

  <span class="codeComment">/** Index of chimes sound */</span>
  <span class="codeKeyword">public static final int</span> CHIMES = 2;

  <span class="codeComment">/** Index of ocean sound */</span>
  <span class="codeKeyword">public static final int</span> OCEAN = 2;

  <span class="codeComment">/** Maximum data buffers we will need. */</span>
  <span class="codeKeyword">public static final int</span> NUM_BUFFERS = 6;

  <span class="codeComment">  /** Buffers hold sound data. */</span>
  IntBuffer buffer = BufferUtils.createIntBuffer(NUM_BUFFERS);

  <span class="codeComment">  /** Sources are points emitting sound. */</span>
  IntBuffer source = BufferUtils.createIntBuffer(128);
</pre>

<p>
	We will be using several wav files so we need quite a few buffers here. We
	will be using at most 128 sources (typically OpenAL will stop at 32-64
	sources, but you shouldn't rely on more than 16!). We can just keep adding
	sources to the scene until OpenAL runs out of them. This is also the first
	tutorial where we will deal with sources as being a resource that will run
	out. And yes, they will run out; they are finite.
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

    WaveData waveFile = WaveData.create("thunder.wav");
    AL10.alBufferData(buffer.get(THUNDER), waveFile.format, waveFile.data, waveFile.samplerate);
    waveFile.dispose();

    waveFile = WaveData.create("waterdrop.wav");
    AL10.alBufferData(buffer.get(WATERDROP), waveFile.format, waveFile.data, waveFile.samplerate);
    waveFile.dispose();

    waveFile = WaveData.create("stream.wav");
    AL10.alBufferData(buffer.get(STREAM), waveFile.format, waveFile.data, waveFile.samplerate);
    waveFile.dispose();

    waveFile = WaveData.create("rain.wav");
    AL10.alBufferData(buffer.get(RAIN), waveFile.format, waveFile.data, waveFile.samplerate);
    waveFile.dispose();

    waveFile = WaveData.create("ocean.wav");
    AL10.alBufferData(buffer.get(OCEAN), waveFile.format, waveFile.data, waveFile.samplerate);
    waveFile.dispose();

    waveFile = WaveData.create("chimes.wav");
    AL10.alBufferData(buffer.get(CHIMES), waveFile.format, waveFile.data, waveFile.samplerate);
    waveFile.dispose();

    <span class="codeComment">// Do another error check and return.</span>
    <span class="codeKeyword">if</span> (AL10.alGetError() == AL10.AL_NO_ERROR)
      <span class="codeKeyword">return</span> AL10.AL_TRUE;

    <span class="codeKeyword">return</span> AL10.AL_FALSE;
</pre>

<p>
	We've totally removed the source generation from this function. That's
	because from now on we will be initializing the sources separately.
</p>

<pre class="code">
<span class="codeComment">  /**
   * void AddSource(ALint type)
   *
   *  Will add a new water drop source to the audio scene.
   */</span>
  <span class="codeKeyword">private void</span> addSource(<span class="codeKeyword">int</span> type) {
    <span class="codeKeyword">int</span> position = source.position();
    source.limit(position + 1);
    AL10.alGenSources(source);

    <span class="codeKeyword">if</span> (AL10.alGetError() != AL10.AL_NO_ERROR) {
      System.out.println("Error generating audio source.");
      System.exit(-1);
    }

    AL10.alSourcei(source.get(position), AL10.AL_BUFFER,   buffer.get(type) );
    AL10.alSourcef(source.get(position), AL10.AL_PITCH,    1.0f             );
    AL10.alSourcef(source.get(position), AL10.AL_GAIN,     1.0f             );
    AL10.alSource (source.get(position), AL10.AL_POSITION, sourcePos        );
    AL10.alSource (source.get(position), AL10.AL_VELOCITY, sourceVel        );
    AL10.alSourcei(source.get(position), AL10.AL_LOOPING,  AL10.AL_TRUE     );

    AL10.alSourcePlay(source.get(position));

    // next index
    source.position(position+1);
  }
</pre>

<p>
	Here's the function that will generate the sources for us. This function
	will generate a single source for any one of the loaded buffers we generated
	in the previous source. Given the buffer index 'type'. We do an error check
	to make sure we have a source to play (like I said, they are finite). If a
	source cannot be allocated then the program will exit.
</p>

<pre class="code">
  <span class="codeComment">/**
   * void killALData()
   *
   *  We have allocated memory for our buffers and sources which needs
   *  to be returned to the system. This function frees that memory.
   */</span>
  <span class="codeKeyword">void</span> killALData() {
    <span class="codeComment">// set to 0, num_sources</span>
    <span class="codeKeyword">int</span> position = source.position();
    source.position(0).limit(position);
    AL10.alDeleteSources(source);
    AL10.alDeleteBuffers(buffer);
  }
</pre>

<p>
	This function has been modified a bit to accommodate the number of actually
	created sources.
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
        <span class="codeKeyword">case</span> 'w': addSource(WATERDROP);  <span class="codeKeyword">break</span>;
        <span class="codeKeyword">case</span> 't': addSource(THUNDER);    <span class="codeKeyword">break</span>;
        <span class="codeKeyword">case</span> 's': addSource(STREAM);     <span class="codeKeyword">break</span>;
        <span class="codeKeyword">case</span> 'r': addSource(RAIN);       <span class="codeKeyword">break</span>;
        <span class="codeKeyword">case</span> 'o': addSource(OCEAN);      <span class="codeKeyword">break</span>;
        <span class="codeKeyword">case</span> 'c': addSource(CHIMES);     <span class="codeKeyword">break</span>;
      };
    }
    killALData();
  }
}
</pre>

<p>
	Here is the programs inner loop taken straight out of our main. Basically it
	waits for some keyboard input and on certain key hits it will create a new
	source of a certain type and add it to the audio scene. Essentially what we
	have created here is something like one of those nature tapes that people
	listen to for relaxation. Ours is a little better since it allows the user
	to customize which sounds that they want in the background. Pretty neat eh?
	I've been listening to mine while I code. It's a Zen experience (I'm
	listening to it right now).<br/><br/>
	The program can be expanded for using more wav files, and have the added
	feature of placing the sources around the scene in arbitrary positions. You
	could even allow for sources to play with a given frequency rather than have
	them loop. However this would require GUI routines that go beyond the scope
	of the tutorial. A full featured "Weathering Engine" would be a nifty
	program to make though. ;)
</p>

<p>
	Download source code and resources for this lesson <a href="_files/tutorials/openal_devmaster_lesson5.zip">here</a>.
</p>

<? require('_include/footer.php'); ?>
