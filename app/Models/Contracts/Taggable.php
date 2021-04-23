<?php

namespace App\Models\Contracts;

/**
 * Interface Taggable
 */
interface Taggable
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getOwnerType();
}
