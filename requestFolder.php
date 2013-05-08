<?php

$pathArray = array("//enas11/test/Rainmaker/Charts/","//enas11/test/Rainmaker/Food and Beverage/","//enas11/test/Rainmaker/Compliance/");
//$path = "//enas11/test/Rainmaker/";
$fileData = array();


	$fileData = fillArrayWithFileNodes( new DirectoryIterator(urldecode($_GET['path'])));


function fillArrayWithFileNodes( DirectoryIterator $dir, $data = array())
{
  foreach ( $dir as $node )
  {
    if ( $node->isDir() && !$node->isDot() )
    {
      $data[$node->getPath(). "/" . $node->getFilename()] = array();
    }
    else if ( $node->isFile() )
    {
      $data[] = $node->getPath(). "/" . $node->getFilename();
    }
  }
  return $data;
}


function printArrayAsList($array) {
	$data = "<ul>\n";
	foreach($array as $key => $value) {
		$data .= "<li>\n";
		if(is_array($value)) {
			$data .= "<span class=\"folder\"><a href='requestFolder.php?path=".urlencode($key)."'>" .$key."</a></span>\n";
			//$data .= printArrayAsList($value);
		} else {
			$data .= "<span class=\"file\">" .$value."</span>\n";	
		}
		$data .= "</li>\n";
	}
	$data .= "</ul>\n";
	return $data;
}

?>


<li><span class="folder"><?php echo urldecode($_GET['path']); ?></span>
<?php echo  printArrayAsList($fileData); ?>
</li>


