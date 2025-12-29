


    <div id="myResult" class="modal fade printable">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<img src="<?php echo base_url();?>assets/img/result-banner.png" />
                    <h4 class="modal-title">
                    <?php 
                    if (isset($info))
                    {
                        echo $info->fname." ".$info->lname;
                    }
                    ?>
                    </h4>

                </div>

                <div class="modal-body">

<div class="pqMain">

         <table class="table table-striped mw800">
                  <thead>
                    <tr>
                      <th>S/N</th>
                      <th>Subject</th>
                      <th>Score</th>
                    </tr>
                  </thead>
                  <tbody>
            <?php
        $i = 1;
            foreach ($result as $res):
            ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $res->subject; ?></td>
                      <td><?php echo $res->score; ?></td>
                    </tr>
        <?php 
        $i++;
        endforeach;
        ?>
        </tbody>
        </table>
<br />
<div>
</div>

</div>

                </div>

                <div class="modal-footer">

<a href="javascript:window.print()" class="btn btn-success mr10">
                    <i class="fa fa-print pr5"></i> Print Result</a>
    <!-- <button class="btn btn-success">Print</button> -->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->

                </div>

            </div>

        </div>

    </div>