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

<h1>Advanced Loading and Error Handles: Lesson 6</h1>
<p>
    <i>
		Author: <a href="mailto:lightonthewater@hotmail.com">Jesse Maurais</a> | From: <a href="http://www.devmaster.net/articles.php?catID=6" target="_blank">devmaster.net</a><br/>
    	Modified for LWJGL by: <a href="mailto:brian@matzon.dk">Brian Matzon</a>
	</i>
</p>

<p>
	We've been doing some pretty simple stuff up until now that didn't require
	us to be very precise in the way we've handled things. The reason for
	this is that we have been writing code for simplicity in order to learn
	easier, rather that for robustness. Since we are going to move into some advanced
	stuff soon we will take some time to learn the proper ways. Most importantly
	we will learn a more advanced way of handling errors. We will also reorganize
	the way we have been loading audio data. There wasn't anything wrong with our
	methods in particular, but we will need a more organized and flexible approach
	to the process.<br/><br/>
	We will first consider a few functions that will help us out a lot by the time we have finished.
</p>

<pre class="code" style="clear: right;">
<span class="codeComment">  /**
   * 1) Identify the error code.
   * 2) Return the error as a string.
   */  </span>
  <span class="codeKeyword">public static</span> String getALErrorString(<span class="codeKeyword">int</span> err);
<span class="codeComment">
  /**
   * 1) Identify the error code.
   * 2) Return the error as a string.
   */  </span>
  <span class="codeKeyword">public static</span> String getALCErrorString(<span class="codeKeyword">int</span> err);
<span class="codeComment">
  /**
   * 1) Creates a buffer.
   * 2) Loads a wav file into the buffer.
   * 3) Returns the buffer id.
   */  </span>
  <span class="codeKeyword">public static int</span> loadALBuffer(String path);
<span class="codeComment">
  /**
   * 1) Checks if file has already been loaded.
   * 2) If it has been loaded already, return the buffer id.
   * 3) If it has not been loaded, load it and return buffer id.
   */  </span>
  <span class="codeKeyword">public static int</span> getLoadedALBuffer(String path);
<span class="codeComment">
  /**
   * 1) Checks if file has already been loaded.
   * 2) If it has been loaded already, return the buffer id.
   * 3) If it has not been loaded, load it and return buffer id.
   */  </span>
  <span class="codeKeyword">public static int</span> loadALSample(String path, <span class="codeKeyword">boolean</span> loop);
<span class="codeComment">
  /**
   * 1) Releases temporary loading phase data.
   */  </span>
  <span class="codeKeyword">public static void</span> killALLoadedData();
<span class="codeComment">
  /**
   * 1) Loads all buffers and sources for the application.
   */  </span>
  <span class="codeKeyword">public static void</span> loadALData();
<span class="codeComment">
  /**
   * 1) Releases all buffers.
   * 2) Releases all sources.
   */  </span>
  <span class="codeKeyword">public static void</span> killALData();

  <span class="codeComment">/** List of loaded files */</span>
  <span class="codeKeyword">private static</span> ArrayList loadedFiles = <span class="codeKeyword">new</span> ArrayList();

  <span class="codeComment">/** List of buffers */</span>
  <span class="codeKeyword">private static</span> ArrayList buffers = <span class="codeKeyword">new</span> ArrayList();

  <span class="codeComment">/** List of sources */</span>
  <span class="codeKeyword">private static</span> ArrayList sources = <span class="codeKeyword">new</span> ArrayList();
</pre>

<p>
	Take a close look at the functions and try to understand what we are going
	to be doing. Basically what we are trying to create is a system in which we
	no longer have to worry about the relationship between buffers and sources.
	We can call for the creation of a source from a file and this system will
	handle the buffer's creation on it's own so we don't duplicate a buffer
	(have two buffers with the same data). This system will handle the buffers
	as a limited resource, and will handle that resource efficiently.
</p>

