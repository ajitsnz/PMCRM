<div>
    <div class="row">
        <div class="mt-0 mb-3 col-12 d-flex justify-content-end">
            <div class="p-2">
                <input wire:model.debounce.100ms="search" type="search" class="form-control" placeholder="Search"
                       id="search">
            </div>
        </div>
        <div class="col-md-12">
            <div wire:loading id="live-wire-screen-lock">
                <div class="live-wire-infy-loader">
                    @include('loader')
                </div>
            </div>
        </div>

        @forelse($expenses as $expense)
            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                <div class="expense-card card {{ $loop->odd ? 'card-primary' : 'card-dark'}} shadow mb-5 rounded hover-card card-height">
                    <div class="card-header d-flex justify-content-between align-items-center itemCon p-3">
                        <div class="d-flex">
                            <a href="{{ url('admin/expenses', $expense->id) }}"
                               class="d-flex flex-wrap text-decoration-none">
                                <h4 class="text-primary invoice-clients invoice_title pl-2">
                                    {{ Str::limit(html_entity_decode($expense->name), 15, '...') }}
                                </h4>
                            </a>
                        </div>
                        <div class="expense-action-btn d-none">
                            <a title="Edit" href="{{ route('expenses.edit',$expense->id) }}"><i
                                        class="fa fa-edit text-warning mr-1"></i>
                            </a>
                            <a title="Delete" class="text-danger action-btn delete-btn tickets-delete"
                               data-id="{{ $expense->id }}" href="#">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body d-flex justify-content-between pt-1 px-3">
                        <div class="d-table w-100">
                            <div>
                                <i class="fas fa-list-ol"></i>
                                <span class="text-decoration-none" data-toggle="tooltip" title="Expense Category"> {{ html_entity_decode($expense->expenseCategory->name) }}
                                </span>
                            </div>
                            <span class="d-table-row w-100">
                            <big class="d-table-cell w-100">
                                <i class="{{ getCurrencyClassFromIndex($expense->currency) }}"></i> <span
                                        data-toggle="tooltip"
                                        title="Expense Amount">{{ number_format( $expense->amount, 2) }}</span>
                            </big>
                            </span>
                            <span class="d-table-row w-100">{{Carbon\Carbon::parse($expense->expense_date)->format('jS M, Y')}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="mt-0 mb-5 col-12 d-flex justify-content-center  mb-5 rounded">
                <div class="p-2">
                    @if(empty($search))
                        <p class="text-dark">{{ __('messages.expense.no_expense_available') }}</p>
                    @else
                        <p class="text-dark">{{ __('messages.expense.expense_not_found') }}</p>
                    @endif
                </div>
            </div>
        @endforelse

        <div class="mt-0 mb-5 col-12">
            <div class="row paginatorRow">
                <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                <span class="d-inline-flex">
                    {{ __('messages.common.showing') }}
                    <span class="font-weight-bold ml-1 mr-1">{{ $expenses->firstItem() }}</span> - 
                    <span class="font-weight-bold ml-1 mr-1">{{ $expenses->lastItem() }}</span> {{ __('messages.common.of') }} 
                    <span class="font-weight-bold ml-1">{{ $expenses->total() }}</span>
                </span>
                </div>
                <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                    {{ $expenses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
