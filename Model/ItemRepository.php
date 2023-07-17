<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Kruzhalin\Sunbytes\Model;

use Kruzhalin\Sunbytes\Api\Data;
use Kruzhalin\Sunbytes\Api\Data\ItemSearchResultsInterface;
use Kruzhalin\Sunbytes\Api\ItemRepositoryInterface;
use Kruzhalin\Sunbytes\Model\ResourceModel\Item as ResourceItem;
use Magento\Framework\Api\SearchCriteriaInterface;
use Kruzhalin\Sunbytes\Model\ResourceModel\Item\CollectionFactory as ItemCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Item repository implementation
 */
class ItemRepository implements ItemRepositoryInterface
{
    /**
     * @var ResourceItem
     */
    protected $resource;

    /**
     * @var ItemFactory
     */
    protected $itemFactory;

    /**
     * @var ItemCollectionFactory
     */
    protected $itemCollectionFactory;

    /**
     * @var Data\ItemSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @param ResourceItem $resource
     * @param \Kruzhalin\Sunbytes\Model\ItemFactory $itemFactory
     * @param ItemCollectionFactory $itemCollectionFactory
     * @param Data\ItemSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceItem $resource,
        ItemFactory $itemFactory,
        ItemCollectionFactory $itemCollectionFactory,
        Data\ItemSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->itemFactory = $itemFactory;
        $this->itemCollectionFactory = $itemCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }
    /**
     * Save item.
     *
     * @param \Kruzhalin\Sunbytes\Api\Data\ItemInterface $item
     * @return \Kruzhalin\Sunbytes\Api\Data\ItemInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\ItemInterface $item): Data\ItemInterface
    {
        try {
            $this->resource->save($item);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $item;
    }

    /**
     * Retrieve item.
     *
     * @param int $itemId
     * @return \Kruzhalin\Sunbytes\Api\Data\ItemInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $itemId): Data\ItemInterface
    {
        $item = $this->itemFactory->create();
        $this->resource->load($item, $itemId);
        if (!$item->getId()) {
            throw new NoSuchEntityException(__('The item with the "%1" ID doesn\'t exist.', $itemId));
        }
        return $item;
    }

    /**
     * Retrieve items matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return ItemSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ItemSearchResultsInterface
    {
        $collection = $this->itemCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var Data\ItemSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete item.
     *
     * @param \Kruzhalin\Sunbytes\Api\Data\ItemInterface $item
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\ItemInterface $item): bool
    {
        try {
            $this->resource->delete($item);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete item by ID.
     *
     * @param string $itemId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($itemId): bool
    {
        return $this->delete($this->getById((int)$itemId));
    }
}
