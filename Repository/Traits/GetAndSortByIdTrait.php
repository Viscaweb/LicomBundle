<?php

namespace Visca\Bundle\LicomBundle\Repository\Traits;

trait GetAndSortByIdTrait
{
    /**
     * Get the entity using the IDs.
     * The entity are then sorted in the same way that the IDs are provided.
     *
     * NOTE: I could'nt make it work using the DQL so after an hour I decided
     * to keep a classic PHP sorter, for now.
     *
     * @param int|int[] $id IDs of the entities
     *
     * @return array
     */
    public function getAndSortById($id)
    {
        $entities = $this->findById($id);

        usort(
            $entities,
            function ($firstEntity, $secondEntity) use ($id) {
                $firstEntityPosition = array_search(
                    $firstEntity->getId(),
                    $id
                );
                $secondEntityPosition = array_search(
                    $secondEntity->getId(),
                    $id
                );

                return $firstEntityPosition > $secondEntityPosition;

            }
        );

        return $entities;
    }
}
