@extends('auth-layout.base')

@section('body')
<div class="container shadow-sm mt-5">
    <div class="row">
        <div class="col-sm-8 mx-auto">
            <h2 class="mb-4">Profile Login</h2>
            <hr />
            @if(Session::has('message'))
            <div
                class="alert alert-danger alert-dismissible mb-3"
            >
                <button type="button" class="close" data-dismiss="alert">
                    &times;
                </button>
                {{ Session::get('message') }}
            </div>
            @endif
            <form class="form" method="post" action="{{url('/profile/login')}}">
                @csrf
                <div class="form-group">
                    <label>Email address</label>
                    <input type="text" name="email" class="form-control" required/>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required/>
                </div>
                <div class="form-group">
                    <a href="{{url('/registration')}}" class="btn btn-link">Create Profile</a>
                </div>
                <div class="form-group text-center mt-3">
                    <div class="col-sm-6 mx-auto">
                        <button type="submit" class="btn btn-success btn-block">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
