<?php
$config = new PhpCsFixer\Config();
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor');
return $config->setRules([
'@PSR12' => true,
'@Symfony' => true,
])->setFinder($finder);
