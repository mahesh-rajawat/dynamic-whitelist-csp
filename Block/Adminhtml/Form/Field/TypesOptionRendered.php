<?php
declare(strict_types=1);

namespace MSR\WhitelistCSP\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;
use MSR\WhitelistCsp\Model\Source\CspTypeOptions;

class TypesOptionRendered extends Select
{
    public function __construct(
        Context $context,
        private readonly CspTypeOptions $cspTypeOptions,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
    /**
     * Set "name" for <select> element
     *
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Set "id" for <select> element
     *
     * @param string $value
     * @return TypesOptionRendered
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
        return $this->cspTypeOptions->getAllOptions();
    }
}
