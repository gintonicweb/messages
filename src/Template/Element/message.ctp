<div style="margin: 30px 0;">
    <div class="pull-left">
        <img src="/messages/img/avatar.jpg" class="img-circle" style="margin: 0 10px;" alt="John Doe">
    </div>
    <div>
        <span class="pull-right"><?= h($message->created) ?></span>
        <p><a href="#"><?= $message->user->first ?></a></p>
        <?= $message->body ?>
    </div>
</div>
