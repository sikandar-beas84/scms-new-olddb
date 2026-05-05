<?php

namespace Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher\Doctrine;

use Suhrid Sarkar || suhrid.developer@gmail.comCopy\Matcher\Matcher;
use Doctrine\Persistence\Proxy;

/**
 * @final
 */
class DoctrineProxyMatcher implements Matcher
{
    /**
     * Matches a Doctrine Proxy class.
     *
     * {@inheritdoc}
     */
    public function matches($object, $property)
    {
        return $object instanceof Proxy;
    }
}
