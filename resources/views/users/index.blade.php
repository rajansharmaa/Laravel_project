@extends('layouts.app')
@push('pg_btn')
@can('create-user')
    <a href="{{ route('users.create') }}" class="btn btn-sm btn-neutral">Create New User</a>
@endcan
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-header bg-transparent">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3 class="mb-0">All Users</h3>
                        </div>
                        <div class="col-lg-4">
                    {!! Form::open(['route' => 'users.index', 'method'=>'get']) !!}
                        <div class="form-group mb-0">
                        {{ Form::text('search', request()->query('search'), ['class' => 'form-control form-control-sm', 'placeholder'=>'Search users']) }}
                    </div>
                    {!! Form::close() !!}
                </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div>
                            <table class="table table-hover align-items-center">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Verified at</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody class="list">
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">
                                            {{$user->name}}
                                        </th>
                                        <td class="budget">
                                            {{$user->email}}
                                        </td>
                                        <td>
                                            @if($user->status)
                                                <span class="badge badge-pill badge-lg badge-success">Active</span>
                                            @else
                                                <span class="badge badge-pill badge-lg badge-danger">Disabled</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{$user->email_verified_at}}
                                        </td>
                                        <td>
                                            <div class="avatar-group">
                                                @if ($user->profile_photo)
                                                <img alt="Image placeholder"
                                                    class="avatar avatar-sm rounded-circle"
                                                    data-toggle="tooltip" data-original-title="{{$user->name}}"
                                                    src="{{ asset($user->profile_photo) }}">
                                                @else
                                                <i class="far avatar avatar-sm rounded-circle fa-user"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @can('destroy-user')
                                            {!! Form::open(['route' => ['users.destroy', $user],'method' => 'delete',  'class'=>'d-inline-block dform']) !!}
                                            @endcan
                                            @can('view-user')
                                            <a class="btn btn-primary btn-sm m-1" data-toggle="tooltip" data-placement="top" title="View and edit user details" href="{{route('users.show', $user)}}">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                            @endcan
                                            @can('update-user')
                                            <a class="btn btn-info btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Edit user details" href="{{route('users.edit',$user)}}">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                            </a>
                                            @endcan
                                            @can('destroy-user')
                                                <button type="submit" class="btn delete btn-danger btn-sm m-1" data-toggle="tooltip" data-placement="top" title="Delete user" href="">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot >
                                <tr>
                                    <td colspan="6">
                                        {{$users->links()}}
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        jQuery(document).ready(function(){
            $('.delete').on('click', function(e){
                e.preventDefault();
                let that = jQuery(this);
                jQuery.confirm({
                    icon: 'fas fa-wind-warning',
                    closeIcon: true,
                    title: 'Are you sure!',
                    content: 'You can not undo this action.!',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        confirm: function () {
                            that.parent('form').submit();
                            //$.alert('Confirmed!');
                        },
                        cancel: function () {
                            //$.alert('Canceled!');
                        }
                    }
                });
            })
        })

    </script>
@endpush