<pre class="code">
<span class="codeComment">  /**
   * 1) Identify the error code.
   * 2) Return the error as a string.
   */</span>
  <span class="codeKeyword">public static</span> String getALErrorString(<span class="codeKeyword">int</span> err) {
    <span class="codeKeyword">switch</span> (err) {
      <span class="codeKeyword">case</span> AL10.AL_NO_ERROR:
        <span class="codeKeyword">return</span> "AL_NO_ERROR";
      <span class="codeKeyword">case</span> AL10.AL_INVALID_NAME:
        <span class="codeKeyword">return</span> "AL_INVALID_NAME";
      <span class="codeKeyword">case</span> AL10.AL_INVALID_ENUM:
        <span class="codeKeyword">return</span> "AL_INVALID_ENUM";
      <span class="codeKeyword">case</span> AL10.AL_INVALID_VALUE:
        <span class="codeKeyword">return</span> "AL_INVALID_VALUE";
      <span class="codeKeyword">case</span> AL10.AL_INVALID_OPERATION:
        <span class="codeKeyword">return</span> "AL_INVALID_OPERATION";
      <span class="codeKeyword">case</span> AL10.AL_OUT_OF_MEMORY:
        <span class="codeKeyword">return</span> "AL_OUT_OF_MEMORY";
      <span class="codeKeyword">default</span>:
        <span class="codeKeyword">return</span> "No such error code";
    }
  }
</pre>

<p>
	This function will convert an OpenAL error code to a string so it
	can be read on the console (or some other device). The OpenAL sdk says
	that the only exception that needs be looked for in the current version
	is the 'AL_OUT_OF_MEMORY' error. However, we will account for all the
	errors so that our code will be up to date with later versions.
</p>

<pre class="code">
<span class="codeComment">  /**
   * 1) Identify the error code.
   * 2) Return the error as a string.
   */  </span>
  <span class="codeKeyword">public static</span> String getALCErrorString(<span class="codeKeyword">int</span> err) {
    <span class="codeKeyword">switch</span> (err) {
      <span class="codeKeyword">case</span> ALC.ALC_NO_ERROR:
        <span class="codeKeyword">return</span> "AL_NO_ERROR";
      <span class="codeKeyword">case</span> ALC.ALC_INVALID_DEVICE:
        <span class="codeKeyword">return</span> "ALC_INVALID_DEVICE";
      <span class="codeKeyword">case</span> ALC.ALC_INVALID_CONTEXT:
        <span class="codeKeyword">return</span> "ALC_INVALID_CONTEXT";
      <span class="codeKeyword">case</span> ALC.ALC_INVALID_ENUM:
        <span class="codeKeyword">return</span> "ALC_INVALID_ENUM";
      <span class="codeKeyword">case</span> ALC.ALC_INVALID_VALUE:
        <span class="codeKeyword">return</span> "ALC_INVALID_VALUE";
      <span class="codeKeyword">case</span> ALC.ALC_OUT_OF_MEMORY:
        <span class="codeKeyword">return</span> "ALC_OUT_OF_MEMORY";
      <span class="codeKeyword">default</span>:
        <span class="codeKeyword">return</span> "no such error code";
    }
  }
</pre>

<p>
	This function will perform a similar task as the previous one accept this one will
	interpret Alc errors. OpenAL and Alc share common id's, but not common enough
	and not dissimilar enough to use the same function for both.
</p>

<p>
	One more note about the function 'alGetError': The OpenAL sdk defines that it
	only holds a single error at a time (i.e. there is no stacking). When the
	function is invoked it will return the first error that it has received, and then
	clear the error bit to 'AL_NO_ERROR'. In other words an error will only be stored
	in the error bit if no previous error is already stored there.
</p>

