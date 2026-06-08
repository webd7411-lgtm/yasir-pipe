@extends('admin_panel.layout.app')

@section('content')
    <style>
        /* Premium ERP Card & Container Styling */
        .premium-card {
            border: 2px solid #cbd5e1 !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
            background-color: #ffffff;
            margin-top: 10px;
        }
        
        /* Clean & Bold Filter Panel */
        .filter-panel {
            background-color: #f8fafc !important;
            border: 2px dashed #94a3b8 !important;
            border-radius: 10px !important;
            padding: 18px !important;
        }
        
        .filter-panel label {
            font-size: 12px;
            font-weight: 700 !important;
            color: #475569 !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .filter-panel .form-control,
        .filter-panel .form-select {
            border: 2px solid #cbd5e1 !important;
            border-radius: 6px !important;
            font-weight: 500 !important;
            color: #1e293b !important;
            transition: all 0.2s ease-in-out;
            height: 38px !important;
        }
        
        .filter-panel .form-control:focus,
        .filter-panel .form-select:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        }
        
        /* Elegant & Bold Buttons */
        .btn-premium-primary {
            background-color: #2563eb !important;
            border: 2px solid #1d4ed8 !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            border-radius: 6px !important;
            height: 38px !important;
            padding: 0 16px !important;
            transition: all 0.2s;
        }
        .btn-premium-primary:hover {
            background-color: #1d4ed8 !important;
            transform: translateY(-1px);
        }
        
        .btn-premium-secondary {
            background-color: #ffffff !important;
            border: 2px solid #cbd5e1 !important;
            color: #475569 !important;
            font-weight: 600 !important;
            border-radius: 6px !important;
            height: 38px !important;
            padding: 0 16px !important;
            transition: all 0.2s;
        }
        .btn-premium-secondary:hover {
            background-color: #f1f5f9 !important;
            border-color: #94a3b8 !important;
            color: #1e293b !important;
        }

        /* Compact Button Styling for Action List */
        .btn-xs {
            padding: 4px 8px !important;
            font-size: 11px !important;
            border-radius: 4px !important;
            font-weight: 700 !important;
            line-height: 1.2 !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            margin: 2px !important;
        }
        .btn-xs i {
            font-size: 10px !important;
        }
        .btn-xs:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.08) !important;
        }

        /* Premium Bold Table Styling */
        .premium-table {
            border: 2px solid #475569 !important; /* Bold outer border */
            border-radius: 8px !important;
            overflow: hidden;
        }
        
        .premium-table thead th {
            background-color: #f1f5f9 !important;
            color: #1e293b !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            border-bottom: 3px solid #475569 !important; /* Thick bottom border under headers */
            border-right: 2px solid #cbd5e1 !important;
            padding: 12px 10px !important;
        }
        
        .premium-table thead th:last-child {
            border-right: none !important;
        }
        
        .premium-table tbody td {
            border: 2px solid #e2e8f0 !important; /* Bold borders between all cells */
            padding: 12px 10px !important;
            font-size: 13px !important;
            color: #334155 !important;
            background-color: #ffffff;
        }
        
        .premium-table tbody tr:hover td {
            background-color: #f8fafc !important; /* Elegant row hover background */
        }
        
        /* Table Responsive border fix */
        .table-responsive {
            border-radius: 8px !important;
            overflow: hidden;
        }
    </style>

    <div class="main-content">
        <div class="main-content-inner">
            <div class="container-fluid py-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-0 text-dark">Sales Management</h4>
                        <p class="text-muted mb-0 small">View and manage your sales invoices and bookings</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a class="btn btn-outline-danger px-3 shadow-sm fw-medium align-items-center d-inline-flex gap-2"
                            href="{{ route('sale.return.index') }}">
                            <i class="fas fa-undo"></i> All Returns
                        </a>
                        <a class="btn btn-outline-primary px-3 shadow-sm fw-medium align-items-center d-inline-flex gap-2"
                            href="{{ url('bookings') }}">
                            <i class="fas fa-bookmark"></i> All Bookings
                        </a>
                        @can('sales.create')
                            <a class="btn btn-primary px-4 shadow-sm fw-medium align-items-center d-inline-flex gap-2 animate__animated animate__fadeIn"
                                href="{{ route('sale.add') }}">
                                <i class="fas fa-plus"></i> Add Sale
                            </a>
                        @endcan
                    </div>
                </div>

                {{-- Status Filters --}}
                <div class="mb-4 d-flex gap-2">
                    <a href="{{ route('sale.index', ['status' => 'all']) }}"
                        class="btn btn-sm {{ request('status') == 'all' || !request('status') ? 'btn-secondary' : 'btn-outline-secondary' }} rounded-3 shadow-sm">
                        All
                    </a>
                    <a href="{{ route('sale.index', ['status' => 'posted']) }}"
                        class="btn btn-sm {{ request('status') == 'posted' ? 'btn-success' : 'btn-outline-success' }} rounded-3 shadow-sm">
                        Posted
                    </a>
                    <a href="{{ route('sale.index', ['status' => 'draft']) }}"
                        class="btn btn-sm {{ request('status') == 'draft' ? 'btn-warning text-dark' : 'btn-outline-warning' }} rounded-3 shadow-sm">
                        Draft
                    </a>
                    <a href="{{ route('sale.index', ['status' => 'booked']) }}"
                        class="btn btn-sm {{ request('status') == 'booked' ? 'btn-info text-white' : 'btn-outline-info' }} rounded-3 shadow-sm">
                        Booked
                    </a>
                    <a href="{{ route('sale.index', ['status' => 'returned']) }}"
                        class="btn btn-sm {{ request('status') == 'returned' ? 'btn-danger' : 'btn-outline-danger' }} rounded-3 shadow-sm">
                        Returned
                    </a>
                </div>

                <div class="card premium-card">
                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 mb-4">
                                <i class="fas fa-check-circle"></i>
                                <span>{{ session('success') }}</span>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger d-flex align-items-center gap-2 rounded-3 mb-4">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ session('error') }}</span>
                                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- AJAX Filter Panel --}}
                        <div class="card filter-panel mb-4">
                            <div class="card-body p-0">
                                <form id="filterForm" class="row g-3 align-items-end" autocomplete="off">
                                    <div class="col-md-2">
                                        <label class="form-label mb-1">Quick Filter</label>
                                        <select id="quick_filter" class="form-select">
                                            <option value="custom">Custom Range</option>
                                            <option value="daily">Daily (Today)</option>
                                            <option value="weekly">Weekly (This Week)</option>
                                            <option value="monthly">Monthly (This Month)</option>
                                            <option value="yearly">Yearly (This Year)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label mb-1">From Date</label>
                                        <input type="text" class="form-control datepicker-custom bg-white" name="from_date" id="filter_from_date" placeholder="dd/mm/yyyy">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label mb-1">To Date</label>
                                        <input type="text" class="form-control datepicker-custom bg-white" name="to_date" id="filter_to_date" placeholder="dd/mm/yyyy">
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label mb-1">Bill#</label>
                                        <input type="text" class="form-control" name="bill_no" id="filter_bill_no" placeholder="Search bill...">
                                    </div>
                                    <div class="col-md-1">
                                        <label class="form-label mb-1">M.Bill# / Ref</label>
                                        <input type="text" class="form-control" name="reference" id="filter_reference" placeholder="M.Bill...">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label mb-1">Customer</label>
                                        <select class="form-select" name="customer_id" id="filter_customer_id">
                                            <option value="">All Customers</option>
                                            @foreach ($customers as $c)
                                                <option value="{{ $c->id }}">{{ $c->customer_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex gap-2">
                                        <button type="button" class="btn btn-premium-secondary w-50" id="btnReset">
                                            <i class="fas fa-undo me-1"></i>Reset
                                        </button>
                                        <button type="submit" class="btn btn-premium-primary w-50" id="btnSearch">
                                            <i class="fas fa-search me-1"></i>Search
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="sales-table" class="table table-hover align-middle datanew premium-table" style="width:100%">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 ps-3 rounded-start text-secondary fw-semibold text-uppercase small">Bill#</th>
                                        <th class="py-3 text-secondary fw-semibold text-uppercase small">Customer</th>
                                        <th class="py-3 text-secondary fw-semibold text-uppercase small">M.Bill</th>
                                        <th class="py-3 text-secondary fw-semibold text-uppercase small">Products</th>
                                        <th class="py-3 text-secondary fw-semibold text-uppercase small text-center">Qty</th>
                                        <th class="py-3 text-secondary fw-semibold text-uppercase small text-end">Gross</th>
                                        <th class="py-3 text-secondary fw-semibold text-uppercase small text-end">Inline Disc</th>
                                        <th class="py-3 text-secondary fw-semibold text-uppercase small text-end">Add. Disc</th>
                                        <th class="py-3 text-secondary fw-semibold text-uppercase small text-end">Net Total</th>
                                        <th class="py-3 text-secondary fw-semibold text-uppercase small">Date</th>
                                        <th class="py-3 text-secondary fw-semibold text-uppercase small">Status</th>
                                        <th class="py-3 pe-3 rounded-end text-secondary fw-semibold text-uppercase small text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="salesTableBody">
                                    @include('admin_panel.sale.partials.sales_table_body')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Function to initialize DataTable
            function initDataTable() {
                if ($.fn.DataTable.isDataTable('.datanew')) {
                    $('.datanew').DataTable().destroy();
                }
                $('.datanew').DataTable({
                    "pageLength": 10,
                    "order": [],
                    "language": {
                        "search": "",
                        "searchPlaceholder": "Search sales..."
                    },
                    "dom": "<'row mb-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                });
            }

            // Initial call
            initDataTable();

            // Submit form via AJAX
            // Quick Filter Logic
            $(document).on('change', '#quick_filter', function() {
                let val = $(this).val();
                let today = new Date();
                let start = new Date();
                let end = new Date();

                if (val === 'daily') {
                    // Start and end are both today
                } else if (val === 'weekly') {
                    // Start is first day of current week (let's use Monday)
                    let day = today.getDay(); // 0 is Sunday, 1 is Monday
                    let diff = today.getDate() - day + (day === 0 ? -6 : 1);
                    start.setDate(diff);
                } else if (val === 'monthly') {
                    // Start is 1st of current month
                    start.setDate(1);
                } else if (val === 'yearly') {
                    // Start is Jan 1st of current year
                    start.setMonth(0, 1);
                } else if (val === 'custom') {
                    return; // Don't change dates for custom
                }

                let pickerFrom = document.getElementById('filter_from_date')._flatpickr;
                let pickerTo = document.getElementById('filter_to_date')._flatpickr;
                if(pickerFrom) pickerFrom.setDate(start);
                else $("#filter_from_date").val(start.toISOString().split('T')[0]);
                
                if(pickerTo) pickerTo.setDate(end);
                else $("#filter_to_date").val(end.toISOString().split('T')[0]);
                
                $('#filterForm').trigger('submit');
            });

            $('#filterForm').on('submit', function(e) {
                e.preventDefault();
                const $btn = $('#btnSearch');
                const origHtml = $btn.html();
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Searching...');

                let formData = $(this).serialize();
                let urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('status')) {
                    formData += '&status=' + urlParams.get('status');
                }

                $.ajax({
                    url: '{{ route("sale.index") }}',
                    method: 'GET',
                    data: formData,
                    success: function(response) {
                        $btn.prop('disabled', false).html(origHtml);
                        
                        // 1. Destroy DataTable first to release DOM bindings
                        if ($.fn.DataTable.isDataTable('.datanew')) {
                            $('.datanew').DataTable().destroy();
                        }
                        
                        // 2. Safely replace the table body HTML
                        $('#salesTableBody').html(response.html);
                        
                        // 3. Re-initialize the DataTable on the new HTML
                        initDataTable();
                    },
                    error: function(err) {
                        $btn.prop('disabled', false).html(origHtml);
                        Swal.fire('Error', 'Failed to retrieve filtered list.', 'error');
                    }
                });
            });

            // Reset form
            $('#btnReset').on('click', function() {
                $('#filterForm')[0].reset();
                $('#filterForm').trigger('submit');
            });

            // Confirm Booking Action
            $(document).on('click', '.confirm-booking-btn', function(e) {
                e.preventDefault();
                let form = $(this).closest("form");

                Swal.fire({
                    title: "Confirm Booking?",
                    text: "Are you sure you want to convert this booking to a posted sale? This will update stocks and post ledgers.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Yes, Confirm it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
