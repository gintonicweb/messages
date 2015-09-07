<div class="container">
    <div class="row">
        <div class="col-md-8">
            <hr>
            <h2>New message</h2>
            <hr>
            <?= $this->Form->create() ?>
            <?= $this->Form->input('user') ?>
            <?= $this->Form->input('threads.title') ?>
            <?= $this->Form->input('message.body') ?>
            <?= $this->Form->submit('Send', ['class' => 'btn btn-primary']) ?>
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
                    <?php for ($i=0; $i<8; $i++) : ?>
                        <a href="#" class="list-group-item">         
                            <i class="fa fa-circle-o"></i>
                            <?php //h($thread->created) ?>
                            <img src="/messages/img/avatar.jpg" class="pull-left img-circle" alt="Jason Statham" style="margin:0 10px;">
                            <strong>Jason Statham</strong>
                            <p>Wait a minute, Doc. Ah... Are you telling me you built a time machine... out of a DeLorean?</p>
                        </a>                            
                    <?php endfor; ?>
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





