@extends('master.layouts.main')

@section('title','Admin')

@section('content')
<div class="page-heading">
    <h3>List Admin</h3>
</div>
<div class="page-content">
    <div class="card">
        <div class="table-responsive p-3">
            <a href="{{ route('admin.create')}}" class="btn btn-primary"> + Tambahkan </a>
            <br />
            @if(session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success')}}
                </div>
            @endif
            <br />
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($data as $row)
                    <tr>
                        <td>{{ $loop->iteration  + $data->firstItem() - 1 }}</td>
                        <td>
                            @if($row->image)
                            <img src="{{ asset('images/profiles/' . $row->image) }}" alt="Logo" width="35" height="35" class="avatar">
                            @else
                            <img src="/assets/img/team/team-1.jpg" alt="Logo" width="35" height="35" class="avatar">
                            @endif
                        </td>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->email }}</td>
                        <td class="d-flex" >
                            <a href="{{ route('admin.edit', ['user' => $row->id]) }}" class="btn btn-warning mx-1"><span class="material-symbols-outlined"> edit </span></a>
                            <form method="post" action="{{ route('admin.delete',['user' => $row->id]) }}">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger mx-1" onclick="return confirm('Are you sure?');"><span class="material-symbols-outlined"> delete </span></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex-coloum justify-content-center">
                {!! $data->links() !!}
            </div>
        </div>
    </div>
</div>

@endsection()