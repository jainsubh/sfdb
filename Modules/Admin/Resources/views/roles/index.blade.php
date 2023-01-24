@extends('admin::layouts.master')
@section('before-css')
    
@endsection

@section('main-content')
   <div class="breadcrumb">
        <h1>Roles</h1>
        <ul>
            <li><a href="{{ route('users.index') }}">Roles</a></li>
            <li>Add</li>
        </ul>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12">
                    
                    <!-- Modal -->
                    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel">
                        <div class="modal-dialog" role="document">
                            {!! Form::open(['method' => 'post']) !!}

                            <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title" id="roleModalLabel">Role</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    
                                </div>
                                <div class="modal-body">
                                    <!-- name Form Input -->
                                    <div class="form-group @if ($errors->has('name')) has-error @endif">
                                        {!! Form::label('name', 'Name') !!}
                                        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Role Name']) !!}
                                        @if ($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                    <!-- Submit Form Button -->
                                    {!! Form::button('Submit', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']) !!}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>

                    @can('create_roles')
                        <a href="#" class="btn btn-primary btn-icon m-1" data-toggle="modal" data-target="#roleModal"> <em class="fas fa-plus"></em> New Role</a> <br /><br />
                    @endcan
                    

                    <div class="accordion" id="accordionRightIcon">
                        <?php $count = 1 ?>
                        @forelse ($roles as $role)
                            <!-- /right control icon-->
                            {!! Form::model($role, ['method' => 'PUT', 'route' => ['roles.update',  $role->id ], 'class' => 'm-b']) !!}
                            
                            @if($role->name === 'Admin')
                                @include('admin::roles.permission', [
                                            'title' => $role->name .' Permissions',
                                            'options' => ['disable'],
                                            'count' => $count ])
                            @else
                                @include('admin::roles.permission', [
                                            'title' => $role->name .' Permissions',
                                            'model' => $role,
                                            'count' => $count ])
                            @endif
                            <?php ++$count; ?>
                            {!! Form::close() !!}

                        @empty
                            <p>No Roles defined.</p>
                        @endforelse
                    </div>     
                
        </div>
    </div>

@endsection

@section('page-js')

@endsection

@section('bottom-js')
@endsection
