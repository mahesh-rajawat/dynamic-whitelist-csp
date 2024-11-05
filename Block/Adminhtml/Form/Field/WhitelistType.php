<?php
declare(strict_types=1);

namespace MSR\WhitelistCSP\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;
use Magento\Framework\View\Element\Context;
use MSR\WhitelistCsp\Model\Source\WhitelistOptions;

class WhitelistType extends Select
{
    public function __construct(
        Context $context,
        private readonly WhitelistOptions $whitelistOptions,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return mixed
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputId($value)
    {
        return $this->setId($value);
    }

    /**
     * Render block HTML
     *
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->setOptions($this->getSourceOptions());
        }
        return parent::_toHtml();
    }

    /**
     * Provide policy types options
     *
     * @return array[]
     */
    private function getSourceOptions(): array
    {
        return $this->whitelistOptions->toOptionArray();
    }
}
