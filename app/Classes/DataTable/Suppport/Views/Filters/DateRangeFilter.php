<?php

namespace App\Classes\DataTable\Suppport\Views\Filters;

use DateTime;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class DateRangeFilter extends Filter
{

    public function validate($value)
    {
        if (is_array($value)) {
            // Remove the bad value
            $value = array_slice($value, 0, 2);
            for ($i = 0; $i < 2; $i++) {
                if (DateTime::createFromFormat('Y-m-d', $value[$i]) === false) {
                    return false;
                }
            }
        }

        return $value;
    }

    public function getDefaultValue()
    {
        return [];
    }

    public function getFilterPillValue($value): ?string
    {
        $values = [];

        for ($i = 0; $i < 2; $i++) {
            $found = $this->getCustomFilterPillValue($value[$i]) ?? $value[$i];

            if ($found) {
                $values[] = $found;
            }
        }

        return implode('-', $values);
    }

    public function isEmpty($value): bool
    {
        return !is_array($value) || count($value) != 2 || !$value[0] || !$value[1];
    }

    public function render(DataTableComponent $component)
    {
        return view('livewire-tables::components.tools.filters.date-range', [
            'component' => $component,
            'filter' => $this,
        ]);
    }
}
