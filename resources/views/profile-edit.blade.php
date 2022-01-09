@extends('layout.base')

@section('body')
<div id="dashboard" class="container shadow-sm mt-5">
    <ProfileEdit></ProfileEdit>
</div>
@endsection

@section('script')
<script src="{{url('/js/dashboard.js')}}" type="text/javascript"></script>
@endsection
