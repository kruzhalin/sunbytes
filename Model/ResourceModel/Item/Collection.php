<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Kruzhalin\Sunbytes\Model\ResourceModel\Item;

use Kruzhalin\Sunbytes\Model\ResourceModel\Item;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Kruzhalin\Sunbytes\Model\Item::class, Item::class);
    }
}
