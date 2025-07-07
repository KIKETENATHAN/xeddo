<?php
echo "<h2>Xeddo Directory Contents</h2>";

$xeddo_path = __DIR__ . '/xeddo';
echo "Looking in: " . $xeddo_path . "<br><br>";

if (is_dir($xeddo_path)) {
    echo "<h3>Contents of xeddo directory:</h3>";
    $items = scandir($xeddo_path);
    foreach ($items as $item) {
        if ($item != '.' && $item != '..') {
            $full_path = $xeddo_path . '/' . $item;
            $type = is_dir($full_path) ? '[DIR]' : '[FILE]';
            echo $type . " " . $item . "<br>";
        }
    }
    
    echo "<br><h3>Checking vendor specifically:</h3>";
    $vendor_path = $xeddo_path . '/vendor';
    if (is_dir($vendor_path)) {
        echo "✅ Vendor directory exists<br>";
        echo "Contents of vendor:<br>";
        $vendor_items = scandir($vendor_path);
        $count = 0;
        foreach ($vendor_items as $item) {
            if ($item != '.' && $item != '..' && $count < 10) {
                echo "- " . $item . "<br>";
                $count++;
            }
        }
        
        // Check specifically for autoload.php
        $autoload_path = $vendor_path . '/autoload.php';
        if (file_exists($autoload_path)) {
            echo "<br>✅ autoload.php exists!<br>";
        } else {
            echo "<br>❌ autoload.php NOT found<br>";
        }
    } else {
        echo "❌ Vendor directory does not exist<br>";
    }
} else {
    echo "❌ Xeddo directory does not exist<br>";
}

echo "<br><h3>Current working directory:</h3>";
echo getcwd() . "<br>";

echo "<h3>Files in current directory:</h3>";
$current_items = scandir(__DIR__);
foreach ($current_items as $item) {
    if ($item != '.' && $item != '..') {
        $full_path = __DIR__ . '/' . $item;
        $type = is_dir($full_path) ? '[DIR]' : '[FILE]';
        echo $type . " " . $item . "<br>";
    }
}
?>
