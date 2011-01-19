<?
	$projects = array();
	
	$projects[] = array(
						'name'    			=> 'Tribal Trouble',
						'url'     			=> 'http://tribaltrouble.com',
						'price'					=> '$29.95',
						'donation'			=> '$29.95 (100%)',
						'product'     	=> 'http://www.plimus.com/jsp/redirect.jsp?contractId=1648130&referrer=LWJGL',
						'link'					=> '<a href=\'http://www.plimus.com/jsp/download_trial.jsp?contractId=1648130&referrer=LWJGL\'>Download Trial</a>&nbsp;|&nbsp;<a href=\'http://www.plimus.com/jsp/buynow.jsp?contractId=1648130&referrer=LWJGL\'>Buy Now</a>',
						'type'    			=> 'Real Time Strategy',
						'desc'    			=> 'Take the role of a chieftain and lead your clueless kinsmen to new discoveries and victories as tribal clashes rage across a group of tropical islands. Tribal Trouble is a fast paced realtime strategy game where you will find yourself pitted against your computer or online players as you collect resources, research new ground-breaking technologies (such as the spear) and rejoice as your armies burn down enemy villages.',
						'screens' 			=> array(
							0 => array(
								'small' => 'tribaltrouble_small_1.jpg',
								'big'   => 'tribaltrouble_1.jpg'),
							1 => array(
								'small' => 'tribaltrouble_small_2.jpg',
								'big'   => 'tribaltrouble_2.jpg'),
							2 => array(
								'small' => 'tribaltrouble_small_3.jpg',
								'big'   => 'tribaltrouble_3.jpg')));
													  												  
	$projects[] = array(
						'name'    			=> 'Ultratron',
						'url'     			=> 'http://www.puppygames.net/',
						'price'					=> '$9.95',
						'donation'			=> '$9.95 (100%)',
						'product'     	=> 'http://puppygames.net/ultratron/index.php?referrer=LWJGL',
						'link'					=> '<a href=\'http://www.puppygames.net/downloads/Ultratron_MacOSX_LWJGL.zip\'>Play now (Mac)</a>&nbsp;|&nbsp;<a href=\'http://www.puppygames.net/downloads/SetupUltratronDemoLWJGL.exe\'>Play now (Win)</a>&nbsp;|&nbsp;<a href=\'3rdparty/ultratron.jnlp\'>Play now (Linux)</a>',
						'type'    			=> 'Shoot-em-up',
						'desc'    			=> 'The last human has been slain by evil killer robots. You are the one remaining humanoid battle droid. Your mission is to avenge the human race, and destroy the four bots of the Apocalypse - Ieiunitas, Bellum, Lues and Letum!
													Power up your droid with ever more powerful weaponry as you blast your way through the levels, avoiding Chasers, Turrets, Spawners, Minelayers, bombs, and bullets!',
						'screens' => array(
							0 => array(
								'small' => 'ultratron_small_1.jpg',
								'big'   => 'ultratron_1.jpg'),
							1 => array(
								'small' => 'ultratron_small_2.jpg',
								'big'   => 'ultratron_2.jpg'),
							2 => array(
								'small' => 'ultratron_small_3.jpg',
								'big'   => 'ultratron_3.jpg')));
								
	$projects[] = array(
						'name'    			=> 'Droid Assualt',
						'url'     			=> 'http://www.puppygames.net/',
						'price'					=> '&euro;6.77',
						'donation'			=> '&euro;2.00 (30%)',
						'product'     	=> 'http://www.puppygames.net/droid-assault/index.php?referrer=LWJGL',
						'link'					=> '<a href=\'https://secure.bmtmicro.com/servlets/RIP.DemoDownload?PRODUCTID=18990019&AID=1823735\'>Play now (Mac)</a>&nbsp;|&nbsp;<a href=\'https://secure.bmtmicro.com/servlets/RIP.DemoDownload?PRODUCTID=18990018&AID=1823735\'>Play now (Win)</a>&nbsp;|&nbsp;<a href=\'http://www.puppygames.net/applets/droidassault.jnlp?referrer=LWJGL\'>Play now (Linux)</a>',
						'type'    			=> 'Shoot-em-up',
						'desc'    			=> 'The droids in Omni-Corp\'s factory warehouses have been activated somehow and are running amok! Take control of the droids using a remote virus and either destroy or capture all the droids in each warehouse before production can begin again. Omni-Corp needs you!',
						'screens' => array(
							0 => array(
								'small' => 'droid_assault_small_1.jpg',
								'big'   => 'droid_assault_1.jpg'),
							1 => array(
								'small' => 'droid_assault_small_2.jpg',
								'big'   => 'droid_assault_2.jpg'),
							2 => array(
								'small' => 'droid_assault_small_3.jpg',
								'big'   => 'droid_assault_3.jpg')));								
												  
	function displayProjects() {
		
		GLOBAL $projects;
		
		shuffle($projects);
		
		foreach ($projects as $project) {
			echo "<p><br/>\n";
			echo "    <b>".$project['name']."</b><br/><br/>\n";
			echo "    <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-bottom: 1px solid #cccccc;\">\n";
			echo "        <tr>\n";
			echo "            <td width=\"110\">&nbsp;&nbsp;&nbsp;&nbsp;<i>Website:</i></td>\n";
			echo "            <td><a href=\"".$project['product']."\">".$project['url']."</a></td>\n";
			echo "        </tr>\n";
			echo "        <tr>\n";
			echo "            <td width=\"110\">&nbsp;&nbsp;&nbsp;&nbsp;<i>Price:</i></td>\n";
			echo "            <td>".$project['price']."</td>\n";
			echo "        </tr>\n";			
			echo "        <tr>\n";
			echo "            <td width=\"110\">&nbsp;&nbsp;&nbsp;&nbsp;<i>Donation:</i></td>\n";
			echo "            <td>".$project['donation']."</td>\n";
			echo "        </tr>\n";			
			echo "        <tr>\n";
			echo "            <td width=\"110\">&nbsp;&nbsp;&nbsp;&nbsp;<i>Type:</i></td>\n";
			echo "            <td>".$project['type']."</td>\n";
			echo "        </tr>\n";
			echo "        <tr>\n";
			echo "            <td width=\"110\" valign=\"top\">&nbsp;&nbsp;&nbsp;&nbsp;<i>Description:</i></td>\n";
			echo "            <td>".$project['desc']."</td>\n";
			echo "        </tr>\n";
			echo "        <tr>\n";
			echo "            <td width=\"110\" valign=\"top\">&nbsp;</td>\n";
			echo "            <td align=\"center\"><br/>\n";
			
			for ($i = 0; $i < count($project['screens']); $i++) {
				echo "<a href=\"javascript: openPopUp('".urlencode($project['screens'][$i]['big'])."');\"><img src=\"_gfx/projects/".$project['screens'][$i]['small']."\" border=\"0\" alt=\"\"/></a>\n";
			}
			
			echo "            <br/><br/></td>\n";
			echo "        </tr>\n";
			echo "        <tr>\n";
			echo "            <td colspan=\"2\" align=\"center\"><font size=\"4\">" . $project['link'] . "</font><br/><br/></td>";
			echo "        </tr>\n";
			echo "    </table>\n";
			echo "</p>\n";
		}
	}

	require('_include/header.php');
?>
		<script language="JavaScript">
			<!--
				function openPopUp(image) {
					openWindow = window.open('picpopup.php?image='+image,'ProjectScreenshot','resizable=no,scrollbars=auto,menubar=no,toolbar=no,location=no,width=400,height=400');
				}
			//-->
		</script>
		
		<h1><a name="top">LWJGL Games for sale</a></h1>
		<p>The following is a list of games made using LWJGL. If you buy any of the games from this page a percentage of the price will
			automatically be donated to LWJGL. If you have a game that you want on this list, please send an email with info (name, pics, price, % donated, etc.) to info@lwjgl.org.
		</p>
		<p align="center"><i><b>In an effort to raise money to kick start the LWJGL donation fund, <a href="http://oddlabs.com">Oddlabs</a> and <a href="http://puppygames.net">Puppygames</a> have graciously agreed to donate 100% of the sales - of some games made through this page - to LWJGL for a limited time.</i></b>
		</p>
<?		
	displayProjects();
	require('_include/footer.php');
?>
