<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0">
            <a class="text-default collapsed" data-toggle="collapse" href="#accordion-item-icon-right-<?= $count; ?>" aria-expanded="false">
                {{ $title }}
                {!! isset($user) ? '<span class="text-danger">(' . $user->getDirectPermissions()->count() . ')</span>' : '' !!}
            </a>
        </h6>
    </div>
    <div class="collapse" id="accordion-item-icon-right-<?= $count; ?>" data-parent="#accordionRightIcon">
        <div class="card-body">

            <div class="row">
                @foreach($permissions as $perm)
                    <?php
                        $per_found = null;

                        if( isset($role) ) {
                            $per_found = $role->hasPermissionTo($perm->name);
                        }

                        if( isset($user)) {
                            //$per_found = $user->hasDirectPermission($perm->name);
                        }
                    ?>
                    
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label class="checkbox checkbox-primary">
                                {!! Form::checkbox("permissions[]", $perm->name, $per_found, isset($options) ? $options : []) !!} <span>{{ $perm->name }}</span><span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                @endforeach
            
                <div class="col-md-12">
                    @if($role->name !== 'Admin')
                        @can('edit_roles')
                        {!! Form::button('Save Permissions', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button', 'data-style' => 'expand-right','style' => 'margin-left:2em']) !!}
                        @endcan
                    @endif
                </div>

            </div>
            
        </div>
    </div>
</div>
