<?php foreach ($responses as $respons):?>
    <div id="<?php echo $respons['id']; ?>" class="response mb-3">
        <div class="row">
            <div class="col-3">
                <span><?php echo $respons['name'];?></span><br>
                <span class="text-secondary"><?php echo $respons['email'];?></span><br>
            </div>
            <div class="col-9">
                <span class="response-message"><?php echo $respons['message'];?>
                    <?php if($admin){ echo '<button onclick="openEditMessage(this)" class="btn btn-secondary btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
                    echo ' <button onclick="deleteResponse(this)" class="btn btn-danger btn-sm btn-edit"><i class="fa fa-times-circle" aria-hidden="true"></i></button>';} ?>
                </span>
                <br>
                <span class="text-secondary message-time"><?php echo date("d.m H:i", strtotime($respons['date'])); ?></span>
            </div>
        </div>
    </div>
<?php endforeach;?>