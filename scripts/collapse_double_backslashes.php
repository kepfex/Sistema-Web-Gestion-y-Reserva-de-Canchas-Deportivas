<?php
$dir = __DIR__ . '/../tests/Feature';
$files = glob($dir . '/*.php');
$updated = 0;
foreach ($files as $file) {
    $content = file_get_contents($file);
    $new = str_replace('\\\\', '\\', $content);
    // also collapse any remaining double backslashes
    $new = str_replace('\\', '\\', $new);
    if ($new !== $content) {
        file_put_contents($file, $new);
        echo "Collapsed: {$file}\n";
        $updated++;
    }
}
echo "Done. Files updated: {$updated}\n";
