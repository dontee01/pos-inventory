
    <aside class="navigation">
        <nav>
        
            <div class="sidebar content-box-compose">
                <button id="compose" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#myModal">Compose SMS</button>
            </div>

            <ul class="nav luna-nav">

                <li >
                    <a class="nav-cat" href="#monitoring" data-toggle="collapse" aria-expanded="false"><img src="images/message_icon.svg">
                        Messages<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="monitoring" class="nav nav-second collapse">
                            <li><a class="icon-send_2" href="sent-messages.php">Sent Messages</a></li>
                            <li><a  class="icon-textsms" href="">Drafts</a></li>
                            <li><a class="icon-schedule" href="">Schedules</a></li>
                            <li><a class="icon-notifications_on" href="">Notifications</a></li>
                    </ul>
                </li>

                <li>
                    <a class="nav-cat" href="#uielements" data-toggle="collapse" aria-expanded="false"><img src="images/contact_icon.svg"> Contacts
                    <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="uielements" class="nav nav-second collapse">
                            <li><a class="icon-people" href="">Manage Groups</a></li>
                            <li><a  class="icon-person" href="">Manage Contacts</a></li>
                            <li><a class="icon-save" href="">Backup Contacts</a></li>
                            <li><a class="icon-restore" href="">Restore Contacts</a></li>
                    </ul>
                </li>


                <li>
                    <a class="nav-cat" href="#tables" data-toggle="collapse" aria-expanded="false"><img src="images/account_circle.svg"> Account
                    <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="tables" class="nav nav-second collapse">
                            <li><a class="icon-credit_card" href="">Recharge</a></li>
                            <li><a  class="icon-share_alt" href="">Share Credits</a></li>
                            <li><a class="icon-settings" href="">Settings</a></li>
                            <li><a class="icon-exit_to_app" href="">Logout</a></li>
                    </ul>
                </li>


                <li>
                    <a class="nav-cat" href="#charts" data-toggle="collapse" aria-expanded="false"><img src="images/help_2.svg"> Help
                    <span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                    </a>
                    <ul id="charts" class="nav nav-second collapse">
                            <li><a class="icon-naira_symb_1" href="">Pricing</a></li>
                            <li><a  class="icon-help" href="">How to Recharge</a></li>
                            <li><a class="icon-info" href="">About Dart Pro</a></li>
                    </ul>
                </li>

            </ul>
        </nav>

         <!--    <div class="sidebar content-box-compose" style="display: block;">
                <button id="compose" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#myModal">COMPOSE SMS</button>
            </div> -->


            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bbn-modal">
                    <form method="post" id="compose-modal">
                        <div class="modal-header text-left">
                            <div class="text-right">
                                <button class="glyphicon glyphicon-remove" data-dismiss="modal" style="border:0px;"></button>
                            </div>
                            <div class="text-left">
                                <h4 class="modal-title">Compose Message</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            <!-- <h4 class="m-t-none">Compose Message</h4> -->
                            <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever.</p> -->
                            <div class="row">

                                    <!-- <div class="panel "> -->

                                        
                                        <div class="panel-body">
                                            <div class="">
                                                <div class=form-group>
                                                 <input class="form-control" type="text" name="sender" id="sender" placeholder="Sender Name" />
                                                </div>
                                            </div>
                                        </div>
                                    <!-- </div> -->

                                    <!-- <div class="panel "> -->

                                        <div class="panel-body">
                                            <div class="">
                                                <div class=form-group>
                                                    <label class=" pull-right"><a class=""><i class="icon-person"></i></a></label>
                                                    <textarea class="form-control" name="number" id="number" rows="" placeholder="Enter Numbers or Add from Contacts"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- </div> -->

                                    <!-- <div class="panel "> -->

                                        
                                        <div class="panel-body">
                                            <div class="">
                                                <div class=form-group>
                                                    <label></label>
                                                    <textarea class="form-control" name="message" id="message" rows="3" placeholder="Enter your message"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- </div> -->

                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                            <button type="button" class="btn btn-modal-save pull-left" data-dismiss="modal">Save</button>
                            <button type="button" class="btn btn-danger btn-recharge">Send</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
    </aside>