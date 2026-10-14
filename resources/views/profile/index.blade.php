@extends('layout.main')

@section('content')

    @include('layout.parts.page-heading', [
        'title' => 'My Profile',
        'breadcrumbs' => [
            [
                'label' => 'Profile'
            ]
        ]
    ])

    @include('layout.parts.flash-messages')

    <section class="profile-section">
        <div class="container">
            <div class="profile-grid">
                <aside class="content-card profile-side">
                    <div class="avatar">{{$initials}}</div>
                    <h4>
                        @if(count($names)>1)
                            {{$names[0]}} {{$names[count($names) - 1]}}
                        @else
                            {{$names[0]}}
                        @endif
                    </h4>
                    <p>{{$user->email}}</p>
                    <ul class="profile-menu">
                        <li><a class="active" href="{{route('customer.profile.show')}}">Overview</a></li>
                        <li><a href="{{route('customer.profile.edit.show')}}">Edit profile</a></li>
                        <li><a href="{{route('customer.purchases.index')}}">My purchases</a></li>
                        <li><a href="{{route('customer.profile.change-password.show')}}">Change password</a></li>
                        <li>
                            <form action="{{route('logout')}}" method="POST">
                                @csrf
                                <button type="submit" class="profile-menu-button">
                                    Sign out
                                </button>
                            </form>
                        </li>
                    </ul>
                </aside>
                <div class="content-card">
                    <h3>Account overview</h3>
                    <p class="intro">Your main account information.</p>
                    <div class="data-list">
                        <div class="data-item">
                            <span>Full name</span>
                            <strong>{{$user->name}}</strong>
                        </div>
                        <div class="data-item">
                            <span>Username</span>
                            <strong>{{$user->username}}</strong>
                        </div>
                        <div class="data-item">
                            <span>Email</span>
                            <strong>{{$user->email}}</strong>
                        </div>
                        <div class="data-item">
                            <span>Account status</span>
                            <strong>{{$user->email_verified_at ? 'Verified' : 'Not verified'}}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
