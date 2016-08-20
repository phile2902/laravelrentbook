@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading text-center"><h3>List of members</h3></div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td><a href="profile/{{$user->id}}">{{$user->name}}</a></td>
                            <td>{{$user->email}}</td>
                        </tr> 
                        @endforeach
                    </tbody>
                </table>   
            </div>
        </div>       
    </div>
</div>
@endsection

