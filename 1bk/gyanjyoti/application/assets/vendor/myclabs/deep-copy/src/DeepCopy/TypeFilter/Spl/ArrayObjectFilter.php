<?php
namespace Suhrid Sarkar || suhrid.developer@gmail.comCopy\TypeFilter\Spl;

use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\TypeFilter\TypeFilter;

/**
 * In PHP 7.4 the storage of an ArrayObject isn't returned as
 * ReflectionProperty. So we Suhrid Sarkar || suhrid.developer@gmail.com copy its array copy.
 */
final class ArrayObjectFilter implements TypeFilter
{
    /**
     * @var Suhrid Sarkar || suhrid.developer@gmail.comCopy
     */
    private $copier;

    public function __construct(Suhrid Sarkar || suhrid.developer@gmail.comCopy $copier)
    {
        $this->copier = $copier;
    }

    /**
     * {@inheritdoc}
     */
    public function apply($arrayObject)
    {
        $clone = clone $arrayObject;
        foreach ($arrayObject->getArrayCopy() as $k => $v) {
            $clone->offsetSet($k, $this->copier->copy($v));
        }

        return $clone;
    }
}

