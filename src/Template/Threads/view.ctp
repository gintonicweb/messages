<div class="container">
    <div class="row">
        <div class="col-md-8">
            <hr>
            <div class="pull-right">
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
                <?= $this->Html->link(
                    '<i class="fa fa-cog"></i>',
                    [],
                    [
                        'class' => 'btn btn-default',
                        'escape' => false
                    ]
                ) ?>
            </div>
            <h2>Philippe Lafrance</h2>
            <hr>
            <?php foreach ($messages as $message) : ?>
                <?= $this->element('message', ['message' => $message]) ?>
            <?php endforeach; ?>
            <?= $this->Form->create(null, [
                'url' => ['controller' => 'messages', 'action' => 'add']
            ]) ?>
                <?= $this->Form->input('thread_id', [
                    'type' => 'hidden',
                    'value' => $messages->first()->thread_id
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
            <hr>
            <div class="pull-right">
                <?= $this->Html->link(
                    'Inbox <i class="fa fa-caret-down"></i>',
                    [],
                    [
                        'class' => 'btn btn-default',
                        'escape' => false
                    ]
                ) ?>
            </div>
            <h2>Threads</h2>
            <hr>
            <div class="content-frame-right">
                <div class="list-group list-group-contacts border-bottom push-down-10">
                    <?php foreach ($threads as $thread) : ?>
                        <?= $this->Html->link(
                        $this->element('preview', ['thread' => $thread]), 
                        [
                            'plugin' => 'messages',
                            'controller' => 'threads',
                            'action' => 'view',
                            $thread->id,
                        ],
                        [
                            'class' => 'list-group-item',
                            'escape' => false,
                        ]
                    ) ?>
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
    </div>
</div>





