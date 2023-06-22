@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend-breadcrumb-item>

    <x-backend-breadcrumb-item type="active">{{ __($module_action) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <x-backend.section-header>
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>

            {{-- <x-slot name="subtitle">
                @lang(":module_name Management Dashboard", ['module_name'=>Str::title($module_name)])
            </x-slot> --}}
            {{-- <x-slot name="toolbar">
                <x-backend.buttons.return-back />
                <x-buttons.show route='{!!route("backend.$module_name.show", $$module_name_singular)!!}' title="{{__('Show')}} {{ ucwords(Str::singular($module_name)) }}" class="ms-1" />
            </x-slot> --}}
        </x-backend.section-header>
        <hr>

        <div class="row mt-4">
            <div class="col">
                {{ html()->modelForm($user, 'PATCH', route('backend.users.update', $user->id))->class('form-horizontal user-edit-form')->open() }}

                <div class="row mb-3">
                    <?php
                    $field_name = 'email';
                    $field_lable = __('labels.backend.users.fields.email');
                    $field_placeholder = $field_lable;
                    $required = "required";
                    ?>
                    <div class="col-12 col-sm-2">
                        <div class="form-group">
                            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
                        </div>
                    </div>
                    <div class="col-12 col-sm-10">
                        <div class="form-group">
                            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <?php
                    $field_name = 'password';
                    $field_lable = __('labels.backend.users.fields.password');
                    $field_placeholder = $field_lable;
                    $required = "required";
                    ?>
                    <div class="col-12 col-sm-2">
                        <div class="form-group">
                            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
                        </div>
                    </div>
                    <div class="col-12 col-sm-10">
                        <div class="form-group">
                            <a href="{{ route('backend.users.changePassword', $user->id) }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-key"></i> Change password</a>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <?php
                    $field_name = 'profile';
                    $field_lable = __('Profile');
                    $field_placeholder = $field_lable;
                    $required = "";
                    ?>
                    <div class="col-12 col-sm-2">
                        <div class="form-group">
                            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
                        </div>
                    </div>
                    <div class="col-12 col-sm-10">
                        <div class="form-group">
                            <a href="{{ route('backend.users.profileEdit', $user->id) }}" class="btn btn-outline-primary btn-sm"><i class="fas fa-user"></i> Update Profile</a>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <?php
                    $field_name = 'confirmed';
                    $field_lable = __('labels.backend.users.fields.confirmed');
                    $field_placeholder = $field_lable;
                    $required = "";
                    ?>
                    <div class="col-12 col-sm-2">
                        <div class="form-group">
                            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
                        </div>
                    </div>
                    <div class="col-12 col-sm-10">
                        <div class="form-group">
                            @if ($user->email_verified_at == null)
                            <a href="{{route('backend.users.emailConfirmationResend', $user->id)}}" class="btn btn-outline-primary btn-sm " data-toggle="tooltip" title="Send Confirmation Email"><i class="fas fa-envelope"></i> Send Confirmation Email</a>
                            @else
                            {!! $user->confirmed_label !!}
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mb-3 d-none">
                    <?php
                    $field_name = 'social';
                    $field_lable = __('labels.backend.users.fields.social');
                    $field_placeholder = $field_lable;
                    $required = "";
                    ?>
                    <div class="col-12 col-sm-2">
                        <div class="form-group">
                            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
                        </div>
                    </div>
                    <div class="col-12 col-sm-10">
                        <div class="form-group">
                            @forelse ($user->providers as $provider)
                            <li>
                                <i class="fab fa-{{ $provider->provider }}"></i> {{ label_case($provider->provider) }}
                            </li>
                            @empty
                            {{ __("No social profile added!") }}
                            @endforelse
                        </div>
                    </div>
                </div>

                @if($isClient)
                <div class="form-group row mb-3">
                    {{ html()->label(__('Role'))->class('col-sm-2 form-control-label') }}
                    <input class="form-control" type="hidden" name="client" id="client" value="{{$currentUserId}}" />
                    <div class="col">
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                @if ($roles->count())
                                @foreach($roles as $role)
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <div class="checkbox">
                                            {{ html()->label(html()->radio('roles[]', in_array($role->name, $userRoles), $role->name)->id('role-'.$role->id) . "&nbsp;". ucwords($role->name) . "&nbsp;(".$role->name.")")->for('role-'.$role->id) }}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        @if ($role->id != 1)
                                        @if ($role->permissions->count())
                                        @foreach ($role->permissions as $permission)
                                        <i class="far fa-check-circle mr-1"></i>&nbsp;{{ $permission->name }}&nbsp;
                                        @endforeach
                                        @else
                                        @lang('None')
                                        @endif
                                        @else
                                        @lang('All Permissions')
                                        @endif
                                    </div>
                                </div>
                                <!--card-->
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="form-group row mb-3">
                    {{ html()->label(__('Abilities'))->class('col-sm-2 form-control-label') }}
                    <div class="col">
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="card card-accent-primary">
                                    <div class="card-header">
                                        @lang('Roles')
                                    </div>
                                    <div class="card-body">
                                        @if ($roles->count())
                                        @foreach($roles as $role)
                                        <div class="card mb-3">
                                            <div class="card-header">
                                                <div class="checkbox">
                                                    {{ html()->label(html()->radio('roles[]', in_array($role->name, $userRoles), $role->name)->id('role-'.$role->id) . "&nbsp;". ucwords($role->name) . "&nbsp;(".$role->name.")")->for('role-'.$role->id) }}
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                @if ($role->id != 1)
                                                @if ($role->permissions->count())
                                                @foreach ($role->permissions as $permission)
                                                <i class="far fa-check-circle mr-1"></i>&nbsp;{{ $permission->name }}&nbsp;
                                                @endforeach
                                                @else
                                                @lang('None')
                                                @endif
                                                @else
                                                @lang('All Permissions')
                                                @endif
                                                @if ($role->id == 4 && $clients->count())
                                                <div>
                                                    <hr />
                                                    <select class="form-select client-select my-1" aria-label="Clients" name="client">
                                                        <option disabled>Select a client to attach this user</option>
                                                        @foreach ($clients as $client)
                                                        <option value="{{$client->id}}" @if($user->client == $client->id)selected @endif>{{$client->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!--card-->
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-sm-6">
                                <div class="card card-accent-info">
                                    <div class="card-header">
                                        @lang('Permissions')
                                    </div>
                                    <div class="card-body">
                                        @if ($permissions->count())
                                        @foreach($permissions as $permission)
                                        <div class="checkbox">
                                            {{ html()->label(html()->checkbox('permissions[]', in_array($permission->name, $userPermissions), $permission->name)->id('permission-'.$permission->id) . ' ' . $permission->name)->for('permission-'.$permission->id) }}
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                @endif

                {{ html()->closeModelForm() }}
                <div class="row mb-3">
                    {{-- <div class="col-sm-4">
                        <div class="form-group">
                            <x-backend.buttons.save />
                        </div>
                    </div> --}}

                    <div class="col-sm-12">
                        <div class="float-end">
                            @if ($$module_name_singular->status != 2 && $$module_name_singular->id != 1)
                            {{-- <a href="{{route('backend.users.block', $$module_name_singular)}}" class="btn btn-danger" data-method="PATCH" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.block')}}" data-confirm="Are you sure?"><i class="fas fa-ban"></i> Block</a> --}}
                            <button
                                class="btn btn-danger btn-user-block"
                                data-url="{{route('backend.users.block', $$module_name_singular)}}"
                                data-method="POST"
                                data-token="{{csrf_token()}}"
                                data-toggle="tooltip"
                                title="{{__('labels.backend.block')}}"
                                data-confirm="Are you sure?"
                            >
                                <i class="fas fa-ban"></i> Block
                            </button>
                            @endif
                            @if ($$module_name_singular->status == 2)
                            {{-- <a href="{{route('backend.users.unblock', $$module_name_singular)}}" class="btn btn-info" data-method="PATCH" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.unblock')}}" data-confirm="Are you sure?"><i class="fas fa-check"></i> Unblock</a> --}}
                            <button
                                class="btn btn-info btn-user-unblock"
                                data-url="{{route('backend.users.unblock', $$module_name_singular)}}"
                                data-method="POST"
                                data-token="{{csrf_token()}}"
                                data-toggle="tooltip"
                                title="{{__('labels.backend.unblock')}}"
                                data-confirm="Are you sure?"
                            >
                                <i class="fas fa-check"></i> Unblock
                            </button>
                            @endif
                            @if ($$module_name_singular->email_verified_at == null)
                            <a href="{{route('backend.users.emailConfirmationResend', $$module_name_singular->id)}}" class="btn btn-primary" data-toggle="tooltip" title="Send Confirmation Email"><i class="fas fa-envelope"></i></a>
                            @endif
                            @if($$module_name_singular->id != 1)
                            {{-- <a href="{{route("backend.$module_name.destroy", $$module_name_singular)}}" class="btn btn-danger" data-method="DELETE" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.delete')}}"><i class="fas fa-trash-alt"></i> Delete</a> --}}
                            <button
                                class="btn btn-danger btn-user-delete"
                                data-url="{{route("backend.$module_name.destroy", $$module_name_singular)}}"
                                data-redirect-url="{{route('backend.users.index')}}"
                                data-method="DELETE"
                                data-token="{{csrf_token()}}"
                                data-toggle="tooltip"
                                title="{{__('labels.backend.delete')}}"
                                data-confirm="Are you sure?"
                            >
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                            @endif
                            <x-backend.buttons.return-back>@lang('Cancel')</x-backend.buttons.return-back>
                            <button class="btn btn-success btn-user-edit-form-save" type="submit"><i class="fas fa-save"></i>&nbsp; Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.col-->
        </div>
        <!--/.row-->
    </div>
    <div class="card-footer">
        <div class="row mb-3">
            <div class="col">
                <small class="float-end text-muted">
                    @lang('Updated') {{$user->updated_at->diffForHumans()}},
                    @lang('Created at') {{$user->created_at->isoFormat('LLLL')}}
                </small>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="userBlockDeleteModal" tabindex="-1" aria-labelledby="userBlockDeleteModalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userBlockDeleteModalTitle">Attention!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBodyText">
                Are you sure you want to delete the current user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmUserBlockDelete">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(function() {
        $('.btn-user-edit-form-save').on('click', function() {
            const validator = $('.user-edit-form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                },
                messages: {
                    email: {
                        required: 'Please enter an email',
                        email: 'Invalid email'
                    },
                },
                invalidHandler: function() {
                    console.log( validator.numberOfInvalids() + " field(s) are invalid" );
                    validator.showErrors();
                }
            });
            console.log($('.user-edit-form').valid());

            let isValid = true;
            
            let formData = $('.user-edit-form').serializeArray();
            let isClientSelected = formData.find((item) => item.name === 'client');
            formData.map(function(item, index) {
                if (item.name === 'roles[]' && item.value === 'user' && !isClientSelected) {
                    isValid = false;
                    showToast('error', 'When you select an user role, you should select a Client to attach');
                }
                // console.log(item.name, item.value);
            })
            console.log(formData);
            if (!isValid) {
                return;
            }

            if ($('.user-edit-form').valid()) {
                $('.user-edit-form').submit();
            }
        });

    });
</script>
<style>
    .error {
        color: red;
    }
</style>
@endsection