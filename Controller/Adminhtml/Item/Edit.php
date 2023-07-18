<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Kruzhalin\Sunbytes\Controller\Adminhtml\Item;

use Kruzhalin\Sunbytes\Model\ItemRepository;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Edit item action.
 */
class Edit implements HttpGetActionInterface
{
    /**
     * @var MessageManagerInterface
     */
    protected MessageManagerInterface $messageManager;
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;

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
     * @param PageFactory $resultPageFactory
     * @param ItemRepository $itemRepository
     * @param MessageManagerInterface $messageManager
     * @param RedirectFactory $redirectFactory
     * @param RequestInterface $request
     */
    public function __construct(
        PageFactory             $resultPageFactory,
        ItemRepository          $itemRepository,
        MessageManagerInterface $messageManager,
        RedirectFactory         $redirectFactory,
        RequestInterface        $request
    ) {
        $this->itemRepository = $itemRepository;
        $this->messageManager = $messageManager;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultRedirectFactory = $redirectFactory;
        $this->request = $request;
    }

    /**
     * Edit item
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $id = $this->request->getParam('item_id');
        $model = null;
        if ($id) {
            $model = $this->itemRepository->getById((int)$id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This item no longer exists.'));
                /** @var Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        $resultPage->getConfig()->getTitle()->prepend(__('Items'));
        $title = __('New Item');
        if ($model !== null) {
            $title = $model->getTitle();
        }
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
