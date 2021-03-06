<?php

use PhpSpellcheck\MisspellingFinder;
use PhpSpellcheck\MisspellingHandler\EchoHandler;
use PhpSpellcheck\Spellchecker\Aspell;

require_once __DIR__ . '/../vendor/autoload.php';

$misspellingFinder = new MisspellingFinder(
    Aspell::create(), // Creates aspell spellchecker pointing to "aspell" as it's binary path
    new EchoHandler() // Handles all the misspellings found by echoing their information
);
/** @var \PhpSpellcheck\Misspelling[]|\Generator $misspellings */
$misspellings = $misspellingFinder->find(
    new \PhpSpellcheck\Source\File(__DIR__.'/../tests/PhpSpellcheck/Tests/Fixtures/Text/mispelling1.txt'),
    ['en_US'],
    ['from' => 'aspell spellchecker']
);
