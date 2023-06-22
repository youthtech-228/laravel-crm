@extends ('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend-breadcrumb-item>
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
            <x-slot name="toolbar">
                <x-backend.buttons.return-back />
                <a href='{{ route("backend.$module_name.index") }}' class="btn btn-secondary" data-toggle="tooltip" title="{{ ucwords($module_name) }} List"><i class="fas fa-list"></i> List</a>
            </x-slot>
        </x-backend.section-header>

        <hr>

        <div class="row mt-4">
            <div class="col">
                <table id="datatable" class="table table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Updated At
                            </th>
                            <th>
                                Created By
                            </th>
                            <th class="text-end">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($$module_name as $module_name_singular)
                        <tr>
                            <td>
                                {{ $module_name_singular->id }}
                            </td>
                            <td>
                                {{ $module_name_singular->name }}
                            </td>
                            <td>
                                {{ $module_name_singular->updated_at->diffForHumans() }}
                            </td>
                            <td>
                                {{ $module_name_singular->created_by }}
                            </td>
                            <td class="text-end">
                                <a href="{{route("backend.$module_name.restore", $module_name_singular)}}" class="btn btn-danger btn-sm mt-1" data-method="PATCH" data-token="{{csrf_token()}}"><i class="fas fa-undo" data-toggle="tooltip" title="{{__('labels.backend.restore')}}" data-confirm="Are you sure?"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    Total {{ $$module_name->total() }} {{ ucwords($module_name) }}
                </div>
            </div>
            <div class="col-5">
                <div class="float-end">
                    {!! $$module_name->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="userRestoreModal" tabindex="-1" aria-labelledby="userRestoreModalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userRestoreModalTitle">Attention!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBodyText">
                Are you sure you want to restore the current user?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmUserRestore">Confirm</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section ('after-scripts-end')

@endsection