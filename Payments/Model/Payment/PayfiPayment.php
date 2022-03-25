<?php
/**
 * Payfi Payment gateway for accepting credit card, debit card and bank account payment on you store
 * Copyright (C) 2016  2017
 *
 * This file is part of Payfi/Payments.
 *
 * Payfi/Payments is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Payfi\Payments\Model\Payment;

class PayfiPayment extends \Magento\Payment\Model\Method\AbstractMethod
{

    protected $_code = "payfipayment";
    protected $_isOffline = false;

    public function isAvailable(
        \Magento\Quote\Api\Data\CartInterface $quote = null
    ) {
       
   $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
   $active = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('payment/payfipayment/active');
           
                   if($active)
                   {
                    return true;
                   }else{
                   
                   return false;
                     }  
  }
}
