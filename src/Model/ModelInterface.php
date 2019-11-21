<?php declare(strict_types=1);

namespace Becklyn\RadBundle\Model;

/**
 * Interface for base class for all models.
 */
interface ModelInterface
{
    /**
     * Marks the entity for adding.
     *
     * @return $this
     */
    public function add (object $entity) : self;


    /**
     * Updates the given entity.
     *
     * @return $this
     */
    public function update (object $entity) : self;


    /**
     * Marks the entity for removal.
     *
     * @return $this
     */
    public function remove (object $entity) : self;


    /**
     * Flushes the entity changes to the database.
     *
     * @return $this
     */
    public function flush () : self;
}
