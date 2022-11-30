<select class="th-datatable-select form-control" data-column="{{ $col }}">
    <option value="" selected>-- Semua --</option>
    {{-- if model isset = TRUE, db_column must be set --}}
    @if (isset($model))
        @foreach ($options as $k => $v)
            <option value="{{ $k }}">{{ $v }} ({{ $model::where($db_column, $k)->count() }})
            </option>
        @endforeach
    @else
        @foreach ($options as $k => $v)
            <option value="{{ $k }}">{{ $v }}
            </option>
        @endforeach
    @endif
</select>
@once
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @endpush
    @push('scripts')
        <script>
            $(document).ready(() => {
                $(".th-datatable-select").select2()
                $('.th-datatable-select').on('change', function() {
                    let tableId = "#{{ isset($table_id) ? $table_id : '' }}";
                    let i = $(this).attr('data-column');
                    let v = $(this).val();
                    if (tableId == '#') {
                        tableId = $(this).closest('table')[0]
                    }
                    $(tableId).DataTable().columns(i).search(v).draw();
                });
            })
        </script>
    @endpush
@endonce
