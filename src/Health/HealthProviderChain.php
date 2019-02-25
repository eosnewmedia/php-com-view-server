<?php
declare(strict_types=1);

namespace Eos\ComView\Server\Health;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class HealthProviderChain implements ViewHealthProviderInterface, CommandHealthProviderInterface
{
    /**
     * @var CommandHealthProviderInterface[]
     */
    private $commandHealthProviders = [];

    /**
     * @var ViewHealthProviderInterface[]
     */
    private $viewHealthProviders = [];

    /**
     * @param HealthProviderInterface $healthProvider
     */
    public function add(HealthProviderInterface $healthProvider): void
    {
        if ($healthProvider instanceof CommandHealthProviderInterface) {
            $this->commandHealthProviders[] = $healthProvider;
        }

        if ($healthProvider instanceof ViewHealthProviderInterface) {
            $this->viewHealthProviders[] = $healthProvider;
        }
    }

    /**
     * @return string[]
     */
    public function getCommandStates(): array
    {
        $states = [];
        foreach ($this->commandHealthProviders as $healthProvider) {
            foreach ($healthProvider->getCommandStates() as $command => $state) {
                $states[$command] = $state;
            }
        }

        return $states;
    }

    /**
     * @return string[]
     */
    public function getViewStates(): array
    {
        $states = [];
        foreach ($this->viewHealthProviders as $healthProvider) {
            foreach ($healthProvider->getViewStates() as $view => $state) {
                $states[$view] = $state;
            }
        }

        return $states;
    }
}
