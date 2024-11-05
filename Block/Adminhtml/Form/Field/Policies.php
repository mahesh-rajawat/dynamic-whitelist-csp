<?php
declare(strict_types=1);

namespace MSR\WhitelistCSP\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

class Policies extends AbstractFieldArray
{
    /**
     * @var WhitelistType
     */
    private $policies;

    /**
     * @var TypesOptionRendered
     */
    private $types;

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'whitelist_type',
            ['label' => __('Policy Name'), 'class' => 'required-entry', 'renderer' => $this->getPolicies()]
        );
        $this->addColumn(
            'value_type',
            ['label' => __('Value Type'), 'class' => 'required-entry', 'renderer' => $this->getValueTypes()]
        );
        $this->addColumn('value', ['label' => __('Value'), 'class' => 'required-entry', 'style' => 'width: 280px']);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare existing row data object
     *
     * @param DataObject $row
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];

        $policy = $row->getPolicyType();
        $valueType = $row->getValueType();
        if ($policy !== null) {
            $options['option_' . $this->getPolicies()->calcOptionHash($policy)] = 'selected="selected"';
        }

        if ($valueType !== null) {
            $options['option_' . $this->getValueTypes()->calcOptionHash($valueType)] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }

    /**
     * @return WhitelistType
     * @throws LocalizedException
     */
    private function getPolicies(): WhitelistType
    {
        if (!$this->policies) {
            $this->policies = $this->getLayout()->createBlock(
                WhitelistType::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->policies;
    }

    /**
     * @return TypesOptionRendered
     * @throws LocalizedException
     */
    private function getValueTypes(): TypesOptionRendered
    {
        if (!$this->types) {
            $this->types = $this->getLayout()->createBlock(
                TypesOptionRendered::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->types;
    }
}
