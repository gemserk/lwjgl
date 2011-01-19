<? 
header("Content-type: application/x-java-jnlp-file"); 
?>

<!-- JNLP Extension File --> 
<jnlp 
  spec="1.0+" 
  codebase="http://lwjgl.org/jnlp/" 
  href="extension.php"> 
  <information> 
    <title>LWJGL</title> 
    <vendor>LWJGL</vendor> 
    <homepage href="http://lwjgl.org/"/> 
    <description>LWJGL webstart extension</description> 
    <description kind="short">LWJGL webstart extension</description> 
    <icon kind="splash" href="logo.png" />
    <offline-allowed/> 
  </information> 
  <security> 
      <all-permissions/> 
  </security>
  <resources> 
    <j2se version="1.4+"/> 
    <jar href="lwjgl.jar"/>
    <jar href="lwjgl_util.jar"/>
    <jar href="jinput.jar"/>
  </resources> 
  <resources os="Windows">
    <j2se version="1.4+"/> 
    <nativelib href="native_windows.jar"/>
  </resources> 
  <resources os="Linux">
    <j2se version="1.4+"/> 
    <nativelib href="native_linux.jar"/>
  </resources>   
  <resources os="Mac OS X">
    <j2se version="1.4+"/> 
    <nativelib href="native_macosx.jar"/>
  </resources>
  <resources os="SunOS" arch="x86">
    <j2se version="1.4+"/> 
    <nativelib href="native_solaris.jar"/>
  </resources>  
  
  <component-desc />
</jnlp>
