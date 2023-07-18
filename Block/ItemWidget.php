<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Kruzhalin\Sunbytes\Block;

use Kruzhalin\Sunbytes\Api\ItemRepositoryInterface;
use Kruzhalin\Sunbytes\Model\Item;
use Kruzhalin\Sunbytes\Model\ItemFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Widget\Block\BlockInterface;

class ItemWidget extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = 'item_widget.phtml';

    /**
     * Storage for used widgets
     *
     * @var array
     */
    protected static $_widgetUsageMap = [];

    /**
     * @var ItemFactory
     */
    protected ItemFactory $itemFactory;

    /**
     * @var ItemRepositoryInterface
     */
    protected ItemRepositoryInterface $itemRepository;

    /**
     * @var Item
     */
    private Item $item;

    /**
     * @param Context $context
     * @param ItemRepositoryInterface $itemRepository
     * @param array $data
     */
    public function __construct(
        Context                 $context,
        ItemRepositoryInterface $itemRepository,
        array                   $data = []
    ) {
        $this->itemRepository = $itemRepository;
        parent::__construct($context, $data);
    }

    /**
     * Prepare item text and determine whether item output enabled or not.
     *
     * @return $this
     * @throws LocalizedException
     */
    protected function _beforeToHtml()
    {
        parent::_beforeToHtml();
        $itemId = $this->getData('item_id');
        $itemHash = get_class($this) . $itemId;

        if (isset(self::$_widgetUsageMap[$itemHash])) {
            return $this;
        }
        self::$_widgetUsageMap[$itemHash] = true;

        $item = $this->getItem();
        if ($item && $item->isActive()) {
            try {
                $this->setText(
                    $item->getContent()
                );
            } catch (NoSuchEntityException $e) {

            }
        }

        unset(self::$_widgetUsageMap[$itemHash]);
        return $this;
    }

    /**
     * Get item
     *
     * @return Item|null
     * @throws LocalizedException
     */
    private function getItem(): ?Item
    {
        if (!empty($this->item)) {
            return $this->item;
        }

        $itemId = $this->getData('item_id');

        if ($itemId) {
            try {
                /** @var Item $item */
                $this->item = $this->itemRepository->getById((int)$itemId);

                return $this->item;
            } catch (NoSuchEntityException $e) {
            }
        }

        return null;
    }
}
