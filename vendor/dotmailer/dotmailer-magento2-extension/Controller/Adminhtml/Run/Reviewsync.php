<?php

namespace Dotdigitalgroup\Email\Controller\Adminhtml\Run;

class Reviewsync extends \Magento\Backend\App\AbstractAction
{
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Dotdigitalgroup\Email\Model\CronFactory
     */
    private $cronFactory;

    /**
     * Reviewsync constructor.
     *
     * @param \Dotdigitalgroup\Email\Model\CronFactory $cronFactory
     * @param \Magento\Backend\App\Action\Context      $context
     */
    public function __construct(
        \Dotdigitalgroup\Email\Model\CronFactory $cronFactory,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->cronFactory    = $cronFactory;
        $this->messageManager = $context->getMessageManager();
        parent::__construct($context);
    }

    /**
     * Refresh suppressed contacts.
     *
     * @return null
     */
    public function execute()
    {
        $result = $this->cronFactory->create()
            ->reviewSync();

        $this->messageManager->addSuccessMessage($result['message']);

        $redirectBack = $this->_redirect->getRefererUrl();
        $this->_redirect($redirectBack);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Dotdigitalgroup_Email::config');
    }
}
