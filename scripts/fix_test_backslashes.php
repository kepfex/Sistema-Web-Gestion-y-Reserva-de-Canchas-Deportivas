<?php
$dir = __DIR__ . '/../tests/Feature';
$files = glob($dir . '/*.php');
$updated = 0;
foreach ($files as $file) {
    $content = file_get_contents($file);
    $new = str_replace('App\\\\Livewire\\\\', 'App\\Livewire\\', $content);
    // Also replace occurrences that may have single-escaped sequences in file as double slashes in PHP string
    $new = str_replace('App\\\\Livewire\\', 'App\\Livewire\\', $new);
    if ($new !== $content) {
        file_put_contents($file, $new);
        echo "Updated: {$file}\n";
        $updated++;
    }
}
echo "Done. Files updated: {$updated}\n";
