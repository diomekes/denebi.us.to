<?php

$folder = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
$url    = sprintf('http://%s%s', $_SERVER['SERVER_NAME'], $folder);
$lists  = 'lists/';
$phps   = $url . $lists . 'php/';
$name   = basename($_SERVER['PHP_SELF'], '.php');

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
    $lines = file($lists . 'words.txt');
    $name = trim($lines[array_rand($lines)], "\n");
    while (file_exists($lists . $name) && strlen($name) < 10) {
        $name .= rand(0,9);
    }
    if (strlen($name) < 10) {
        header("Location: ".$url . $name);
    }
    die();
}

$name = sanitize_file_name($_GET["f"]);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?php print $name ?></title>
    <link href="<?php print $lists ?>css/main.css" rel="stylesheet" type="text/css" />
    <script src="<?php print $lists ?>js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php print $lists ?>js/jquery.jeditable.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
    $(function() {
      $(".editable_textile").editable("<?php print $phps ?>save.php?renderer=textile", { 
        loadurl   : "<?php print $phps ?>load.php",
        type      : "textarea",
        submit    : "OK",
        cancel    : "Cancel"
      });
    });
    </script>
</head>
<body>
    <div class="editable_textile" id="<?php print $name ?>"><?php print file_get_contents($phps . "load.php?id=$name&renderer=textile") ?></div>
<a href="gallery/">gallery</a>
<a href="tabs/">tabs</a>
<a href="eat/">eat</a>
    <pre id="print"></pre>
    <script src="<?php print $lists ?>js/tabby.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php print $lists ?>js/jquery.textarea.js" type="text/javascript" charset="utf-8"></script>
</body>
</html>
