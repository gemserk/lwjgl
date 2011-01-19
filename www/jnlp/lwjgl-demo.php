<? 
header("Content-type: application/x-java-jnlp-file"); 
?>

<!-- JNLP File for LWJGL Demos --> 
<jnlp 
  spec="1.0+" 
  codebase="http://lwjgl.org/jnlp/" 
  href="lwjgl-demo.php/<?php echo substr($_SERVER["PATH_INFO"], 1, strlen($_SERVER["PATH_INFO"])-1); ?>"> 
  <information> 
    <title>LWJGL Demo [<?php echo substr($_SERVER["PATH_INFO"], 1, strlen($_SERVER["PATH_INFO"])-1); ?>]</title> 
    <vendor>LWJGL</vendor> 
    <homepage href="http://lwjgl.org/"/> 
    <description>Demonstration of LWJGL</description> 
    <description kind="short">Technology Preview</description> 
    <icon kind="splash" href="logo.png" />
    <offline-allowed/> 
  </information> 
  <resources> 
    <j2se version="1.4+"/> 
		<jar href="lwjgl_test.jar"/>
    <jar href="media.jar"/>
    <extension name="lwjgl" href="http://lwjgl.org/jnlp/extension.php" />
  </resources> 
  <application-desc main-class="org.lwjgl.<?php echo substr($_SERVER["PATH_INFO"], 1, strlen($_SERVER["PATH_INFO"])-1); ?>">
  <?php
    if(isset($HTTP_GET_VARS['arguments'])) {
      $arguments = $HTTP_GET_VARS['arguments'];
      foreach ($arguments as $argument) {
        echo "<argument>" . $argument . "</argument>\n";
      }
    }
  ?>
  </application-desc>
</jnlp>
