@extends('admin.layouts.app')

@section('content')
    <div class="card radius-10">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <img src="{{ asset($user->photo) ? asset($user->photo) : asset('assets/images/avatars/no-image.png')}}" class="align-self-center rounded-circle p-1 border" width="90" height="90" alt="...">
                <div class="flex-grow-1 ms-3">
                    <h5 class="mt-0">{{ $user->fname . ' ' . $user->lname }}</h5>
                    <p class="mb-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla</p>
                    <p class="mb-0">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
@endsection