@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        You are logged in admin dashboard!
                        <hr>
                        <div>
                            <a href="/admin/users/list">go users click here</a><hr>
                            <a href="/admin/goods/list">go goods click here</a><hr>
                            <a href="/admin/report">go report click here</a><hr>
                            <a href="/admin/navigate">go navigate click here</a><hr>
                            <a href="/admin/category">go category click here</a><hr>
                            <a href="/admin/administrator/list">go administrator click here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection