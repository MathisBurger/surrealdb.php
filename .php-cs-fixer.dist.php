<?php
$config = new PhpCsFixer\Config();
$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->in(__DIR__);
return $config->setRules([
'@PSR12' => true,
'@Symfony' => true,
])->setFinder($finder);
