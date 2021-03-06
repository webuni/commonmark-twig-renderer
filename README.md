CommonMark Twig Renderer
========================

[![Latest Stable Version](https://poser.pugx.org/webuni/commonmark-twig-renderer/version)](https://packagist.org/packages/webuni/commonmark-twig-renderer)
[![Build Status](https://travis-ci.org/webuni/commonmark-twig-renderer.svg?branch=master)](https://travis-ci.org/webuni/commonmark-twig-renderer)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/webuni/commonmark-twig-renderer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/webuni/commonmark-twig-renderer/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/4c3133a1-1a5b-4de4-958a-a3cd4b87f10f/mini.png)](https://insight.sensiolabs.com/projects/4c3133a1-1a5b-4de4-958a-a3cd4b87f10f)

This extension allows you to use Twig templates to render CommonMark document.

Installation
------------

This project can be installed via Composer:

    composer require webuni/commonmark-twig-renderer

Usage
-----

```php
    use League\CommonMark\CommonMarkConverter;
    use Webuni\CommonMark\TwigRenderer\CommonMarkTwig;

    $converter = new CommonMarkConverter();
    CommonMarkTwig::setTwigRenderer($converter);

    echo $converter->convertToHtml('# Hello World!');
```

Template customization
-----------------------

In Twig, each Commonmark Node is represented by a Twig block. To customize any part of how a node renders,
you just need to override the appropriate block.

```twig
{% extends 'commonmark.html.twig' %}

{% block header -%}
    {% set content = block('_inline_children') -%}
    <h{{ node.level }}><a name="{{ content|striptags|lower }}"></a>{{ content|raw }}</h{{ node.level }}>
{%- endblock %}
```