<pre class="code">
  <span class="codeComment">/**
   * 1) Creates a buffer.
   * 2) Loads a wav file into the buffer.
   * 3) Returns the buffer id.
   */</span>
  <span class="codeKeyword">public static int</span> loadALBuffer(String path) {
    int result;
    IntBuffer buffer = BufferUtils.createIntBuffer(1);

    <span class="codeComment">// Load wav data into a buffers.</span>
    AL10.alGenBuffers(buffer);

    <span class="codeKeyword">if</span> ((result = AL10.alGetError()) != AL10.AL_NO_ERROR) {
      throw <span class="codeKeyword">new</span> OpenALException(getALErrorString(result));
    }

    WaveData waveFile = WaveData.create(path);
    <span class="codeKeyword">if</span> (waveFile != <span class="codeKeyword">null</span>) {
      AL10.alBufferData(buffer.get(0), waveFile.format, waveFile.data, waveFile.samplerate);
      waveFile.dispose();
    } <span class="codeKeyword">else</span> {
      throw <span class="codeKeyword">new</span> RuntimeException("No such file: " + path);
    }

    <span class="codeComment">// Do another error check and return.</span>
    <span class="codeKeyword">if</span> ((result = AL10.alGetError()) != AL10.AL_NO_ERROR) {
      throw <span class="codeKeyword">new</span> OpenALException(getALErrorString(result));
    }

    <span class="codeKeyword">return</span> buffer.get(0);
  }
</pre>

<p>
	As you can see we do an error check at every possible phase of the load.
	Any number of things can happen at this point which will cause an error to be
	thrown. There could be no more system memory either for the buffer creation or
	the data to be loaded, the wav file itself may not even exist, or an invalid value
	can be passed to any one of the OpenAL functions which will generate an error.
</p>

<pre class="code">
  <span class="codeComment">/**
   * 1) Checks if file has already been loaded.
   * 2) If it has been loaded already, return the buffer id.
   * 3) If it has not been loaded, load it and return buffer id.
   */</span>
  <span class="codeKeyword">public static int</span> getLoadedALBuffer(String path) {
    <span class="codeKeyword">int</span> count = 0;
    <span class="codeKeyword">for</span> (Iterator i = loadedFiles.iterator(); i.hasNext(); count++) {
      <span class="codeKeyword">if</span> (i.equals(path)) {
      	<span class="codeKeyword">return</span> ((Integer) buffers.get(count)).intValue();
      }
    }

    int</span> buffer = loadALBuffer(path);

    buffers.add(new Integer(buffer));
    loadedFiles.add(path);

    <span class="codeKeyword">return</span> buffer;
  }
</pre>

<p>
	This will probably be the piece of code most people have trouble with,
 	but it's really not that complex. We are doing a search through a
 	list which contains the file paths of all the wav's we have loaded
 	so far. If one of the paths matches the one we want to load, we will
 	simply return the id to the buffer we loaded it into the first
 	time. This way as long as we consistently load our files through this
	function, we will never have buffers wasted due to duplication. Every file
 	loaded this way must also be kept track of with it's own list. The 'buffers' list
 	is parallel to the 'loadedFiles' list. What I mean by this is that
 	every buffer in the index of 'buffers', is the same path of the index in 'loadedFiles'
 	from which that buffer was created.
</p>

<pre class="code">
  <span class="codeComment"> /**
    * 1) Creates a source.
    * 2) Calls 'GetLoadedALBuffer' with 'path' and uses the
    *    returned buffer id as it's sources buffer.
    * 3) Returns the source id.
    */</span>
   <span class="codeKeyword">public static int</span> loadALSample(String path, <span class="codeKeyword">boolean</span> loop) {
      IntBuffer source = BufferUtils.createIntBuffer(1);
      <span class="codeKeyword">int</span> buffer;
      <span class="codeKeyword">int</span> result;

      <span class="codeComment">// Get the files buffer id (load it if necessary).</span>
      buffer = getLoadedALBuffer(path);

      <span class="codeComment">// Generate a source.</span>
      AL10.alGenSources(source);

      <span class="codeKeyword">if</span> ((result = AL10.alGetError()) != AL10.AL_NO_ERROR)
          throw <span class="codeKeyword">new</span> OpenALException(getALErrorString(result));

      <span class="codeComment">// Setup the source properties.</span>
      AL10.alSourcei(source.get(0), AL10.AL_BUFFER,   buffer    );
      AL10.alSourcef(source.get(0), AL10.AL_PITCH,    1.0f      );
      AL10.alSourcef(source.get(0), AL10.AL_GAIN,     1.0f      );
      AL10.alSource (source.get(0), AL10.AL_POSITION, sourcePos );
      AL10.alSource (source.get(0), AL10.AL_VELOCITY, sourceVel );
      AL10.alSourcei(source.get(0), AL10.AL_LOOPING,  (loop ? AL10.AL_TRUE : AL10.AL_FALSE));

      <span class="codeComment">// Save the source id.</span>
      sources.add(<span class="codeKeyword">new</span> Integer(source.get(0)));

      <span class="codeComment">// Return the source id.</span>
      <span class="codeKeyword">return</span> source.get(0);
  }
