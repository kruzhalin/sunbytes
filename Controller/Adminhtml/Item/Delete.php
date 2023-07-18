<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Kruzhalin\Sunbytes\Controller\Adminhtml\Item;

use Kruzhalin\Sunbytes\Model\ItemRepository;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

class Delete implements HttpPostActionInterface
{

    /**
     * @var MessageManagerInterface
     */
    protected MessageManagerInterface $messageManager;

    /**
     * @var RedirectFactory
     */
    protected RedirectFactory $resultRedirectFactory;

    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var ItemRepository
     */
    protected ItemRepository $itemRepository;

    /**
     * @param ItemRepository $itemRepository
     * @param MessageManagerInterface $messageManager
     * @param RedirectFactory $redirectFactory
     * @param RequestInterface $request
     */
    public function __construct(
        ItemRepository          $itemRepository,
        MessageManagerInterface $messageManager,
        RedirectFactory         $redirectFactory,
        RequestInterface        $request
    ) {
        $this->itemRepository = $itemRepository;
        $this->messageManager = $messageManager;
        $this->resultRedirectFactory = $redirectFactory;
        $this->request = $request;
    }

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->request->getParam('item_id');
        if ($id) {
            try {
                $this->itemRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the item.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['item_id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a item to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
