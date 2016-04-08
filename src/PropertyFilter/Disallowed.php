<?php
namespace Crossjoin\Browscap\PropertyFilter;

use Crossjoin\Browscap\Exception\InvalidArgumentException;

/**
 * Class Disallowed
 *
 * @package Crossjoin\Browscap\PropertyFilter
 * @author Christoph Ziegenberg <ziegenberg@crossjoin.com>
 * @link https://github.com/crossjoin/browscap
 */
class Disallowed implements PropertyFilterInterface
{
    /**
     * @var array
     */
    protected $properties = [];

    /**
     * Disallowed constructor.
     *
     * @param array $properties
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $properties = [])
    {
        $this->setProperties($properties);
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     *
     * @return Disallowed
     * @throws InvalidArgumentException
     */
    public function setProperties(array $properties)
    {
        $this->properties = [];

        foreach ($properties as $property) {
            $this->addProperty($property);
        }

        return $this;
    }

    /**
     * @param string $property
     *
     * @return Disallowed
     * @throws InvalidArgumentException
     */
    public function addProperty($property)
    {
        if (!is_string($property)) {
            throw new InvalidArgumentException(
                "Invalid type '" . gettype($property) . "' for argument 'property'."
            );
        }

        $property = strtolower($property);
        if (!in_array($property, $this->properties, true)) {
            $this->properties[] = $property;
        }

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @throws InvalidArgumentException
     */
    public function isFiltered($property)
    {
        if (!is_string($property)) {
            throw new InvalidArgumentException(
                "Invalid type '" . gettype($property) . "' for argument 'property'."
            );
        }

        return in_array(strtolower($property), $this->getProperties(), true);
    }
}
