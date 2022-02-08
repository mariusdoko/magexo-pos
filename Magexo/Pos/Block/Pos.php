<?php

namespace Magexo\Pos\Block;

use Magento\Framework\View\Element\Template\Context;
use Magexo\Pos\Model\MagexoposFactory as PosFactory;
/**
 * Pos List block
 */
class Pos extends \Magento\Framework\View\Element\Template
{
    public function __construct(
        Context $context,
        PosFactory $pos
    ) {
        $this->_pos = $pos;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Magexo Pos Data'));
        
        return parent::_prepareLayout();
    }

    public function getPosCollection()
    {
        $pos = $this->_pos->create();
        $collection = $pos->getCollection();
        return $collection;
    }
}