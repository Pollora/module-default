<?php

declare(strict_types=1);

/*
 * Write this template out as `pollora:make:module` does: placeholders replaced
 * in contents and file names, `.stub` renamed `.php`, bin/ and .github/ left out.
 *
 * php bin/scaffold.php <target directory> [Name]
 */

$source = dirname(__DIR__);
$target = $argv[1] ?? exit("Usage: php bin/scaffold.php <target directory> [Name]\n");
$name = $argv[2] ?? 'Crm';
$slug = strtolower((string) preg_replace('/(?<!^)[A-Z]/', '-$0', $name));

$replacements = [
    '%module_name%' => $name,
    '%module_slug%' => $slug,
    '%module_namespace%' => 'Modules\\'.$name,
    '%module_namespace_json%' => 'Modules\\\\'.$name,
    '%module_description%' => 'The '.$name.' module',
    '%module_author%' => 'Pollora',
];

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS));

foreach ($files as $file) {
    $relative = substr($file->getPathname(), strlen($source) + 1);

    if (preg_match('#^(\.git|bin|\.github|node_modules)(/|$)#', $relative) === 1) {
        continue;
    }

    $destination = $target.'/'.strtr($relative, $replacements);
    $destination = (string) preg_replace('/\.stub$/', '.php', $destination);

    if (! is_dir(dirname($destination))) {
        mkdir(dirname($destination), 0755, true);
    }

    file_put_contents($destination, strtr((string) file_get_contents($file->getPathname()), $replacements));
}

echo "Scaffolded {$name} into {$target}\n";
