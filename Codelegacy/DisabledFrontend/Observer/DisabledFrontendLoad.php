<?php
/* Glory to Ukraine! Glory to the heros! */
namespace Codelegacy\DisabledFrontend\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ActionFlag;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Backend\Helper\Data;
use Magento\Framework\Event\Observer;

class DisabledFrontendLoad implements ObserverInterface
{

    /**
     * @var \Magento\Framework\App\ActionFlag
     */
    protected $actionFlag;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magento\Framework\App\Response\RedirectInterface
     */
    protected $redirect;

    /**
     * @var Magento\Backend\Helper\Data
     */
    private $helperBackend;

    /**
     * @param \Magento\Framework\App\ActionFlag $actionFlag
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Magento\Framework\App\Response\RedirectInterface $redirect
     */
    public function __construct(
        ActionFlag $actionFlag,
        ManagerInterface $messageManager,
        RedirectInterface $redirect,
		Data $helperBackend
    ) {
        $this->actionFlag    = $actionFlag;
        $this->messageManager = $messageManager;
        $this->redirect       = $redirect;
		$this->helperBackend  = $helperBackend;
    }

    /**
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
		/** @var \Magento\Framework\App\Action\Action $controller */
		$controller = $observer->getControllerAction();
		$this->actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);
		/*$this->redirect->redirect($controller->getResponse(),
		 'https://foosite.com');*/
		 
		$this->redirect->redirect(
            $controller->getResponse(),
            $this->helperBackend->getHomePageUrl()
        );

    }

}
