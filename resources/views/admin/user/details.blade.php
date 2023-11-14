@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid px-2 px-md-4">
        <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
            <span class="mask bg-gradient-info opacity-6"></span>
        </div>
        <div class="card card-body mx-3 mx-md-4 mt-n6">
            <div class="row gx-4 mb-2">
                <div class="col-auto">
                    <div class="avatar avatar-xxl position-relative">
                        <img src="{{ $user->photo ? asset($user->photo) : asset('assets/img/user-blue.jpg') }}" alt="profile_image" class="w-100 h-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ $user->fname . ' ' . $user->lname  }}
                        </h5>
                        <p class="mb-0 font-weight-normal text-muted text-sm">
                            {{ $user->email }}
                        </p>
                        <p class="mb-0 font-weight-normal text-muted text-sm">
                            ({{ $user->country_code }}) {{ $user->phone }}
                        </p>
                    </div>
                </div>
               
            </div>
            <div class="row justify-content-right">
                <div class="col-lg-12 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-1 py-1 active " data-bs-toggle="tab" href="#hotels-tab" role="tab" aria-selected="true">
                                    <span class="ms-1">{{ trans('msg.admin.Hotels') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-1 py-1 " data-bs-toggle="tab" href="#flights-tab" role="tab" aria-selected="false">
                                    <span class="ms-1">{{ trans('msg.admin.Flights') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-1 py-1 " data-bs-toggle="tab" href="#activities-tab" role="tab" aria-selected="false">
                                    <span class="ms-1">{{ trans('msg.admin.Activities') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-1 py-1 " data-bs-toggle="tab" href="#transfers-tab" role="tab" aria-selected="false">
                                    <span class="ms-1">{{ trans('msg.admin.Transfers') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-1 py-1 " data-bs-toggle="tab" href="#visa-tab" role="tab" aria-selected="false">
                                    <span class="ms-1">{{ trans('msg.admin.Visa') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-1 py-1 " data-bs-toggle="tab" href="#umrah-tab" role="tab" aria-selected="false">
                                    <span class="ms-1">{{ trans('msg.admin.Umrah') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-1 py-1 " data-bs-toggle="tab" href="#ziyarat-tab" role="tab" aria-selected="false">
                                    <span class="ms-1">{{ trans('msg.admin.Ziyarat') }}</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- Hotels Tab Content -->
                            <div class="tab-pane fade show active" id="hotels-tab" role="tabpanel" aria-labelledby="hotels-tab">
                                <div class="col-md-12 mt-2">
                                    <h5>Hotel Bookings</h5>
                                </div>
                            </div>
                            
                            <!-- Flights Tab Content -->
                            <div class="tab-pane fade" id="flights-tab" role="tabpanel" aria-labelledby="flights-tab">
                                <div class="col-md-12 mt-2">
                                    <h5>Flight Bookings</h5>
                                </div>
                            </div>
                    
                            <!-- Activities Tab Content -->
                            <div class="tab-pane fade" id="activities-tab" role="tabpanel" aria-labelledby="activities-tab">
                                <div class="col-md-12 mt-2">
                                    <h5>Activity Bookings</h5>
                                </div>
                            </div>

                            <!-- Transfers Tab Content -->
                            <div class="tab-pane fade" id="transfers-tab" role="tabpanel" aria-labelledby="transfers-tab">
                                <div class="col-md-12 mt-2">
                                    <h5>Transfer Bookings</h5>
                                </div>
                            </div>

                            <!-- Visa Tab Content -->
                            <div class="tab-pane fade" id="visa-tab" role="tabpanel" aria-labelledby="visa-tab">
                                <div class="col-md-12 mt-2">
                                    <h5>Visa Bookings</h5>
                                </div>
                            </div>

                            <!-- Umrah Tab Content -->
                            <div class="tab-pane fade" id="umrah-tab" role="tabpanel" aria-labelledby="umrah-tab">
                                <div class="col-md-12 mt-2">
                                    <h5>Umrah Bookings</h5>
                                </div>
                            </div>

                            <!-- Ziyarat Tab Content -->
                            <div class="tab-pane fade" id="ziyarat-tab" role="tabpanel" aria-labelledby="ziyarat-tab">
                                <div class="col-md-12 mt-2">
                                    <h5>Ziyarat Bookings</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
<script>
    var tab = new bootstrap.Tab(document.querySelector('#hotels-tabs'));
    tab.show();
</script>
@endsection