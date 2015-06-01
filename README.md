CommonMark Twig Renderer
========================

This extension allows you to use Twig templates to render CommonMark document.

Installation
------------

This project can be installed via Composer:

    composer require webuni/commonmark-twig-renderer
    
Usage
-----

```php
    use League\CommonMark\DocParser;
    use League\CommonMark\Environment;
    use Webuni\CommonMark\CommonMarkTwigExtension;
    use Webuni\CommonMark\TwigRenderer;
    
    $environment = Environment::createCommonMarkEnvironment();
    
    $twig = new Twig_Environment(CommonMarkTwigExtension::createTwigLoader()));
    $twig->addExtension(new CommonMarkTwigExtension());
    
    $parser = new DocParser($environment);
    
    // Here's our sample input
    $markdown = '# Hello World!';
    
    $documentAST = $parser->parse($markdown);
    
    $twigRenderer = new TwigRenderer($environment, $twig);
    echo $twigRenderer->renderBlock($documentAST);
```

Template customization
-----------------------

In Twig, each Commonmark Node is represented by a Twig block. To customize any part of how a node renders,
you just need to override the appropriate block.

```twig
{% extends 'commonmark.html.twig' %}

{% block header -%}
    {% set content = commonmark_render_children(node) -%}
    <h{{ node.level }}><a name="{{ content|striptags|lower }}"></a>{{ content|raw }}</h{{ node.level }}>
{%- endblock %}
```
