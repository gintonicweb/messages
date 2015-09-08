<i class="fa fa-circle-o"></i>
<span class="pull-right"><?= h($thread->modified) ?></span>
<img src="/messages/img/avatar.jpg" class="pull-left img-circle" alt="Jason Statham" style="margin:0 10px;">
<?php foreach($thread->users as $user) : ?>
    <?= $user->first ?>
<?php endforeach ?>
<p><?= $thread->_matchingData['Messages']['body'] ?></p>
