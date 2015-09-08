<div class="panel panel-default">
    <div class="panel-heading">
        <span class="pull-right"><i class="fa fa-times"></i></span>
        <?= h($thread->modified) ?>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="/messages/img/avatar.jpg" class="img-circle img-responsive center-block" alt="Jason Statham">
                <?= $this->Html->link('view', [
                    'plugin' => 'messages',
                    'controller' => 'threads',
                    'action' => 'view',
                    $thread->id,
                ]) ?>
            </div>
            <div class="col-md-9">
                <?php foreach($thread->users as $user) : ?>
                    <i class="fa fa-circle-o"></i> <?= $user->first ?>
                <?php endforeach ?>
                <p><?= $thread->_matchingData['Messages']['body'] ?></p>
            </div>
        </div>
    </div>
</div>
