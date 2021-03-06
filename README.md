# ScyLabs Hook

Dynamic templating hook system for symfony.

## Installation

To install this package, use  [composer](https://getcomposer.org/) .

```bash
composer require scylabs/hook-bundle
```

## Usage

The operation is very simple. First, you need to create entry points in your template, then connect PHP classes to these entry points. <br/>
I will explain in detail.

### Create an entry point to connect hooks in twig
Okay , for the rest of the tutorial, we will say that the "entry point" is a door. <br/>
You can use the TwigExtension provided in this package.<br/>
The extension function has two parameters.
```php
public function showHook(string $template,string $hookName)
```
The first parameter is the target template NameSpace. Ex : layout.html.twig<br/>
The second parameter is the hook name and it is used to connect PHP classes in this door.
<br/><br>
You can send _self in first parameter. _self is the current template NameSpace <br/>
It is important to add "raw" filter to interprete Hook's html.
```twig
{{ showHook(_self,'my_custom_hook')) | raw }}

```

### You don't use twig ? 
If you don't use twig , you can tell directly HooksFounder Service.<br/>
It works exactly like the extension, except that it directly returns an array of instantiated Hooks objects instead of hooks contents.

### Connect Hooks to an  entry point (door).
You can create an infinity of doors and an infinity of hooks to connect this doors.
<br/>
To connect a hook to one door , you need to create a PHP class that extends AbstractHook class<br/>
I'ts the minimal code to connect a hook to a door. PS : You can connect one hook to many doors.

```php
<?php

namespace App\Hook;


use ScyLabs\HookBundle\Model\AbstractHook;

class MyHook extends AbstractHook
{

    // name of the doors where the hook will be injected
    public function getNames(): array {
        return [
            'my_custom_hook'
        ];
    }

    // A priority 0 hook will be placed before a priority 1 hook
    public function getPriority(): int {
        return 0;
    }

    // Hook result. The result are injected in door template. You can also do anything you sant in this function.
    public function showHook() {
        // $this->render() controller function equivalent.
        return $this->render('hook/menu.html.twig',[]);
    }
}

```
### Last step : Add your Hook directory to the Container
```yaml
# config/services.yaml
services: 
    App\Hook\:
        resource: '../src/Hook/*'
        public: true
```
### I'ts done.
You can also show any hooks in your controller result in your SymfonyToolbar.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
