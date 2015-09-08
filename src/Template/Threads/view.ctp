<div class="container">
    <h2> 
        <?php 
            $users = $thread->toArray()['users'];
            $users = \Cake\Utility\Hash::extract($users, '{n}.first');
            echo $this->Text->toList($users);
        ?>
        <small><?= $thread->title ?></small>
    </h2>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <?= $this->Html->link(
                '<i class="fa fa-plus"></i> New Message',
                [
                    'plugin' => 'messages',
                    'controller' => 'threads',
                    'action' => 'add',
                ],
                [
                    'class' => 'btn btn-default',
                    'escape' => false
                ]
            ) ?>
            <div class="pull-right">
                <?= $this->Html->link(
                    '<i class="fa fa-cog"></i>',
                    [],
                    [
                        'class' => 'btn btn-default',
                        'escape' => false
                    ]
                ) ?>
            </div>

            <?php foreach ($messages as $message) : ?>
                <?= $this->element('message', ['message' => $message]) ?>
            <?php endforeach; ?>

            <?= $this->Form->create(null, [
                'url' => ['controller' => 'messages', 'action' => 'add']
            ]) ?>
            <?= $this->Form->input('thread_id', [
                'type' => 'hidden',
                'value' => $thread->id
            ]) ?>
            <div class="input-group">
                <input id="body" name="body" type="text" class="form-control" placeholder="Your message...">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-default">Send</button>
                </div>
            </div>
            <?= $this->Form->end() ?>

        </div>
        <div class="col-md-4">
            <?php foreach ($threads as $thread) : ?>
                <?= $this->element('preview', ['thread' => $thread]) ?>
            <?php endforeach; ?>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                </ul>
            </div>
        </div>
    </div>
</div>
