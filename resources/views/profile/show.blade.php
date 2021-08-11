@extends('layouts.app')

@section('title', 'Profil')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Profil</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link @if (request('pills') == '') active @endif" href="{{ route('profile.show') }}">Profil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request('pills') == 'password') active @endif" href="{{ route('profile.show') }}?pills=password">Password</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (request('pills') == 'bank') active @endif" href="{{ route('profile.show') }}?pills=bank">Bank</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade @if (request('pills') == '') show active @endif" id="pills-profil" role="tabpanel" aria-labelledby="pills-profil-tab">
                @includeIf('profile.update-profile-information-form')
            </div>
            <div class="tab-pane fade @if (request('pills') == 'password') show active @endif" id="pills-password" role="tabpanel" aria-labelledby="pills-password-tab">
                @includeIf('profile.update-password-form')
            </div>
            <div class="tab-pane fade @if (request('pills') == 'bank') show active @endif" id="pills-bank" role="tabpanel" aria-labelledby="pills-bank-tab">
                @includeIf('profile.bank')
            </div>
        </div>
    </div>
</div>

@endsection