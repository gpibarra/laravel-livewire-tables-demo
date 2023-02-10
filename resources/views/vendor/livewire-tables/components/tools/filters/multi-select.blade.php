@php
$theme = $component->getTheme();
$currentDataFilter = Arr::wrap(Arr::get($component->{$component->getTableName()}, 'filters.' . $filter->getKey(), []));
@endphp

@if ($theme === 'tailwind')
    <div wire:ignore class="rounded-md shadow-sm">
        <select id="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}" multiple size="1"
            data-placeholder=""
            class="block w-full border-gray-300 rounded-md shadow-sm transition duration-150 ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white dark:border-gray-600">
            @foreach ($filter->getOptions() as $key => $value)
                <option value="{{ $key }}" @if (in_array($key, $currentDataFilter)) selected @endif>
                    {{ $value }}</option>
            @endforeach
        </select>
    </div>
@elseif ($theme === 'bootstrap-4' || $theme === 'bootstrap-5')
    <div wire:ignore class="mb-3 mb-md-0 input-group">
        <select id="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}" multiple size="1"
            data-placeholder="" class="form-control">
            @foreach ($filter->getOptions() as $key => $value)
                @if ($key)
                    <option value="{{ $key }}" @if (in_array($key, $currentDataFilter)) selected @endif>
                        {{ $value }}</option>
                @endif
            @endforeach
        </select>
    </div>
@endif

<script type="text/javascript">
    document.addEventListener('livewire:load', function() {
        let elementIdMultiSelectFilter = "{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}";
        let elementSelectorIdMultiSelectFilter = "select#" + elementIdMultiSelectFilter;
        let propertyNameMultiSelectFilter =
            "{{ $component->getTableName() }}.filters.{{ $filter->getKey() }}";

        let setSelect2MultiSelectFilter = function() {
            let data = @this.get(propertyNameMultiSelectFilter);
            if (Array.isArray(data)) {
                $(elementSelectorIdMultiSelectFilter).val(data).change();
            }
        };
        let setLivewireSelect2MultiSelectFilter = function(data) {
            if (Array.isArray(data)) {
                @this.set(propertyNameMultiSelectFilter, data);
            }
        };
        let initSelect2MultiSelectFilter = function() {
            $(elementSelectorIdMultiSelectFilter).select2({
                multiple: true,
                allowClear: true,
                width: '100%',
                placeholder: '',
            });
        };

        initSelect2MultiSelectFilter();

        @this.on('reset-' + elementIdMultiSelectFilter, function() {
            setSelect2MultiSelectFilter();
        });

        $(elementSelectorIdMultiSelectFilter).on('select2:select select2:unselect select2:clear', function(e) {
            let data = $(this).select2("val");
            setLivewireSelect2MultiSelectFilter(data);
        });

    });
</script>