</pre>

<p>
	Now that we have created a system which will handle the buffers for us, we just need an
	extension to it that will get the sources. In this code we obtain the result of a search
	for the file, which is the buffer id that the file was loaded into. This buffer is bound
	to the new source. We save the source id internally and also return it.
</p>

<pre class="code">
  <span class="codeComment">/**
   * 1) Releases temporary loading phase data.
   */</span>
  <span class="codeKeyword">public static void</span> killALLoadedData() {
      loadedFiles.clear();
  }
</pre>

<p>
	The global arraylist 'loadedFiles' stored the file path of every wav file that was loaded
	into a buffer. It doesn't make sense to keep this data lying around after we have loaded all
	of our data, so we will dispose of it.
</p>

<pre class="code">
  <span class="codeComment">//Source id's.</span>
  <span class="codeKeyword">static int</span> phaser1;
  <span class="codeKeyword">static int</span> phaser2;

  <span class="codeKeyword">public static void</span> loadALData()   {
    <span class="codeComment">// Anything for your application here. No worrying about buffers.</span>
    phaser1 = loadALSample("phaser.wav", <span class="codeKeyword">false</span>);
    phaser2 = loadALSample("phaser.wav", <span class="codeKeyword">true</span>);

    killALLoadedData();
  }
</pre>

<p>
	We have seen the function in previous tutorials. It will represent the part of a program which
	loads all wav's used by the program. In it we can see why our system is useful. Even though we have
	made a call to load the same wav file into two distinct sources, the buffer for the file 'phaser.wav'
	will only be created once, and the sources 'gPhaser1' and 'gPhaser2' will both use that buffer for
	playback. There is no more concern for handling buffers because the system will handle them automatically.
</p>

<pre class="code">
<span class="codeComment">  /**
   * 1) Releases all buffers.
   * 2) Releases all sources.
   */</span>
  <span class="codeKeyword">public static void</span> killALData() {
    IntBuffer scratch = BufferUtils.createIntBuffer(1);

    <span class="codeComment">// Release all buffer data.</span>
    <span class="codeKeyword">for</span> (Iterator iter = buffers.iterator(); iter.hasNext();) {
    	scratch.put(0, ((Integer) iter.next()).intValue());
      AL10.alDeleteBuffers(scratch);
    }

    <span class="codeComment">// Release all source data.</span>
    <span class="codeKeyword">for</span> (Iterator iter = sources.iterator(); iter.hasNext();) {
      scratch.put(0, ((Integer) iter.next()).intValue());
      AL10.alDeleteSources(scratch);
    }

    <span class="codeComment">// Destroy the lists.</span>
    buffers.clear();
    sources.clear();
  }
</pre>

<p>
	All along we have been storing the buffer and source id's into array lists. We free all the buffers
	and sources by going through them and releasing them individually. After which we destroy
	the lists themselves. All we need to do now is catch the OpenAL errors that we have thrown.
</p>

<pre class="code">
  <span class="codeKeyword">try</span> {
      InitOpenAL();
      loadALData();
    } <span class="codeKeyword">catch</span> (Exception e) {
      e.printStackTrace();
    }
</pre>

<p>
	If something has gone wrong during the course of the load we will be notified of it right away.
	When we catch the error it will be reported on the console. We can use this for debugging or
	general error reporting.
</p>

<p>
	That's it. A more advanced way of reporting errors, and a more robust way of loading your
	wav files. We may find we need to do some modifications in the future to allow for more
	flexibility, but for now we will be using this source for basic file loading in future
	tutorials. Expect future tutorials to expand on this code.
</p>

<? require('_include/footer.php'); ?>
