@extends('layouts.app')
@push('pg_btn')
    <a href="{{route('category.index')}}" class="btn btn-sm btn-neutral">All Categories</a>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-body">
                    @can('update-category')
                    {!! Form::open(['route' => ['category.update', $category], 'method'=>'put']) !!}
                    @endcan
                    <h6 class="heading-small text-muted mb-4">Category information</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('category_name', 'Category Name', ['class' => 'form-control-label']) }}
                                        {{ Form::text('category_name', $category->category_name, ['class' => 'form-control']) }}
                                    </div>
                                </div>

                            </div>

                        </div>


                        <hr class="my-4" />
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        {!! Form::hidden('status', 0) !!}
                                        <input type="checkbox" name="status" value="1" {{ $category->status ? 'checked' : ''}} class="custom-control-input" id="status">
                                        {{ Form::label('status', 'Status', ['class' => 'custom-control-label']) }}
                                    </div>
                                </div>
                                @can('update-user')
                                <div class="col-md-12">
                                    {{ Form::submit('Submit', ['class'=> 'mt-5 btn btn-primary']) }}
                                </div>
                                @endcan
                            </div>
                        </div>
                    @can('update-category')
                    {!! Form::close() !!}
                    @endcan
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
