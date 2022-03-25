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

namespace Payfi\Payments\Model\Payment\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Test
 */
class Test implements ArrayInterface
{
  /**
   * Possible environment types
   *
   * @return array
   */
  public function toOptionArray()
  {
    return [
      [
        'value' => true,
        'label' => 'Yes',
      ],
      [
        'value' => false,
        'label' => 'No'
      ]
    ];
  }
}
