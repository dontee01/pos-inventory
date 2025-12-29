<div class="modal fade" id="deleteNotificationModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bbn-modal">
                    <form method="post" id="compose-modal">
                        <div class="modal-header text-left">
                            <div class="text-right">
                                <button class="glyphicon glyphicon-remove" data-dismiss="modal" style="border:0px;"></button>
                            </div>
                            <div class="text-left">
                                <h4 class="modal-title">Delete Item</h4>
                            </div>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete?
                        </div>
                        <div class="modal-footer">

        <form method="post" action="{{url('item/edit/'.$item['id'])}}">
         {{ csrf_field() }}
                            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                            <!-- <button type="button" class="btn btn-danger btn-recharge" id="delete-notification-confirm" data-dismiss="modal" >Delete</button> -->
                            <a id="delete-modal-item" href="{{url('/item/delete/')}}" type="button" class="btn btn-danger btn-recharge" id="delete-notification-confirm" data-dismiss="modal" >Delete</a>
                            <button type="button" class="btn btn-modal-save pull-left"
                                    data-dismiss="modal" >Cancel</button>
        </form>
                        </div>
                    </form>
                    </div>
                </div>
            </div>