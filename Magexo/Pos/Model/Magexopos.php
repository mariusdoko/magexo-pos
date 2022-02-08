<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magexo\Pos\Model;

use Magento\Framework\Model\AbstractModel;

class Magexopos extends AbstractModel
{

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Magexo\Pos\Model\ResourceModel\Magexopos');
    }
}
