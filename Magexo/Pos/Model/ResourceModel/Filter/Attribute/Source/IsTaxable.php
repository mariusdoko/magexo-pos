<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * posentity Taxable Class
 */
namespace Magexo\Pos\Model\ResourceModel\Filter\Attribute\Source;

class IsTaxable implements \Magento\Framework\Option\ArrayInterface
{

    const NOT_TAXABle = 0;

    const TAXABLE = 1;


    public function toOptionArray()
    {
        return  [
            ['value' => self::NOT_TAXABle, 'label' => __('NOT TAXABLE')],
            ['value' => self::TAXABLE, 'label' => __('TAXABLE')],
        ];
    }

    public function toArray()
    {
        $array = [];
        foreach ($this->toOptionArray() as $item) {
            $array[$item['value']] = $item['label'];
        }
        return $array;
    }
}
