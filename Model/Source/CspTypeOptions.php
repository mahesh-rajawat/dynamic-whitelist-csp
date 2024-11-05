<?php

namespace MSR\WhitelistCsp\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class CspTypeOptions extends AbstractSource
{
    /**
     * @inheritDoc
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['label' => __('host') , 'value' => 'host'],
                ['label' => __('hash') , 'value' => 'hash']
            ];
        }
        return $this->_options;
    }
}
