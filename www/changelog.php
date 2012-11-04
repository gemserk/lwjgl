<?
require('_include/header.php');

function displayChangelog($version) {
	echo "<p>\n";
	echo "    <a name=\"".$version."\"><b>LWJGL ".$version."</b></a> <span class=\"newsdate\"><a href=\"#top\">Back to top</a></span>\n";
	echo "</p>\n";
	echo "<pre>";
	@readfile('changelogs/'.$version.'-changelog.txt');
	echo "</pre>";
}
?>

<h1><a name="top">Changelog</a></h1>
<p>
	The following is a list of changes of LWJGL per release.
</p>
<ul>
	<li><a href="http://www.lwjgl.org/changelogs/full-changelog.txt" target="_blank">Full changelog</a></li>
	<li><a href="#2.8.4">LWJGL 2.8.5</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.8.4-changelog.txt" target="_blank">LWJGL 2.8.4</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.8.3-changelog.txt" target="_blank">LWJGL 2.8.3</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.8.2-changelog.txt" target="_blank">LWJGL 2.8.2</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.8.1-changelog.txt" target="_blank">LWJGL 2.8.1</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.8.0-changelog.txt" target="_blank">LWJGL 2.8.0</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.7.1-changelog.txt" target="_blank">LWJGL 2.7.1</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.7-changelog.txt" target="_blank">LWJGL 2.7</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.6-changelog.txt" target="_blank">LWJGL 2.6</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.5-changelog.txt" target="_blank">LWJGL 2.5</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.4.2-changelog.txt" target="_blank">LWJGL 2.4.2</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.4.1-changelog.txt" target="_blank">LWJGL 2.4.1</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.4-changelog.txt" target="_blank">LWJGL 2.4</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.3-changelog.txt" target="_blank">LWJGL 2.3</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.2.2-changelog.txt" target="_blank">LWJGL 2.2.2</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.2.1-changelog.txt" target="_blank">LWJGL 2.2.1</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.2.0-changelog.txt" target="_blank">LWJGL 2.2.0</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/2.1.0-changelog.txt" target="_blank">LWJGL 2.1.0</a></li>	
	<li><a href="http://www.lwjgl.org/changelogs/2.0.1-changelog.txt" target="_blank">LWJGL 2.0.1</a></li>	
	<li><a href="http://www.lwjgl.org/changelogs/2.0-changelog.txt" target="_blank">LWJGL 2.0</a></li>	
	<li><a href="http://www.lwjgl.org/changelogs/2.0-rc2-changelog.txt" target="_blank">LWJGL 2.0-rc2</a></li>	
	<li><a href="http://www.lwjgl.org/changelogs/2.0-rc1-changelog.txt" target="_blank">LWJGL 2.0-rc1</a></li>	
	<li><a href="http://www.lwjgl.org/changelogs/1.1.4-changelog.txt" target="_blank">LWJGL 1.1.4</a></li>	
	<li><a href="http://www.lwjgl.org/changelogs/1.1.3-changelog.txt" target="_blank">LWJGL 1.1.3</a></li>	
	<li><a href="http://www.lwjgl.org/changelogs/1.1.2-changelog.txt" target="_blank">LWJGL 1.1.2</a></li>	
	<li><a href="http://www.lwjgl.org/changelogs/1.1.1-changelog.txt" target="_blank">LWJGL 1.1.1</a></li>	
	<li><a href="http://www.lwjgl.org/changelogs/1.1-changelog.txt" target="_blank">LWJGL 1.1</a></li>	
	<li><a href="http://www.lwjgl.org/changelogs/1.0-changelog.txt" target="_blank">LWJGL 1.0</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/1.0-rc1-changelog.txt" target="_blank">LWJGL 1.0-rc1</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/1.0beta4-changelog.txt" target="_blank">LWJGL 1.0beta4</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/1.0beta3-changelog.txt" target="_blank">LWJGL 1.0beta3</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/1.0beta2-changelog.txt" target="_blank">LWJGL 1.0beta2</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/1.0beta-changelog.txt" target="_blank">LWJGL 1.0beta</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.99-changelog.txt" target="_blank">LWJGL 0.99</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.98-changelog.txt" target="_blank">LWJGL 0.98</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.97-changelog.txt" target="_blank">LWJGL 0.97</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.96-changelog.txt" target="_blank">LWJGL 0.96</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.95-changelog.txt" target="_blank">LWJGL 0.95</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.94-changelog.txt" target="_blank">LWJGL 0.94</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.93-changelog.txt" target="_blank">LWJGL 0.93</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.92-changelog.txt" target="_blank">LWJGL 0.92</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.90-changelog.txt" target="_blank">LWJGL 0.90</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.89-changelog.txt" target="_blank">LWJGL 0.89</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.80-changelog.txt" target="_blank">LWJGL 0.80</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.70-changelog.txt" target="_blank">LWJGL 0.70</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.60-changelog.txt" target="_blank">LWJGL 0.60</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.50-changelog.txt" target="_blank">LWJGL 0.50</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.40-changelog.txt" target="_blank">LWJGL 0.40</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.30-changelog.txt" target="_blank">LWJGL 0.30</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.20-changelog.txt" target="_blank">LWJGL 0.20</a></li>
	<li><a href="http://www.lwjgl.org/changelogs/0.10-changelog.txt" target="_blank">LWJGL 0.10</a></li>
</ul>

<?
displayChangelog('2.8.5');
require('_include/footer.php');
?>
