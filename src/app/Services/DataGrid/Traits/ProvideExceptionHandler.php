<?php

namespace App\Services\DataGrid\Traits;

trait ProvideExceptionHandler
{
    protected array $requiredRowPropertiesKeys = ['condition'];
    protected array $requiredColumnKeys = ['index', 'label'];
    protected array $requiredActionKeys = ['title', 'method', 'action', 'route', 'icon'];

    /**
     * @param array $rowProperty
     * @return void
     * @throws \Exception
     */

    public function checkRequiredRowPropertiesKeys(array $rowProperty): void
    {
        $this->checkRequiredKeys($this->requiredRowPropertiesKeys, $rowProperty, function ($missingKeys) {
            $message = 'Missing Keys: ' . implode(', ', $missingKeys);

            throw new \Exception($message);
        });
    }

    /**
     * @param array $column
     * @throws \Exception
     */
    public function checkRequiredColumnKeys(array $column): void
    {
        $this->checkRequiredKeys($this->requiredColumnKeys, $column, function ($missingKeys) {
            $message = 'Missing Keys: ' . implode(', ', $missingKeys);

            throw new \Exception($message);
        });
    }

    /**
     * @param array $action
     * @throws \Exception
     */

    public function checkRequiredActionKeys(array $action): void
    {
        $this->checkRequiredKeys($this->requiredActionKeys, $action, function ($missingKeys) {
            $message = 'Missing Keys: ' . implode(', ', $missingKeys);

            throw new \Exception($message);
        });
    }

    /**
     * @param array $requiredKeys
     * @param array $actualKeys
     * @param \Closure $operation
     * @return void|\Closure
     */

    public function checkRequiredKeys(array $requiredKeys, array $actualKeys, \Closure $operation)
    {
        $requiredKeys = array_flip($requiredKeys);

        $missingKeys = array_flip(array_diff_key($requiredKeys, $actualKeys));

        return ! empty($missingKeys) ? $operation($missingKeys) : null;
    }
}
