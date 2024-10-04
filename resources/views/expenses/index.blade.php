@extends('layouts.app')

@section('title', 'Expenses')
@section('content')

    @include('components.preloader')

    <!-- React page -->
    <div id="app">
        <!-- Begin page -->
        <div class="wrapper">
            <!-- Start sidebar -->
            @include('components.sidebar.sidebar')
            <!-- End sidebar -->

            <div class="content-wrapper">
                <div class="main-content">
                    @include('components.navbar')

                    <div class="body-content">
                        <div class="tile">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fs-17 fw-semi-bold mb-0">Expenses</h6>
                                        <div class="actions">
                                            <div class="accordion-header d-flex justify-content-end align-items-center" id="flush-headingOne">
                                                @if (\Auth::user()->can('export expenses'))
                                                    <a class="btn btn-success btn-sm" href="{{ route('expenses.export') }}" title="Export to xlsx excel file">
                                                        <i class="fa-solid fa-file-export"></i> Export
                                                    </a>
                                                @endif
                                                <span class="m-1"></span>
                                                @if (\Auth::user()->can('import expenses'))
                                                    <a class="btn btn-success btn-sm" href="{{ route('expenses.import') }}" title="Import from xlsx excel file">
                                                        <i class="fa-solid fa-file-import"></i> Import
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Amount</th>
                                                <th>Category</th>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($expenses as $expense)
                                                <tr>
                                                    <td>{{ $expense->name }}</td>
                                                    <td>{{ $expense->amount }}</td>
                                                    <td>{{ $expense->category }}</td>
                                                    <td>{{ $expense->entry_date }}</td>
                                                    <td>{{ $expense->description }}</td>
                                                    <td>
                                                        <div class="d-flex">
                                                            @if (\Auth::user()->can('edit expense'))
                                                                <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-primary btn-sm mr-1" title="Add Remark">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td class="text-right font-weight-bold"><strong>Total Amount:</strong></td>
                                                <td class="font-weight-bold"><strong>KES {{ $totalAmount }}</strong></td>
                                                <td colspan="4"></td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                   </div>
                                    <div id="page-axios-data" data-table-id="#driver-table"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overlay"></div>
                @include('components.footer')
            </div>
        </div>
        <!-- end vue page -->
    </div>
    <!-- END layout-wrapper -->

@endsection
