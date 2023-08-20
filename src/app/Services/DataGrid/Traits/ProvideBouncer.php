<?php

namespace App\Services\DataGrid\Traits;

trait ProvideBouncer
{
    use ProvideRouteResolver;

    /**
     * Check permissions.
     *
     * @param array $action
     * @param bool $specialPermission
     * @param \Closure $operation
     * @param string $nameKey
     * @return void
     */
    private function checkPermissions(array $action, bool $specialPermission, \Closure $operation, string $nameKey = 'title')
    {
        $eventName = isset($action[$nameKey]) ? $this->generateEventName($action[$nameKey]) : null;

        /**
         * In future if some cases needed, then return the below closure as per the case.
         */
        return $operation($action, $eventName);
    }

    /**
     * @param string $titleOrLabel
     * @return string
     */
    private function generateEventName(string $titleOrLabel): string
    {
        $eventName = explode(' ', strtolower($titleOrLabel));

        return implode('.', $eventName);
    }
}
