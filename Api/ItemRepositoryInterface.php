<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Kruzhalin\Sunbytes\Api;

/**
 * Sunbytes Item CRUD interface.
 * @api
 */
interface ItemRepositoryInterface
{
    /**
     * Save item.
     *
     * @param \Kruzhalin\Sunbytes\Api\Data\ItemInterface $item
     * @return \Kruzhalin\Sunbytes\Api\Data\ItemInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\ItemInterface $item): Data\ItemInterface;

    /**
     * Retrieve item.
     *
     * @param int $itemId
     * @return \Kruzhalin\Sunbytes\Api\Data\ItemInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $itemId): Data\ItemInterface;

    /**
     * Retrieve items matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Kruzhalin\Sunbytes\Api\Data\ItemSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria): \Kruzhalin\Sunbytes\Api\Data\ItemSearchResultsInterface;

    /**
     * Delete item.
     *
     * @param \Kruzhalin\Sunbytes\Api\Data\ItemInterface $item
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\ItemInterface $item): bool;

    /**
     * Delete item by ID.
     *
     * @param string $itemId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($itemId): bool;
}
