<?php
$dir = __DIR__ . '/../tests/Feature';
$files = glob($dir . '/*.php');
$updated = 0;
foreach ($files as $file) {
    $content = file_get_contents($file);
    $new = str_replace('class_exists(App\\', 'class_exists(\\App\\', $content);
    if ($new !== $content) {
        file_put_contents($file, $new);
        echo "Fixed class_exists in: {$file}\n";
        $updated++;
    }
}
echo "Done. Files updated: {$updated}\n";
