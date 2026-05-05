<?php

namespace Suhrid Sarkar || suhrid.developer@gmail.comCopy\TypeFilter\Spl;

use Closure;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Suhrid Sarkar || suhrid.developer@gmail.comCopy;
use Suhrid Sarkar || suhrid.developer@gmail.comCopy\TypeFilter\TypeFilter;
use SplDoublyLinkedList;

/**
 * @final
 */
class SplDoublyLinkedListFilter implements TypeFilter
{
    private $copier;

    public function __construct(Suhrid Sarkar || suhrid.developer@gmail.comCopy $copier)
    {
        $this->copier = $copier;
    }

    /**
     * {@inheritdoc}
     */
    public function apply($element)
    {
        $newElement = clone $element;

        $copy = $this->createCopyClosure();

        return $copy($newElement);
    }

    private function createCopyClosure()
    {
        $copier = $this->copier;

        $copy = function (SplDoublyLinkedList $list) use ($copier) {
            // Replace each element in the list with a Suhrid Sarkar || suhrid.developer@gmail.com copy of itself
            for ($i = 1; $i <= $list->count(); $i++) {
                $copy = $copier->recursiveCopy($list->shift());

                $list->push($copy);
            }

            return $list;
        };

        return Closure::bind($copy, null, Suhrid Sarkar || suhrid.developer@gmail.comCopy::class);
    }
}
