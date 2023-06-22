<div>
    <div class="row mt-4">
        <div class="col">
            <input type="text" class="form-control my-2" placeholder=" Search" wire:model="searchTerm" />

            <table class="table table-hover table-responsive-sm">
                <thead>
                    <tr>
                        <th>{{ __('labels.backend.users.fields.name') }}</th>
                        <th>{{ __('labels.backend.users.fields.email') }}</th>
                        <th>{{ __('labels.backend.users.fields.status') }}</th>
                        <th>{{ __('labels.backend.users.fields.roles') }}</th>
                        <th>{{ __('labels.backend.users.fields.permissions') }}</th>
                        {{-- <th>{{ __('labels.backend.users.fields.social') }}</th> --}}

                        <th class="text-end">{{ __('labels.backend.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            <strong>
                                <a href="{{route('backend.users.show', $user->id)}}">
                                    {{ $user->name }}
                                </a>
                            </strong>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->status == 1)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-warning text-dark">Blocked</span>
                            @endif
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Confirmed</span>
                            @else
                                <span class="badge bg-danger">Not Confirmed</span>
                            @endif
                            {{-- {!! $user->status_label !!}
                            {!! $user->confirmed_label !!} --}}
                        </td>
                        <td>
                            @if($user->roleName)
                            <ul class="fa-ul">
                                <li><span class="fa-li"><i class="fas fa-check-square"></i></span> {{ ucwords($user->roleName) }}</li>
                            </ul>
                            @endif
                            {{-- @if($user->getRoleNames()->count() > 0)
                            <ul class="fa-ul">
                                @foreach ($user->getRoleNames() as $role)
                                <li><span class="fa-li"><i class="fas fa-check-square"></i></span> {{ ucwords($role) }}</li>
                                @endforeach
                            </ul>
                            @endif --}}
                        </td>
                        <td>
                            @if($this->getPermissionList($user->roleId)->count() > 0)
                            <ul>
                                @foreach ($this->getPermissionList($user->roleId) as $permission)
                                <li>{{ $permission->permName }}</li>
                                @endforeach
                            </ul>
                            @endif
                            {{-- @if($user->getAllPermissions()->count() > 0)
                            <ul>
                                @foreach ($user->getDirectPermissions() as $permission)
                                <li>{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                            @endif --}}
                        </td>
                        {{-- <td>
                            <ul class="list-unstyled">
                                @foreach ($user->providers as $provider)
                                <li>
                                    <i class="fab fa-{{ $provider->provider }}"></i> {{ label_case($provider->provider) }}
                                </li>
                                @endforeach
                            </ul>
                        </td> --}}

                        <td class="text-end">
                            <a href="{{route('backend.users.show', $user->id)}}" class="btn btn-primary btn-sm mt-1" data-toggle="tooltip" title="{{__('labels.backend.show')}}"><i class="fa-sharp fa-solid fa-eye"></i></a>
                            @can('edit_users')
                            <a href="{{route('backend.users.edit', $user->id)}}" class="btn btn-primary btn-sm mt-1" data-toggle="tooltip" title="{{__('labels.backend.edit')}}"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="{{route('backend.users.changePassword', $user->id)}}" class="btn btn-primary btn-sm mt-1 text-white" data-toggle="tooltip" title="{{__('labels.backend.changePassword')}}"><i class="fas fa-key"></i></a>
                            @if ($user->status != 2)
                            {{-- <a href="{{route('backend.users.block', $user->id)}}" class="btn btn-danger btn-sm mt-1" data-method="PATCH" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.block')}}" data-confirm="Are you sure?"><i class="fas fa-ban"></i></a> --}}
                            <button
                                class="btn btn-danger btn-sm mt-1 btn-user-block"
                                data-url="{{route('backend.users.block', $user->id)}}"
                                data-method="POST"
                                data-token="{{csrf_token()}}"
                                data-toggle="tooltip"
                                title="{{__('labels.backend.block')}}"
                                data-confirm="Are you sure?"
                            >
                                <i class="fas fa-ban"></i>
                            </button>
                            @endif
                            @if ($user->status == 2)
                            {{-- <a href="{{route('backend.users.unblock', $user->id)}}" class="btn btn-info btn-sm mt-1" data-method="PATCH" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.unblock')}}" data-confirm="Are you sure?"><i class="fas fa-check"></i></a> --}}
                            <button
                                class="btn btn-primary btn-sm mt-1 btn-user-unblock"
                                data-url="{{route('backend.users.unblock', $user->id)}}"
                                data-method="POST"
                                data-token="{{csrf_token()}}"
                                data-toggle="tooltip"
                                title="{{__('labels.backend.unblock')}}"
                                data-confirm="Are you sure?"
                            >
                            <i class="fas fa-check"></i>
                            </button>
                            @endif
                            {{-- <a href="{{route('backend.users.destroy', $user->id)}}" class="btn btn-danger btn-sm mt-1" data-method="DELETE" data-token="{{csrf_token()}}" data-toggle="tooltip" title="{{__('labels.backend.delete')}}" data-confirm="Are you sure?"><i class="fas fa-trash-alt"></i></a> --}}
                            <button
                                class="btn btn-danger btn-sm mt-1 btn-user-delete"
                                data-url="{{route('backend.users.destroy', $user->id)}}"
                                data-redirect-url="{{route('backend.users.index')}}"
                                data-method="DELETE"
                                data-token="{{csrf_token()}}"
                                data-toggle="tooltip"
                                title="{{__('labels.backend.delete')}}"
                                data-confirm="Are you sure?"
                            >
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            @if ($user->email_verified_at == null)
                            <a href="{{route('backend.users.emailConfirmationResend', $user->id)}}" class="btn btn-primary btn-sm mt-1" data-toggle="tooltip" title="Send Confirmation Email"><i class="fas fa-envelope"></i></a>
                            @endif
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-7">
            <div class="float-left">
                {!! $users->total() !!} {{ __('labels.backend.total') }}
            </div>
        </div>
        <div class="col-5">
            <div class="float-end">
                {!! $users->links() !!}
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
    <!-- Modal -->
    {{-- <div class="modal fade" id="userBlockDeleteModal" tabindex="-1" aria-labelledby="userBlockDeleteModalTitle" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="userBlockDeleteModalTitle">Modal title</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
              </button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
    </div> --}}
</div>