@extends('layouts.app')

@section('content')
<div id="wrapper">
    <div class="navbar-success sidebar" role="navigation">
        @if(Auth::check())
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                @can('update-inventory')
                <li {{ (Request::is('*history/notify') ? 'class="active"' : '') }}>
                    <a href="{{ url ('history/notify') }}">Notifications</a>
                </li>
                @endcan
                <li >
                    <a href="#Inventory" data-toggle="collapse" aria-expanded="false">Inventory Management<span class="caret"></span></a>
                    <ul class="collapse nav nav-second-level" id="Inventory">
                        <li {{ (Request::is('*inventories') ? 'class="active"' : '') }}>
                            <a href="#level3" data-toggle="collapse" aria-expanded="false">Search/Edit/Delete<span class="caret"></span></a>
                            <ul class="collapse nav nav-third-level" id="level3">
                                <li>
                                    <a href="/inventorie/allint">All Inventories</a>
                                </li>
                                <li>
                                    <a href="/inventories">Currently Available</a>
                                </li>
                            </ul>
                        </li>
                        @can('update-inventory')
                        <li {{ (Request::is('*inventory/issue') ? 'class="active"' : '') }}>
                            <a href="{{ url ('inventory/issue' ) }}">Issue Inventory</a>
                        </li>
                        @endcan
                        @can('issue-inventory')
                        <li {{ (Request::is('*inventories/create') ? 'class="active"' : '') }}>
                            <a href="{{ url('inventories/create') }}">Add New Inventory</a>
                        </li>
                        @endcan
                        @can('update-inventory')
                        <li {{ (Request::is('*inventory/unavailable') ? 'class="active"' : '') }}>
                            <a href="{{ url('inventory/unavailable') }}">Return Inventory</a>
                        </li>
                        @endcan
                        <li {{ (Request::is('*histories') ? 'class="active"' : '') }}>
                            <a href="{{ url('histories') }}">Borrowing History</a>
                        </li>
                    </ul>
                        <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#Lecturer" data-toggle="collapse" aria-expanded="false">Lecturer Management<span class="caret"></span></a>
                    <ul class="collapse nav nav-second-level" id="Lecturer">
                        <li>
                            <a href="/lecturers">All Lecturers (Edit/Delete)</a>
                        </li>
                    </ul>
                        <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#Supervisor" data-toggle="collapse" aria-expanded="false">Supervisor Management<span class="caret"></span></a>
                    <ul class="collapse nav nav-second-level" id="Supervisor">
                        <li {{ (Request::is('*supervisors') ? 'class="active"' : '') }}>
                            <a href="{{ url ('supervisors') }}">All Supervisors (Edit/Delete)</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#TO" data-toggle="collapse" aria-expanded="false">Technical Officer Management<span class="caret"></span></a>
                    <ul class="collapse nav nav-second-level" id="TO">
                        <li {{ (Request::is('*tos') ? 'class="active"' : '') }}>
                            <a href="{{ url ('tos') }}">All Technical Officers (Edit/Delete)</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li {{ (Request::is('*documentation') ? 'class="active"' : '') }}>
                    <a href="{{ url ('documentation') }}">Edit Profile</a>
                </li>
            </ul>
        </div>
        @endif
        <!-- /.sidebar-collapse -->
    </div>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
               <h1 class="page-header">@yield('page_heading')</h1>
            </div>
           <!-- /.col-lg-12 -->
        </div>
       <div class="row">  
           @yield('section')
           @if(Request::is('dashboard'))
           <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">Dashboard</div>
            
                            <div class="panel-body">
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
            
                                You are logged in as {{Auth::user()->name}} !
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        @endif
       </div>
       <!-- /#page-wrapper -->
   </div>
</div>
@endsection
