<?php

namespace MSR\WhitelistCSP\Model\Collector;

use Magento\Csp\Api\Data\PolicyInterface;
use Magento\Csp\Api\PolicyCollectorInterface;
use Magento\Csp\Model\Collector\MergerInterface;
use Magento\Csp\Model\Policy\FetchPolicy;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CustomCSPWhitelistCollector implements PolicyCollectorInterface
{
    private const ENABLED_XML_PATH = 'whitelist_csp/configuration/enabled';
    private const GET_POLICIES_XML_PATH = 'whitelist_csp/configuration/urls';

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param MergerInterface $merger
     */
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly MergerInterface $merger
    ) {
    }

    /**
     * Collect all configured policies from admin.
     *
     * Collector finds CSPs from configurations and merge with previously found policies.
     *
     * @param PolicyInterface[] $defaultPolicies
     * @return PolicyInterface[]
     */
    public function collect(array $defaultPolicies = []): array
    {
        if (!$this->scopeConfig->isSetFlag(self::ENABLED_XML_PATH)) {
            return $defaultPolicies;
        }
        $customPolicies = $this->getCustomPolicies($defaultPolicies);

        return $this->mergePolicies($defaultPolicies, $customPolicies);
    }

    /**
     * Merge custom policies with default policies
     *
     * @param array $defaultPolicies
     * @param array $customPolicies
     * @return array
     */
    private function mergePolicies(array $defaultPolicies, array $customPolicies): array
    {
        foreach ($customPolicies as $policy) {
            if (array_key_exists($policy->getId(), $defaultPolicies)) {
                if ($this->merger->canMerge($defaultPolicies[$policy->getId()], $policy)) {
                    $defaultPolicies[$policy->getId()] = $this->merger->merge(
                        $defaultPolicies[$policy->getId()],
                        $policy
                    );
                }
            } else {
                $defaultPolicies[$policy->getId()] = $policy;
            }
        }
        return $defaultPolicies;
    }

    /**
     * Get custom CSP policies.
     *
     * @return array
     */
    private function getCustomPolicies(): array
    {
        $policies = [];
        $policyData = $this->getConfiguredPolicies();
        foreach ($policyData as $policyId => $values) {
            $policies[] = new FetchPolicy(
                $policyId,
                false,
                $values['hosts'] ?? [],
                [],
                false,
                false,
                false,
                [],
                $values['hashes'] ?? [],
                false,
                false
            );
        }

        return $policies;
    }

    /**
     * Get all configured policies from admin config
     *
     * @return array
     */
    private function getConfiguredPolicies(): array
    {
        $data = [];
        $config = $this->scopeConfig->getValue(self::GET_POLICIES_XML_PATH) ?
            json_decode($this->scopeConfig->getValue(self::GET_POLICIES_XML_PATH), true) : [];
        foreach ($config as $policyId => $values) {
            if ($values['value_type'] == 'host') {
                $data[$values['whitelist_type']]['hosts'][$policyId] = $values['value'];
            } else {
                $data[$values['whitelist_type']]['hashes'][$values['value']] = 'sha256';
            }
        }
        return $data;
    }
}
