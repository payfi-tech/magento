<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Payfi\Webhook\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action implements HttpGetActionInterface
{


protected $_order;
protected $_status;

protected $resourceConnection;
protected $request;

    public function __construct(
    \Magento\Framework\App\Action\Context $context,
    \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory,

    \Magento\Sales\Model\Order $order,
\Magento\Framework\App\ResourceConnection $resourceConnection,
\Magento\Sales\Model\Order\Status $status,
\Magento\Framework\App\Request\Http $request
) {
    parent::__construct($context);
    $this->jsonResultFactory = $jsonResultFactory;
    $this->_order=$order;
$this->_status=$status;
$this->resourceConnection = $resourceConnection;
     $this->request = $request;


}

public function execute()
{
    

$data = $this->request->getParams();
$response=[];
$response=array("status"=>300);
$status=null;

$quote_id=$data["txRef"];




if(isset($quote_id))
{

// $table is table name]
$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
$connection = $resource->getConnection();
$table = $connection->getTableName('sales_order');
//For Select query
$query = "Select increment_id FROM " . $table." where quote_id=".$quote_id;
$result = $connection->fetchAll($query);

$order = $this->_order->loadByIncrementId($result[0]['increment_id']);


$status_code=$data['status_code'];
$status_from_payfi=$data['status']['name'];

$status = $this->_status->load($status_code);

if(!$status->getStatus()){//status deos not  exist

$status->setData('status',  $status_code)->setData('label',  $status_from_payfi)->save();
}



$orderState = \Magento\Sales\Model\Order::STATE_PROCESSING;
$order->setState("processing")->setStatus($status_code);
$order->save();

$response=array("status"=>200);
}



$data = $response;

    $result = $this->jsonResultFactory->create();
    $result->setData($data);
    return $result;
}
}


