<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Kruzhalin\Sunbytes\Model;

use Kruzhalin\Sunbytes\Api\Data\ItemInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Sunbytes item model
 */
class Item extends AbstractModel implements ItemInterface
{
    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'sunbytes_item';

    /**
     * @var string
     */
    protected $_idFieldName = 'item_id';

    /**
     * Construct.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Kruzhalin\Sunbytes\Model\ResourceModel\Item::class);
    }

    /**
     * Retrieve item id
     *
     * @return int|null
     */
    public function getItemId()
    {
        return $this->getData(self::ITEM_ID);
    }

    /**
     * Retrieve item title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Retrieve item content
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Retrieve item creation time
     *
     * @return string|null
     */
    public function getCreationTime(): ?string
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * Retrieve item update time
     *
     * @return string
     */
    public function getUpdateTime(): ?string
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function isActive(): ?bool
    {
        return (bool)$this->getData(self::IS_ACTIVE);
    }

    /**
     * Set ID
     *
     * @param $itemId
     * @return ItemInterface
     */
    public function setItemId(int $itemId): ItemInterface
    {
        return $this->setData(self::ITEM_ID, $itemId);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ItemInterface
     */
    public function setTitle($title): ItemInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Set content
     *
     * @param string $content
     * @return ItemInterface
     */
    public function setContent($content): ItemInterface
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return ItemInterface
     */
    public function setCreationTime($creationTime): ItemInterface
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return ItemInterface
     */
    public function setUpdateTime($updateTime): ItemInterface
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return ItemInterface
     */
    public function setIsActive($isActive): ItemInterface
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Prepare item's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses(): array
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}
