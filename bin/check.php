<?php

declare(strict_types=1);

/*
 * Contract of a scaffolded module: no placeholder left, valid PHP and JSON,
 * the PSR-4 entry nwidart/laravel-modules and Pollora read, no service provider.
 *
 * php bin/check.php <scaffolded module directory>
 */

$module = rtrim($argv[1] ?? exit("Usage: php bin/check.php <module directory>\n"), '/');
$failures = [];

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($module, FilesystemIterator::SKIP_DOTS));

foreach ($files as $file) {
    $path = $file->getPathname();

    if (str_contains($path, '/node_modules/')) {
        continue;
    }

    if (preg_match('/%[a-z_]+%/', $path.file_get_contents($path), $match) === 1) {
        $failures[] = "{$path}: placeholder {$match[0]} left";
    }

    if (str_ends_with($path, '.php')) {
        exec('php -l '.escapeshellarg($path).' 2>&1', $output, $exitCode);

        if ($exitCode !== 0) {
            $failures[] = "{$path}: ".implode(' ', $output);
        }
    }

    if (str_ends_with($path, '.json') && json_decode((string) file_get_contents($path)) === null) {
        $failures[] = "{$path}: invalid JSON";
    }
}

$manifest = json_decode((string) file_get_contents($module.'/module.json'), true);
$composer = json_decode((string) file_get_contents($module.'/composer.json'), true);
$name = basename($module);

if (($manifest['name'] ?? null) !== $name) {
    $failures[] = "module.json: name should be {$name}";
}

if (($manifest['providers'] ?? null) !== []) {
    $failures[] = 'module.json: providers should be empty, discovery registers the classes';
}

if (($composer['autoload']['psr-4']['Modules\\'.$name.'\\'] ?? null) !== 'app/') {
    $failures[] = "composer.json: Modules\\{$name}\\ should map onto app/";
}

if (! is_file($module."/app/Cms/Hooks/{$name}Hooks.php")) {
    $failures[] = "app/Cms/Hooks/{$name}Hooks.php is missing";
}

if ($failures !== []) {
    fwrite(STDERR, implode("\n", $failures)."\n");
    exit(1);
}

echo "{$name}: contract holds\n";
