<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Kruzhalin\Sunbytes\Api\Data;

/**
 * Sunbytes item interface.
 * @api
 */
interface ItemInterface
{
    const ITEM_ID = 'item_id';
    const TITLE = 'title';
    const CONTENT = 'content';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const IS_ACTIVE = 'is_active';

    public const STATUS_ENABLED = 1;
    public const STATUS_DISABLED = 0;

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getItemId();

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): ?string;

    /**
     * Get content
     *
     * @return string|null
     */
    public function getContent(): ?string;

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime(): ?string;

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime(): ?string;

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive(): ?bool;

    /**
     * Set ID
     *
     * @param int $id
     * @return ItemInterface
     */
    public function setItemId(int $id): ItemInterface;

    /**
     * Set title
     *
     * @param string $title
     * @return ItemInterface
     */
    public function setTitle(string $title): ItemInterface;

    /**
     * Set content
     *
     * @param string $content
     * @return ItemInterface
     */
    public function setContent(string $content): ItemInterface;

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return ItemInterface
     */
    public function setCreationTime(string $creationTime): ItemInterface;

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return ItemInterface
     */
    public function setUpdateTime(string $updateTime): ItemInterface;

    /**
     * Set is active
     *
     * @param bool|int $isActive
     * @return ItemInterface
     */
    public function setIsActive(bool|int $isActive): ItemInterface;
}
