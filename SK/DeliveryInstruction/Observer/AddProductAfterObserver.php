<?php

namespace SK\DeliveryInstruction\Observer;

use Magento\Framework\Event\ObserverInterface;

class AddProductAfterObserver implements ObserverInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @codeCoverageIgnore
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->_checkoutSession = $checkoutSession;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $deliveryInstruction = $observer->getEvent()->getRequest()->getParam('delivery_instruction');
        if (!empty($deliveryInstruction)) {
            /** @var \Magento\Quote\Model\Quote\Item $item */
            $item = $this->_checkoutSession->getQuote()->getItemByProduct($product);
            $item->setDeliveryInstruction($deliveryInstruction);
            $item->save();
        }
    }
}
