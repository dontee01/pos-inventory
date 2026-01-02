
    <aside class="navigation">
        <nav class="non-printable">
            <div class="sidebar content-box-compose">
                {{-- <button id="help" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#helpModal">Help</button> --}}
            </div>

            <?php
            // include_once './modals/compose.php';
            // include_once './modals/compose-draft.php';
            // include_once './modals/schedule.php';
            // include_once './modals/add-file.php';
            // include_once './modals/add-file-draft.php';
            // include_once './modals/delete.php';
            // include_once './modals/delete-sent.php';
            // include_once './modals/delete-schedule.php';
            // include_once './modals/delete-notification.php';
            ?>
            <ul class="nav luna-nav" id="nav">

                <li >
                    <a class="nav-cat" href="#monitoring" data-toggle="collapse" aria-expanded="false"><img class="parent-icon" src="{{ asset('images/message_icon.svg') }}">
                        Transactions<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="monitoring" class="nav nav-second collapse nav-load">
                    @if((Session::get('level') == 1) || (Session::get('level') == 3))
                        <li><a class="icon-send_2" id="sent" href="{{url('order')}}">Order</a></li>
                        <li><a class="icon-send_2" id="sent" href="{{url('pending')}}">Pending Orders</a></li>
                        <li><a class="icon-send_2" id="sent" href="{{url('purchase')}}">Purchase</a></li>
                    @endif
                    @if((Session::get('level') == 1) || (Session::get('level') == 2))
                        <li><a class="icon-send_2" id="sent" href="{{url('sales')}}">Pending Sales</a></li>
                        <li><a class="icon-send_2" id="sent" href="{{url('sales/individual')}}">Individual Sales</a></li>
                    @endif
                        <!-- <li><a class="icon-send_2" id="sent" href="{{url('print')}}">Print</a></li> -->
                    </ul>
                </li>

                @if((Session::get('level') == 1) || (Session::get('level') == 3))
                <li>
                    <a class="nav-cat" href="#uielements" data-toggle="collapse" aria-expanded="false"><img class="parent-icon" src="{{ asset('images/contact_icon.svg') }}"> Admin Control
                    <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="uielements" class="nav nav-second collapse nav-load">
                    @if((Session::get('level') == 1))
                        <li><a class="icon-people" id="groups" href="{{url('items')}}">Items</a></li>
                        <li><a class="icon-people" id="groups" href="{{url('customers')}}">Customers</a></li>
                        <li><a class="icon-people" id="groups" href="{{url('suppliers')}}">Suppliers</a></li>
                        <li><a class="icon-people" id="groups" href="{{url('drivers')}}">Drivers</a></li>
                        <li><a class="icon-people" id="groups" href="{{url('users')}}">Users</a></li>
                        <li><a class="icon-people" id="groups" href="{{url('purchase/bottle')}}">RGB Purchase</a></li>
                    @endif
                        <li><a class="icon-people" id="groups" href="{{url('sales/bottle')}}">RGB Sales</a></li>
                        <li><a class="icon-people" id="groups" href="{{url('bottle/show')}}">Bottle Log</a></li>
                    </ul>
                </li>
                @endif

                
                
                <li >
                    <a class="nav-cat" href="{{url('report')}}" ><img class="parent-icon" src="{{ asset('images/message_icon.svg') }}">
                        Report<span class="sub-nav-icon"> </span>
                    </a>
                </li>
                <li>
                    <a class="nav-cat" href="{{url('filter')}}" ><img class="parent-icon" src="{{ asset('images/message_icon.svg') }}">
                        Filter Report<span class="sub-nav-icon"> </span>
                    </a>
                </li>
                


                <li>
                    <a class="nav-cat" href="#tables" data-toggle="collapse" aria-expanded="false"><img class="parent-icon" src="{{ asset('images/account_circle.svg') }}"> Account
                    <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="tables" class="nav nav-second collapse nav-load">
                        <!-- <li><a class="icon-settings" id="settings" href="#settings">Settings</a></li> -->
                        <li><a class="icon-exit_to_app" id="logout" href="{{url('logout')}}">Logout</a></li>
                    </ul>
                </li>

            </ul>
        </nav>



    </aside>