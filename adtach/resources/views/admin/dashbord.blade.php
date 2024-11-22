@extends('layout.app')
@extends('admin.nav')
@extends('admin.saidebar')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    @if (Auth::user()->role === 'admin')
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3> ${{ $price }} </h3>

                                    <p>Total Sales</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <!-- ./col -->

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3> {{ $userCount }} </h3>

                                    <p>User Registrations</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('viewUserTable') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <h3> {{ $lead }} </h3>

                                    <p>Total Agents Lead Counts</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('viewAgentLeadlTable') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3> {{ $sale }} </h3>

                                    <p>Total Agents Sales Counts</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="{{ route('viewAgentSaleTable') }}" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3> {{ $trial }} </h3>

                                <p>Total Agents Trial Counts</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('viewAgentTrialTable') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3> {{ $help }} </h3>
                                <p>Total Help Request</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('viewHelpRequestTableDashboard') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        {{-- <div class="content-wrapper"> --}}

        {{-- @if ($customerExpriDate->isEmpty())
        @else
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-3 ">
                            <h1 class="m-0 d-inline">Customer Expri Days Report</h1>
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <div class='container-fluid'>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>CUSTOMER NAME</th>
                                        <th>CUSTOMER NUMBER</th>
                                        <th>CUSTOMER EMAIL</th>
                                        <th>REMARKS</th>
                                        <th>STATUS</th>
                                        <th>MAC ADDRESS</th>
                                        <th>Expri STATUS</th>
                                        <th>AGENT NAME</th>
                                        <th>ACTIOLN</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customerExpriDate as $index => $customer)
                                        @if (Auth::user()->role === 'admin')
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td> {{ $customer->customer_name }} </td>
                                                <td>{{ $customer->customer_number }}</td>
                                                <td>{{ $customer->customer_email }}</td>
                                                <td>{{ $customer->remarks }}</td>
                                                <td>
                                                    @if ($customer->status === 'sale')
                                                        <span class="bg-success py-1 px-2 rounded">Sale</span>
                                                    @elseif($customer->status === 'trial')
                                                        <span class="bg-danger py-1 px-2 rounded">Trial</span>
                                                    @endif
                                                </td>
                                                <td> {{ $customer->make_address }} </td>
                                                <td><span class="bg-danger py-1 px-2 rounded">
                                                        {{ $customer->active_status }}
                                                    </span></td>
                                                <td> {{ $customer->user_name }} </td>
                                                <td>
                                                    @if ($customer->status !== 'sale')
                                                        <a href="{{ route('updateCustomerStatus', $customer->id) }}"
                                                            class="btn btn-success">Sale</a>
                                                    @endif

                                                    <a href="{{ route('deleteCustomerDetails', $customer->id) }}"
                                                        class="btn btn-danger">Cancel</a>
                                                    @if (Auth::user()->role === 'admin')
                                                        @if ($customer->status === 'sale')
                                                            <a
                                                                href="{{ route('viewupdateSaleCustomerStatus', $customer->id) }}"class="btn btn-primary ">Update
                                                                Sale
                                                                Days</a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @else
                                            @if ($customer->status !== 'sale')
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td> {{ $customer->customer_name }} </td>
                                                    <td>{{ $customer->customer_number }}</td>
                                                    <td>{{ $customer->customer_email }}</td>
                                                    <td>{{ $customer->remarks }}</td>
                                                    <td>
                                                        @if ($customer->status === 'sale')
                                                            <span class="bg-success py-1 px-2 rounded">Sale</span>
                                                        @elseif($customer->status === 'trial')
                                                            <span class="bg-danger py-1 px-2 rounded">Trial</span>
                                                        @endif
                                                    </td>
                                                    <td> {{ $customer->make_address }} </td>
                                                    <td><span class="bg-danger py-1 px-2 rounded">
                                                            {{ $customer->active_status }}
                                                        </span></td>
                                                    <td> {{ $customer->user_name }} </td>
                                                    <td>
                                                        @if ($customer->status !== 'sale')
                                                            <a href="{{ route('updateCustomerStatus', $customer->id) }}"
                                                                class="btn btn-success">Sale</a>
                                                        @endif

                                                        <a href="{{ route('deleteCustomerDetails', $customer->id) }}"
                                                            class="btn btn-danger">Cancel</a>
                                                        @if (Auth::user()->role === 'admin')
                                                            @if ($customer->status === 'sale')
                                                                <a
                                                                    href="{{ route('viewupdateSaleCustomerStatus', $customer->id) }}"class="btn btn-primary ">Update
                                                                    Sale
                                                                    Days</a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        @endif --}}

        {{-- @endif --}}
    @endsection
