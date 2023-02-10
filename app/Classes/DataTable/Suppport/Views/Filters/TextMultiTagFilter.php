<?php

namespace App\Classes\DataTable\Suppport\Views\Filters;

use DateTime;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class TextMultiTagFilter extends Filter
{

    public function validate($value)
    {
        if (!is_array($value) || count($value) == 0) {
            return false;
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

        foreach ($value as $index => $val) {
            $found = $this->getCustomFilterPillValue($val) ?? $val;

            if ($found) {
                $values[] = $found;
            }
        }
        return implode(', ', $values);
    }

    public function isEmpty($value): bool
    {
        return !is_array($value) || count($value) == 0;
    }

    public function render(DataTableComponent $component)
    {
        return view('livewire-tables::components.tools.filters.text-multi-tag', [
            'component' => $component,
            'filter' => $this,
        ]);
    }
}
