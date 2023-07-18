<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Kruzhalin\Sunbytes\Controller\Adminhtml\Item;

use Kruzhalin\Sunbytes\Api\Data\ItemInterface;
use Kruzhalin\Sunbytes\Model\ItemRepository;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Kruzhalin\Sunbytes\Api\ItemRepositoryInterface;
use Kruzhalin\Sunbytes\Model\Item;
use Kruzhalin\Sunbytes\Model\ItemFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;

/**
 * Save CMS item action.
 */
class Save implements HttpPostActionInterface
{
    /**
     * @var MessageManagerInterface
     */
    protected MessageManagerInterface $messageManager;

    /**
     * @var ItemFactory
     */
    private ItemFactory $itemFactory;

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
     * @param MessageManagerInterface $messageManager
     * @param ItemFactory $itemFactory
     * @param ItemRepositoryInterface $itemRepository
     * @param RedirectFactory $resultRedirectFactory
     * @param RequestInterface $request
     */
    public function __construct(
        MessageManagerInterface $messageManager,
        ItemFactory             $itemFactory,
        ItemRepositoryInterface $itemRepository,
        RedirectFactory         $resultRedirectFactory,
        RequestInterface        $request
    ) {
        $this->messageManager = $messageManager;
        $this->itemFactory = $itemFactory;
        $this->itemRepository = $itemRepository;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->request = $request;
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->request->getPostValue();
        if ($data) {
            if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = ItemInterface::STATUS_ENABLED;
            }
            if (empty($data['item_id'])) {
                $data['item_id'] = null;
            }

            $model = $this->itemFactory->create();

            $id = $this->request->getParam('item_id');
            if ($id) {
                try {
                    $model = $this->itemRepository->getById((int)$id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This item no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->itemRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the item.'));
                return $this->processBlockReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the item.'));
            }

            return $resultRedirect->setPath('*/*/edit', ['item_id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the item return
     *
     * @param Item $model
     * @param array $data
     * @param ResultInterface $resultRedirect
     * @return ResultInterface
     * @throws LocalizedException
     */
    private function processBlockReturn($model, $data, $resultRedirect): ResultInterface
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/edit', ['item_id' => $model->getId()]);
        } elseif ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect;
    }
}
