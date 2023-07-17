<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Kruzhalin\Sunbytes\Model;

use Kruzhalin\Sunbytes\Api\Data\ItemSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with items search results.
 */
class ItemSearchResults extends SearchResults implements ItemSearchResultsInterface
{
}
