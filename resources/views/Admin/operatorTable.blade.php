<div class="pagi_row">
    <div class="page_counts">
        Results: {{ $operators->firstItem() }}
        - {{ $operators->lastItem() }}
        of
        {{ $operators->total() }}
    </div>
    <div class="vehi_pagination">
        {{ $operators->links() }}
    </div>
</div>
<table class="all_users table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th style="min-width: 120px;">Operator Name</th>
            <th style="min-width: 120px;">Email</th>
            <th style="min-width:95px;">Status</th>
            <th style="min-width:95px;">Approved</th>
            <th style="min-width:95px;">Date</th>
            <th style="width: 150px;">Action</th>
        </tr>
    </thead>
    <tbody>
        @if ($operators->total() > 0)
            @foreach ($operators as $operator)
                <tr data-id="{{ $operator->id }}">
                    <td>{{ $operator->first_name }}</td>
                    <td>{{ $operator->email }}</td>
                    <td>
                        <form action="{{ route('change-operator-status', $operator->id) }}" method="post">
                            @csrf
                            <select class="form-control submitFromStatuss" name="status">
                                <option value="1" {{ $operator->status == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $operator->status == '0' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('change-operator-status', $operator->id) }}" method="post">
                            @csrf
                            <select class="form-control submitFromStatuss" name="is_approved">
                                <option value="1" {{ $operator->is_approved == '1' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="0" {{ $operator->is_approved == '0' ? 'selected' : '' }}>
                                    Un-Approved
                                </option>
                            </select>
                        </form>
                    </td>
                    <td>{{ $operator->created_at->format('d-M-Y') }}</td>
                    <td class="last">
                        <a title="Edit" href="{{ route('admin.operator.edit', ['page_id' => $operator->id]) }}"
                            class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> </a>
                        <a title="View" href="{{ route('admin.operator.view', $operator->id) }}"
                            class="btn btn-info btn-xs"><i class="fa fa-eye"></i> </a>
                        <a title="Bookings" href="{{ route('admin.bookings', ['operator_id' => $operator->id]) }}"
                            class="btn btn-info btn-xs"><i class="fa fa-calendar"></i> </a>
                        <a title="Delete" href="javascript:void(0);" onclick="deleteOperator({{ $operator->id }})"
                            data-id="{{ $operator->id }}" class="btn btn-danger btn-xs">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center">No Record Found</td>
            </tr>
        @endif
    </tbody>
</table>
<div class="pagi_row">
    <div class="page_counts">
        Results: {{ $operators->firstItem() }}
        - {{ $operators->lastItem() }}
        of
        {{ $operators->total() }}
    </div>
    <div class="vehi_pagination">
        {{ $operators->links() }}
    </div>
</div>
