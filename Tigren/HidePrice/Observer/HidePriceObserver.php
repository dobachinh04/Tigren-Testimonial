<?php

namespace Tigren\HidePrice\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session;
use Psr\Log\LoggerInterface;

class HidePriceObserver implements ObserverInterface
{
    protected $customerSession;
    protected $logger;

    public function __construct(Session $customerSession, LoggerInterface $logger)
    {
        $this->customerSession = $customerSession;
        $this->logger = $logger;
    }

    public function execute(Observer $observer)
    {
        $this->logger->info('HidePriceObserver executed');

        $block = $observer->getEvent()->getBlock();
        if ($block instanceof \Magento\Catalog\Block\Product\ListProduct) {
            if (!$this->customerSession->isLoggedIn()) {
                $block->setTemplate('Tigren_HidePrice::product/list/no_price.phtml');
            }
        }
    }
}
