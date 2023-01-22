@extends('layout.app')
@section('content')
<div class="user-wrapper">
    <header class="inner-content-header">
        <h4 class="title">User List</h4>
        <a class="btn-add" href="{{route('users.create')}}"><i class="icon fa fa-plus"></i>Add User</a>
    </header>
 
    @if(session()->has('message'))
    <div class="alert alert-{{session('message')[1]}}">{{session('message')[0]}}</div>
    @endif
    <div class="table-responsive table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>   
            </thead>
            <tbody>
                @foreach($users as $user) 
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{$user->fname}}</td>
                    <td>{{$user->lname}}</td>
                    <td>{{$user->email}}</td>
                    <td class="d-flex align-items-center">
                        <a class="edit-link" href="#"><i class="icon icon-edit fa fa-edit"></i></a>
                        <form>
                            <button onclick="return confirm('Are you sure you want to delete that user')" class="btn-delete" type="submit"><i class="icon icon-delete fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection