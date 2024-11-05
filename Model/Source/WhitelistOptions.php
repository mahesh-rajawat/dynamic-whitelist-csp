<?php

namespace MSR\WhitelistCsp\Model\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class WhitelistOptions extends AbstractSource
{
    /**
     * @inheritDoc
     */
    public function getAllOptions()
    {
        if ($this->_options === null) {
            $this->_options = [
                ['label' => __('script-src') , 'value' => 'script-src'],
                ['label' => __('connect-src') , 'value' => 'connect-src'],
                ['label' => __('object-src') , 'value' => 'object-src'],
                ['label' => __('default-src') , 'value' => 'default-src'],
                ['label' => __('base-uri') , 'value' => 'base-uri'],
                ['label' => __('child-src') , 'value' => 'child-src'],
                ['label' => __('img-src') , 'value' => 'img-src'],
                ['label' => __('manifest-src') , 'value' => 'manifest-src'],
                ['label' => __('media-src') , 'value' => 'media-src'],
                ['label' => __('style-src') , 'value' => 'style-src'],
                ['label' => __('font-src') , 'value' => 'font-src'],
                ['label' => __('form-action') , 'value' => 'form-action'],
                ['label' => __('frame-ancestors') , 'value' => 'frame-ancestors'],
                ['label' => __('frame-src') , 'value' => 'frame-src']
            ];
        }
        return $this->_options;
    }
}
