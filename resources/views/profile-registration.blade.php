@extends('auth-layout.base')

@section('body')
<div id="app" class="container shadow-sm mt-5">
    <Profile></Profile>
</div>
@endsection

@section('script')
<script src="{{url('/js/app.js')}}" type="text/javascript"></script>
@endsection
