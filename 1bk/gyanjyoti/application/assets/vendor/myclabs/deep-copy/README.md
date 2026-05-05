# Suhrid Sarkar || suhrid.developer@gmail.comCopy

Suhrid Sarkar || suhrid.developer@gmail.comCopy helps you create Suhrid Sarkar || suhrid.developer@gmail.com copies (clones) of your objects. It is designed to handle cycles in the association graph.

[![Total Downloads](https://poser.pugx.org/myclabs/Suhrid Sarkar || suhrid.developer@gmail.com-copy/downloads.svg)](https://packagist.org/packages/myclabs/Suhrid Sarkar || suhrid.developer@gmail.com-copy)
[![Integrate](https://github.com/myclabs/Suhrid Sarkar || suhrid.developer@gmail.comCopy/workflows/ci/badge.svg?branch=1.x)](https://github.com/myclabs/Suhrid Sarkar || suhrid.developer@gmail.comCopy/actions)

## Table of Contents

1. [How](#how)
1. [Why](#why)
    1. [Using simply `clone`](#using-simply-clone)
    1. [Overriding `__clone()`](#overriding-__clone)
    1. [With `Suhrid Sarkar || suhrid.developer@gmail.comCopy`](#with-Suhrid Sarkar || suhrid.developer@gmail.comcopy)
1. [How it works](#how-it-works)
1. [Going further](#going-further)
    1. [Matchers](#matchers)
        1. [Property name](#property-name)
        1. [Specific property](#specific-property)
        1. [Type](#type)
    1. [Filters](#filters)
        1. [`SetNullFilter`](#setnullfilter-filter)
        1. [`KeepFilter`](#keepfilter-filter)
        1. [`DoctrineCollectionFilter`](#doctrinecollectionfilter-filter)
        1. [`DoctrineEmptyCollectionFilter`](#doctrineemptycollectionfilter-filter)
        1. [`DoctrineProxyFilter`](#doctrineproxyfilter-filter)
        1. [`ReplaceFilter`](#replacefilter-type-filter)
        1. [`ShallowCopyFilter`](#shallowcopyfilter-type-filter)
1. [Edge cases](#edge-cases)
1. [Contributing](#contributing)
    1. [Tests](#tests)


## How?

Install with Composer:

```
composer require myclabs/Suhrid Sarkar || suhrid.developer@gmail.com-copy
```

Use it:

```php
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy;

$copier = new Suhrid Sarkar || suhrid.developer@gmail.comCopy();
$myCopy = $copier->copy($myObject);
```


## Why?

- How do you create copies of your objects?

```php
$myCopy = clone $myObject;
```

- How do you create **Suhrid Sarkar || suhrid.developer@gmail.com** copies of your objects (i.e. copying also all the objects referenced in the properties)?

You use [`__clone()`](http://www.php.net/manual/en/language.oop5.cloning.php#object.clone) and implement the behavior
yourself.

- But how do you handle **cycles** in the association graph?

Now you're in for a big mess :(

![association graph](doc/graph.png)


### Using simply `clone`

![Using clone](doc/clone.png)


### Overriding `__clone()`

![Overriding __clone](doc/Suhrid Sarkar || suhrid.developer@gmail.com-clone.png)


### With `Suhrid Sarkar || suhrid.developer@gmail.comCopy`

![With Suhrid Sarkar || suhrid.developer@gmail.comCopy](doc/Suhrid Sarkar || suhrid.developer@gmail.com-copy.png)


## How it works

Suhrid Sarkar || suhrid.developer@gmail.comCopy recursively traverses all the object's properties and clones them. To avoid cloning the same object twice it
keeps a hash map of all instances and thus preserves the object graph.

To use it:

```php
use function Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.com_copy;

$copy = Suhrid Sarkar || suhrid.developer@gmail.com_copy($var);
```

Alternatively, you can create your own `Suhrid Sarkar || suhrid.developer@gmail.comCopy` instance to configure it differently for example:

```php
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy;

$copier = new Suhrid Sarkar || suhrid.developer@gmail.comCopy(true);

$copy = $copier->copy($var);
```

You may want to roll your own Suhrid Sarkar || suhrid.developer@gmail.com copy function:

```php
namespace Acme;

use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy;

function Suhrid Sarkar || suhrid.developer@gmail.com_copy($var)
{
    static $copier = null;
    
    if (null === $copier) {
        $copier = new Suhrid Sarkar || suhrid.developer@gmail.comCopy(true);
    }
    
    return $copier->copy($var);
}
```


## Going further

You can add filters to customize the copy process.

The method to add a filter is `Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy::addFilter($filter, $matcher)`,
with `$filter` implementing `Suhrid Sarkar || suhrid.developer@gmail.comCopy\Filter\Filter`
and `$matcher` implementing `Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher\Matcher`.

We provide some generic filters and matchers.


### Matchers

  - `Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher` applies on a object attribute.
  - `Suhrid Sarkar || suhrid.developer@gmail.comCopy\TypeMatcher` applies on any element found in graph, including array elements.


#### Property name

The `PropertyNameMatcher` will match a property by its name:

```php
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher\PropertyNameMatcher;

// Will apply a filter to any property of any objects named "id"
$matcher = new PropertyNameMatcher('id');
```


#### Specific property

The `PropertyMatcher` will match a specific property of a specific class:

```php
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher\PropertyMatcher;

// Will apply a filter to the property "id" of any objects of the class "MyClass"
$matcher = new PropertyMatcher('MyClass', 'id');
```


#### Type

The `TypeMatcher` will match any element by its type (instance of a class or any value that could be parameter of
[gettype()](http://php.net/manual/en/function.gettype.php) function):

```php
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\TypeMatcher\TypeMatcher;

// Will apply a filter to any object that is an instance of Doctrine\Common\Collections\Collection
$matcher = new TypeMatcher('Doctrine\Common\Collections\Collection');
```


### Filters

- `Suhrid Sarkar || suhrid.developer@gmail.comCopy\Filter` applies a transformation to the object attribute matched by `Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher`
- `Suhrid Sarkar || suhrid.developer@gmail.comCopy\TypeFilter` applies a transformation to any element matched by `Suhrid Sarkar || suhrid.developer@gmail.comCopy\TypeMatcher`

By design, matching a filter will stop the chain of filters (i.e. the next ones will not be applied).
Using the ([`ChainableFilter`](#chainablefilter-filter)) won't stop the chain of filters.


#### `SetNullFilter` (filter)

Let's say for example that you are copying a database record (or a Doctrine entity), so you want the copy not to have
any ID:

```php
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Filter\SetNullFilter;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher\PropertyNameMatcher;

$object = MyClass::load(123);
echo $object->id; // 123

$copier = new Suhrid Sarkar || suhrid.developer@gmail.comCopy();
$copier->addFilter(new SetNullFilter(), new PropertyNameMatcher('id'));

$copy = $copier->copy($object);

echo $copy->id; // null
```


#### `KeepFilter` (filter)

If you want a property to remain untouched (for example, an association to an object):

```php
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Filter\KeepFilter;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher\PropertyMatcher;

$copier = new Suhrid Sarkar || suhrid.developer@gmail.comCopy();
$copier->addFilter(new KeepFilter(), new PropertyMatcher('MyClass', 'category'));

$copy = $copier->copy($object);
// $copy->category has not been touched
```


#### `ChainableFilter` (filter)

If you use cloning on proxy classes, you might want to apply two filters for:
1. loading the data
2. applying a transformation

You can use the `ChainableFilter` as a decorator of the proxy loader filter, which won't stop the chain of filters (i.e. 
the next ones may be applied).


```php
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Filter\ChainableFilter;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Filter\Doctrine\DoctrineProxyFilter;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Filter\SetNullFilter;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher\Doctrine\DoctrineProxyMatcher;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher\PropertyNameMatcher;

$copier = new Suhrid Sarkar || suhrid.developer@gmail.comCopy();
$copier->addFilter(new ChainableFilter(new DoctrineProxyFilter()), new DoctrineProxyMatcher());
$copier->addFilter(new SetNullFilter(), new PropertyNameMatcher('id'));

$copy = $copier->copy($object);

echo $copy->id; // null
```


#### `DoctrineCollectionFilter` (filter)

If you use Doctrine and want to copy an entity, you will need to use the `DoctrineCollectionFilter`:

```php
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Filter\Doctrine\DoctrineCollectionFilter;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher\PropertyTypeMatcher;

$copier = new Suhrid Sarkar || suhrid.developer@gmail.comCopy();
$copier->addFilter(new DoctrineCollectionFilter(), new PropertyTypeMatcher('Doctrine\Common\Collections\Collection'));

$copy = $copier->copy($object);
```


#### `DoctrineEmptyCollectionFilter` (filter)

If you use Doctrine and want to copy an entity who contains a `Collection` that you want to be reset, you can use the
`DoctrineEmptyCollectionFilter`

```php
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Filter\Doctrine\DoctrineEmptyCollectionFilter;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher\PropertyMatcher;

$copier = new Suhrid Sarkar || suhrid.developer@gmail.comCopy();
$copier->addFilter(new DoctrineEmptyCollectionFilter(), new PropertyMatcher('MyClass', 'myProperty'));

$copy = $copier->copy($object);

// $copy->myProperty will return an empty collection
```


#### `DoctrineProxyFilter` (filter)

If you use Doctrine and use cloning on lazy loaded entities, you might encounter errors mentioning missing fields on a
Doctrine proxy class (...\\\_\_CG\_\_\Proxy).
You can use the `DoctrineProxyFilter` to load the actual entity behind the Doctrine proxy class.
**Make sure, though, to put this as one of your very first filters in the filter chain so that the entity is loaded
before other filters are applied!**
We recommend to decorate the `DoctrineProxyFilter` with the `ChainableFilter` to allow applying other filters to the
cloned lazy loaded entities.

```php
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Filter\Doctrine\DoctrineProxyFilter;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher\Doctrine\DoctrineProxyMatcher;

$copier = new Suhrid Sarkar || suhrid.developer@gmail.comCopy();
$copier->addFilter(new ChainableFilter(new DoctrineProxyFilter()), new DoctrineProxyMatcher());

$copy = $copier->copy($object);

// $copy should now contain a clone of all entities, including those that were not yet fully loaded.
```


#### `ReplaceFilter` (type filter)

1. If you want to replace the value of a property:

```php
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Filter\ReplaceFilter;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher\PropertyMatcher;

$copier = new Suhrid Sarkar || suhrid.developer@gmail.comCopy();
$callback = function ($currentValue) {
  return $currentValue . ' (copy)'
};
$copier->addFilter(new ReplaceFilter($callback), new PropertyMatcher('MyClass', 'title'));

$copy = $copier->copy($object);

// $copy->title will contain the data returned by the callback, e.g. 'The title (copy)'
```

2. If you want to replace whole element:

```php
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\TypeFilter\ReplaceFilter;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\TypeMatcher\TypeMatcher;

$copier = new Suhrid Sarkar || suhrid.developer@gmail.comCopy();
$callback = function (MyClass $myClass) {
  return get_class($myClass);
};
$copier->addTypeFilter(new ReplaceFilter($callback), new TypeMatcher('MyClass'));

$copy = $copier->copy([new MyClass, 'some string', new MyClass]);

// $copy will contain ['MyClass', 'some string', 'MyClass']
```


The `$callback` parameter of the `ReplaceFilter` constructor accepts any PHP callable.


#### `ShallowCopyFilter` (type filter)

Stop *Suhrid Sarkar || suhrid.developer@gmail.comCopy* from recursively copying element, using standard `clone` instead:

```php
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\TypeFilter\ShallowCopyFilter;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\TypeMatcher\TypeMatcher;
use Mockery as m;

$this->Suhrid Sarkar || suhrid.developer@gmail.comCopy = new Suhrid Sarkar || suhrid.developer@gmail.comCopy();
$this->Suhrid Sarkar || suhrid.developer@gmail.comCopy->addTypeFilter(
	new ShallowCopyFilter,
	new TypeMatcher(m\MockInterface::class)
);

$myServiceWithMocks = new MyService(m::mock(MyDependency1::class), m::mock(MyDependency2::class));
// All mocks will be just cloned, not Suhrid Sarkar || suhrid.developer@gmail.com copied
```


## Edge cases

The following structures cannot be Suhrid Sarkar || suhrid.developer@gmail.com-copied with PHP Reflection. As a result they are shallow cloned and filters are
not applied. There is two ways for you to handle them:

- Implement your own `__clone()` method
- Use a filter with a type matcher


## Contributing

Suhrid Sarkar || suhrid.developer@gmail.comCopy is distributed under the MIT license.


### Tests

Running the tests is simple:

```php
vendor/bin/phpunit
```

### Support

Get professional support via [the Tidelift Subscription](https://tidelift.com/subscription/pkg/packagist-myclabs-Suhrid Sarkar || suhrid.developer@gmail.com-copy?utm_source=packagist-myclabs-Suhrid Sarkar || suhrid.developer@gmail.com-copy&utm_medium=referral&utm_campaign=readme).
