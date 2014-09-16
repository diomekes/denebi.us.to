<?php

// Root URL of the website
$URL = "http://denebi.us.to";

// Subfolder to output user content
$FOLDER = "_tmp";



function sanitize_file_name($filename) {
    // Original function source code borrowed from wordpress
    $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", ".");
    $filename = str_replace($special_chars, '', $filename);
    $filename = preg_replace('/[\s-]+/', '-', $filename);
    $filename = trim($filename, '.-_');
    return $filename;
}

if (!isset($_GET["f"])) {
    // User has not specified a name, just get one and refresh
    $lines = file("files/words.txt");
    $name = trim($lines[array_rand($lines)], "\n");
    while (file_exists($FOLDER."/".$name) && strlen($name) < 10) {
        $name .= rand(0,9);
    }
    if (strlen($name) < 10) {
        header("Location: ".$URL."/".$name);
    }
    die();
}

$name = sanitize_file_name($_GET["f"]);
$path = $FOLDER."/".$name;

if (isset($_POST["t"])) {
    // Update content of file
    file_put_contents($path, $_POST["t"]);
    die();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?php print $name ?></title>
    <link href="files/notes.css" rel="stylesheet" />
    <link href="files/normalize.css" rel="stylesheet" />
    <script type="text/javascript" src="files/jquery.min.js"></script>
    <script type="text/javascript" src="files/jhtmlarea.js"></script>
    <link rel="stylesheet" type="text/css" href="files/jHtmlArea.css" />
</head>
<body>

   <script type="text/javascript">    
        $(function() {
            $("#content").htmlarea({
                toolbar:
                    [ "strikethrough", "link", "unlink" ]
           })
        })
   </script>
        <textarea id="content" spellcheck="true"><?php 
            if (file_exists($path)) {
                print htmlspecialchars(file_get_contents($path));
            }
?></textarea>
<a href="gallery/">gallery</a>
<a href="tabs/">tabs</a>
<a href="eat/">eat</a>
    <pre id="print"></pre>
    <script src="files/tabby.js"></script>
    <script src="files/jquery.textarea.js"></script>
</body>
</html>
