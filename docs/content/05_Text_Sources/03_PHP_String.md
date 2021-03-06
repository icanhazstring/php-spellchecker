# PHP String

Having a `PHPString` source type seems silly at first but in the context of some
spellcheckers requiring the encoding to function properly
and computation of line numbers and offset characters position,
you might want to attach a specific encoding to your string.

A PHP string is just a sequence of bytes, with no encoding tagged to it whatsoever. String values can come from various sources: the client (over HTTP), a database, a file, or from string literals in your source code. PHP reads all these as byte sequences, and it never extracts any encoding information.

`PHPString` class is meant to circumvent this issue by keeping the encoding information
attached to the sequence of bytes representing your string.

In a UTF-8 encoded php file, if you run this script, you'll see the output difference:

```php
<?php

$misspellingFinder = new MisspellingFinder(
    Aspell::create(), // Creates aspell spellchecker pointing to "aspell" as it's binary path
    new EchoHandler() // Handles all the misspellings found by echoing their information
);

$misspellings = $misspellingFinder->find(
    $string = new \PhpSpellcheck\Source\PHPString(
        mb_convert_encoding('ça éxagèrre', 'windows-1252'),
        'windows-1252'
    ),
    ['fr_FR'],
    [],
    'iso-8859-1' // Aspell will consider the input text encoded in iso-8859-1 which is roughly equivalent to windows-1252
);
// Output:
// word: �xag�rre | line: 1 | offset: 3 | suggestions: exag�rer,exag�re,exag�r�


/** @var \PhpSpellcheck\Misspelling[]|\Generator $misspellings */
$misspellings = $misspellingFinder->find(
    $string = new \PhpSpellcheck\Source\PHPString('ça éxagèrre'),
    ['fr_FR']
);
// Output:
// word: éxagèrre | line: 1 | offset: 3 | suggestions: exagérer,exagère,exagéré
```
