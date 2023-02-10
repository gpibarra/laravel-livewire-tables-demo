@php
$theme = $component->getTheme();
$currentDataFilter = Arr::wrap(Arr::get($component->{$component->getTableName()}, 'filters.' . $filter->getKey(), []));
$currentDataFilterInput = '';
if (!empty($currentDataFilter)) {
    $currentDataFilterInput = $currentDataFilter[0] . ' - ' . $currentDataFilter[1];
}
@endphp

@if ($theme === 'tailwind')
    <div wire:ignore class="rounded-md shadow-sm">
        <input type="text" id="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}" autocomplete="off"
            class="block w-full border-gray-300 rounded-md shadow-sm transition duration-150 ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white dark:border-gray-600"
            value="{{ $currentDataFilterInput }}" />
    </div>
@elseif ($theme === 'bootstrap-4' || $theme === 'bootstrap-5')
    <div wire:ignore class="mb-3 mb-md-0 input-group">
        <input type="text" id="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}" autocomplete="off"
            class="form-control" value="{{ $currentDataFilterInput }}" />
    </div>
@endif

<script type="text/javascript">
    document.addEventListener('livewire:load', function() {
        let elementIdDateRangeFilter = "{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}";
        let elementSelectorIdDateRangeFilter = "input#" + elementIdDateRangeFilter;
        let propertyNameDateRangeFilter =
            "{{ $component->getTableName() }}.filters.{{ $filter->getKey() }}";

        let setDataDateRangePickerFilter = function() {
            let data = @this.get(propertyNameDateRangeFilter);
            if (Array.isArray(data)) {
                if (data[0] && data[1]) {
                    $(elementSelectorIdDateRangeFilter).val(data[0] + ' - ' + data[1]).change();
                    $(elementSelectorIdDateRangeFilter).data('daterangepicker').setStartDate(data[0]);
                    $(elementSelectorIdDateRangeFilter).data('daterangepicker').setEndDate(data[1]);
                } else {
                    $(elementSelectorIdDateRangeFilter).val('').change();
                    $(elementSelectorIdDateRangeFilter).data('daterangepicker').setStartDate(undefined);
                    $(elementSelectorIdDateRangeFilter).data('daterangepicker').setEndDate(undefined);
                }
            }
        };
        let setLivewireDataDateRangePickerFilter = function(data) {
            if (Array.isArray(data)) {
                @this.set(propertyNameDateRangeFilter, data);
            }
        };
        let initDateRangePickerFilter = function() {
            $(elementSelectorIdDateRangeFilter).daterangepicker({
                @if ($filter->hasConfig('min'))
                    minDate: moment('{{ $filter->getConfig('min') }}'),
                @endif
                @if ($filter->hasConfig('max'))
                    maxDate: moment('{{ $filter->getConfig('max') ?? 'null' }}'),
                @endif
                autoUpdateInput: false,
                showDropdowns: true,
                linkedCalendars: false,
                startDate: undefined,
                endDate: undefined,
            });
        };

        initDateRangePickerFilter();

        @this.on('reset-' + elementIdDateRangeFilter, function() {
            setDataDateRangePickerFilter();
        });

        $(elementSelectorIdDateRangeFilter).on('apply.daterangepicker', function(e,
            picker) {
            let data = ['', ''];
            if (picker.startDate && picker.endDate) {
                data = [
                    picker.startDate.format('YYYY-MM-DD'),
                    picker.endDate.format('YYYY-MM-DD'),
                ];
                $(this).val(data[0] + ' - ' + data[1]).change();
            } else {
                $(this).val('').change();
            }
            setLivewireDataDateRangePickerFilter(data);
        });
        $(elementSelectorIdDateRangeFilter).on('cancel.daterangepicker', function(e,
            picker) {
            let data = ['', ''];
            picker.setStartDate(undefined);
            picker.setEndDate(undefined);
            $(this).val('').change();
            setLivewireDataDateRangePickerFilter(data);
        });

    });
</script>
