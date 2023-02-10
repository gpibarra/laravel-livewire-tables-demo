@php
$theme = $component->getTheme();
$currentDataFilter = Arr::wrap(Arr::get($component->{$component->getTableName()}, 'filters.' . $filter->getKey(), []));
@endphp

@if ($theme === 'tailwind')
    <div wire:ignore class="rounded-md shadow-sm">
        <select id="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}" multiple size="1"
            data-placeholder=""
            class="block w-full border-gray-300 rounded-md shadow-sm transition duration-150 ease-in-out focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white dark:border-gray-600">
            @foreach ($currentDataFilter as $key => $value)
                <option value="{{ $value }}" selected>{{ $value }}</option>
            @endforeach
        </select>
    </div>
@elseif ($theme === 'bootstrap-4' || $theme === 'bootstrap-5')
    <div wire:ignore class="mb-3 mb-md-0 input-group">
        <select id="{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}" multiple size="1"
            data-placeholder="" class="form-control">
            <option value="test">test</option>
            <option value="test2">test2</option>
            @foreach ($currentDataFilter as $key => $value)
                <option value="{{ $value }}" selected>{{ $value }}</option>
            @endforeach
        </select>
    </div>
@endif

<script type="text/javascript">
    document.addEventListener('livewire:load', function() {
        let elementIdTextMultiTagsFilter =
            "{{ $component->getTableName() }}-filter-{{ $filter->getKey() }}";
        let elementSelectorIdTextMultiTagsFilter = "select#" + elementIdTextMultiTagsFilter;
        let propertyNameTextMultiTagsFilter =
            "{{ $component->getTableName() }}.filters.{{ $filter->getKey() }}";

        let setSelect2TextMultiTagsFilter = function() {
            let data = @this.get(propertyNameTextMultiTagsFilter);
            if (Array.isArray(data)) {
                $(elementSelectorIdTextMultiTagsFilter).val(data).change();
            }
        };
        let setLivewireSelect2TextMultiTagsFilter = function(data) {
            if (Array.isArray(data)) {
                @this.set(propertyNameTextMultiTagsFilter, data);
            }
        };
        let initSelect2TextMultiTagsFilter = function() {
            a = $(elementSelectorIdTextMultiTagsFilter).select2({
                multiple: true,
                allowClear: true,
                width: '100%',
                placeholder: '',
                tags: true,
                matcher: function(term, text) {
                    return false;
                },
                // tokenSeparators: [',', ' ']
            });
        };
        $(elementSelectorIdTextMultiTagsFilter).on('select2:open', function(e) {
            $('.select2-container--open .select2-dropdown--below').css('display', 'none');
        });

        initSelect2TextMultiTagsFilter();

        @this.on('reset-' + elementIdTextMultiTagsFilter, function() {
            setSelect2TextMultiTagsFilter();
        });

        $(elementSelectorIdTextMultiTagsFilter).on('select2:select select2:unselect select2:clear', function(
            e) {
            let data = $(this).select2("val");
            setLivewireSelect2TextMultiTagsFilter(data);
        });

    });
</script>
