<?php

namespace App\Repositories\Interfaces;

/**
 * Interface AttributeServiceInterface
 * @package App\Services\Interfaces
 */
interface AttributeRepositoryInterface
{
    public function searchAttributes(string $keyword = '', array $option = [], int $languageId);
    public function findAttributeByIdArray(array $attributeArray = [], int $languageId = 0);
}
