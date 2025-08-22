<?php

use Symfony\Component\Finder\Finder;

arch()->preset()->php()->ignoring(['dd', 'dump']);

arch()->preset()->laravel();
arch()->preset()->relaxed();
arch()->preset()->security()->ignoring(['array_rand', 'parse_str', 'mt_rand', 'uniqid', 'sha1']);

arch('annotations')
    ->expect('App')
    ->toUseStrictEquality()
    ->toHavePropertiesDocumented()
    ->toHaveMethodsDocumented();

// Allow Laravel TestCase classes in test directories
arch('allow Laravel test classes')
    ->expect(function () {
        $finder = Finder::create()
            ->in(['tests/Feature', 'tests/Unit'])
            ->files()
            ->name('*.php');

        $validFiles = [];
        foreach ($finder as $file) {
            $content = file_get_contents($file->getRealPath());
            // Allow Laravel TestCase extensions but not raw PHPUnit TestCase
            if (preg_match('/class\s+\w+\s+extends\s+Tests\\\\TestCase/', $content) ||
                preg_match('/class\s+\w+\s+extends\s+TestCase/', $content)) {
                $validFiles[] = $file->getRealPath();
            }
        }

        return $validFiles;
    })
    ->not->toBeEmpty(); // We expect to find Laravel test classes
