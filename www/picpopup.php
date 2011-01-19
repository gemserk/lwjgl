<? $imageData = getimagesize('_gfx/projects/'.urldecode($_GET['image'])); ?>

<html>

	<head>
		<title>LWJGL - Home of the Lightweight Java Game Library</title>

		<SCRIPT LANGUAGE="JavaScript">
		    <!--
				window.resizeTo(<?=($imageData[0] + 10);?>,<?=($imageData[1] + 30);?>);
				window.moveTo((screen.width-<?=$imageData[0];?>) / 2, (screen.height-<?=$imageData[1];?>) / 2);
				window.focus();
			//-->
		</SCRIPT>
	</head>

	<body bgcolor="#ffffff" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" style="margin: 0px;">
		<a href="javascript:window.close();"><img src="_gfx/projects/<?=$_GET['image'];?>" alt="Close Window" border="0"></a>
	</body>

</html>
