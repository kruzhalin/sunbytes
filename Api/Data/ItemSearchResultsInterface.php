<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Kruzhalin\Sunbytes\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for sunbytes item search results.
 * @api
 */
interface ItemSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get blocks list.
     *
     * @return \Kruzhalin\Sunbytes\Api\Data\ItemInterface[]
     */
    public function getItems();

    /**
     * Set blocks list.
     *
     * @param \Kruzhalin\Sunbytes\Api\Data\ItemInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
