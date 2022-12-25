@if(isset($options->model) && isset($options->type))

    @if(class_exists($options->model))

        @php $relationshipField = $row->field; @endphp

        @if($options->type == 'belongsTo')

            @if(isset($view) && ($view == 'browse' || $view == 'read'))

                @php
                    $relationshipData = (isset($data)) ? $data : $dataTypeContent;
                    $model = app($options->model);
                    $query = $model::where($options->key,$relationshipData->{$options->column})->first();
                @endphp

                @if(isset($query))
                    <p>{{ $query->{$options->label} }}</p>
                @else
                    <p>{{ __('voyager::generic.no_results') }}</p>
                @endif

            @else

                <select
                        class="form-control select2-ajax" name="{{ $options->column }}"
                        data-get-items-route="{{route('voyager.' . $dataType->slug.'.relation')}}"
                        data-get-items-field="{{$row->field}}"
                        @if(!is_null($dataTypeContent->getKey())) data-id="{{$dataTypeContent->getKey()}}" @endif
                        data-method="{{ !is_null($dataTypeContent->getKey()) ? 'edit' : 'add' }}"
                >
                    @php
                        $model = app($options->model);
                        $query = $model::where($options->key, old($options->column, $dataTypeContent->{$options->column}))->get();
                    @endphp

                    @if(!$row->required)
                        <option value="">{{__('voyager::generic.none')}}</option>
                    @endif

                    @foreach($query as $relationshipData)
                        <option value="{{ $relationshipData->{$options->key} }}" @if(old($options->column, $dataTypeContent->{$options->column}) == $relationshipData->{$options->key}) selected="selected" @endif>{{ $relationshipData->{$options->label} }}</option>
                    @endforeach
                </select>

            @endif

        @elseif($options->type == 'hasOne')

            @php
                $relationshipData = (isset($data)) ? $data : $dataTypeContent;

                $model = app($options->model);
                $query = $model::where($options->column, '=', $relationshipData->recid)->first();
            @endphp

            @if(isset($query))
                @if($query->{$options->label})
                    <p>{{ $query->{$options->label} }}</p>
                @endif
                @if($query instanceof \App\Hydro\HydroProductFamily)
                    @include('vendor.voyager.hydro-products.families', ['family' => $query])
                @endif
                @if($query instanceof \App\Hydro\HydroProductPrice)
                    <p>${{ $query->retailPrice }}</p>
                    @include('vendor.voyager.hydro-products.prices', ['price' => $query])
                @endif
            @else
                <p>{{ __('voyager::generic.no_results') }}</p>
            @endif

        @elseif($options->type == 'hasMany')
            @php
                $relationshipData = (isset($data)) ? $data : $dataTypeContent;
                $model = app($options->model);

                $selected_values = $model::where($options->column, '=', $relationshipData->recid)->get();
            @endphp
            @if($model instanceof \App\Hydro\HydroProductAttribute)
                @include('vendor.voyager.hydro-products.attributes', ['selected_values' => $selected_values])
            @endif
            @if($model instanceof \App\Hydro\HydroProductBarCode)
                @include('vendor.voyager.hydro-products.bar-codes', ['selected_values' => $selected_values])
            @endif
            @if($model instanceof \App\Hydro\HydroProductDimension)
                @include('vendor.voyager.hydro-products.dimensions', ['selected_values' => $selected_values])
            @endif
            @if($model instanceof \App\Hydro\HydroProductDocument)
                @include('vendor.voyager.hydro-products.documents', ['selected_values' => $selected_values])
            @endif
            @if($model instanceof \App\Hydro\HydroProductImage)
                @include('vendor.voyager.hydro-products.images', ['selected_values' => $selected_values])
            @endif
            @if($model instanceof \App\Hydro\HydroProductInventory)
                @include('vendor.voyager.hydro-products.inventories', ['selected_values' => $selected_values])
            @endif
            @if($model instanceof \App\Hydro\HydroProductRelated)
                @include('vendor.voyager.hydro-products.related', ['selected_values' => $selected_values])
            @endif
            @if($model instanceof \App\Hydro\HydroProductRestriction)
                @include('vendor.voyager.hydro-products.restrictions', ['selected_values' => $selected_values])
            @endif
            @if($model instanceof \App\Hydro\HydroProductUomConversion)
                @include('vendor.voyager.hydro-products.uom-conversions', ['selected_values' => $selected_values])
            @endif

        @elseif($options->type == 'belongsToMany')

            @if(isset($view) && ($view == 'browse' || $view == 'read'))

                @php
                    $relationshipData = (isset($data)) ? $data : $dataTypeContent;

                    $selected_values = isset($relationshipData) ? $relationshipData->belongsToMany($options->model, $options->pivot_table, $options->foreign_pivot_key ?? null, $options->related_pivot_key ?? null, $options->parent_key ?? null, $options->key)->get()->map(function ($item, $key) use ($options) {
            			return $item->{$options->label};
            		})->all() : array();
                @endphp

                @if($view == 'browse')
                    @php
                        $string_values = \App\Utils\Helpers\Helper::implode(", ", $selected_values);
                        if(mb_strlen($string_values) > 25){ $string_values = mb_substr($string_values, 0, 25) . '...'; }
                    @endphp
                    @if(empty($selected_values))
                        <p>{{ __('voyager::generic.no_results') }}</p>
                    @else
                        <p>{{ $string_values }}</p>
                    @endif
                @else
                    @if(empty($selected_values))
                        <p>{{ __('voyager::generic.no_results') }}</p>
                    @else
                        <ul>
                            @foreach($selected_values as $selected_value)
                                <li>{{ $selected_value }}</li>
                            @endforeach
                        </ul>
                    @endif
                @endif

            @else
                <select
                        class="form-control @if(isset($options->taggable) && $options->taggable === 'on') select2-taggable @else select2-ajax @endif"
                        name="{{ $relationshipField }}[]" multiple
                        data-get-items-route="{{route('voyager.' . $dataType->slug.'.relation')}}"
                        data-get-items-field="{{$row->field}}"
                        @if(!is_null($dataTypeContent->getKey())) data-id="{{$dataTypeContent->getKey()}}" @endif
                        data-method="{{ !is_null($dataTypeContent->getKey()) ? 'edit' : 'add' }}"
                        @if(isset($options->taggable) && $options->taggable === 'on')
                        data-route="{{ route('voyager.'.\Illuminate\Support\Str::slug($options->table).'.store') }}"
                        data-label="{{$options->label}}"
                        data-error-message="{{__('voyager::bread.error_tagging')}}"
                        @endif
                >

                    @php
                        $selected_values = isset($dataTypeContent) ? $dataTypeContent->belongsToMany($options->model, $options->pivot_table, $options->foreign_pivot_key ?? null, $options->related_pivot_key ?? null, $options->parent_key ?? null, $options->key)->get()->map(function ($item, $key) use ($options) {
                            return $item->{$options->key};
                        })->all() : array();
                        $relationshipOptions = app($options->model)->all();
                    $selected_values = old($relationshipField, $selected_values);
                    @endphp

                    @if(!$row->required)
                        <option value="">{{__('voyager::generic.none')}}</option>
                    @endif

                    @foreach($relationshipOptions as $relationshipOption)
                        <option value="{{ $relationshipOption->{$options->key} }}" @if(in_array($relationshipOption->{$options->key}, $selected_values)) selected="selected" @endif>{{ $relationshipOption->{$options->label} }}</option>
                    @endforeach

                </select>

            @endif

        @endif

    @else

        cannot make relationship because {{ $options->model }} does not exist.

    @endif

@endif
