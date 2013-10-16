<div class="row">
    <div class="span2">
        <div class="well">
            <ul class="nav nav-list">
                <li class="nav-header">メニュー</li>
                <li><?php echo $this->Html->link('メニューへ戻る', ['controller' => 'admin_menu', action => 'index']); ?></li>
                <li class="divider"></li>
                <li class="active"><?php echo $this->Html->link('アカウント一覧', ['action' => 'index']); ?></li>
                <li><?php echo $this->Html->link('アカウント作成', ['action' => 'add']); ?></li>
            </ul>
        </div>
    </div>
    <div class="span10">
        <?php echo $this->Session->flash('flash', ['params' => ['class' => 'alert alert-success']]); ?>
        <h2>アカウント一覧</h2>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                        <th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
                        <th><?php echo $this->Paginator->sort('login_id', 'ログインID'); ?></th>
                        <th><?php echo $this->Paginator->sort('email', 'メールアドレス'); ?></th>
                        <th><?php echo $this->Paginator->sort('last_login', '最終ログイン'); ?></th>
                        <th class="actions">コマンド</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($accounts as $account): ?>
                <tr>
                    <td><?php echo h($account['Account']['id']); ?>&nbsp;</td>
                    <td><?php echo h($account['Account']['login_id']); ?>&nbsp;</td>
                    <td><?php echo h($account['Account']['email']); ?>&nbsp;</td>
                    <td><?php echo h($account['Account']['last_login']); ?>&nbsp;</td>
                    <td class="actions">
                        <?php echo $this->Html->link('編集', ['action' => 'edit', $account['Account']['id']], ['class' => 'btn btn-success btn-small']); ?>
                        <?php echo $this->Form->postLink('削除', ['action' => 'delete', $account['Account']['id']], ['class' => 'btn btn-danger btn-small'], __('%sのアカウントを削除してもよろしいですか？', $account['Account']['id'])); ?>
                    </td>
                </tr>
            </tbody>
<?php endforeach; ?>
        </table>
        <p>
        <?php
        echo $this->Paginator->counter([
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ]);
        ?>    </p>

        <div class="paging">
            <?php
                echo $this->Paginator->prev('< 前へ', [], null, ['class' => 'prev disabled']);
                echo $this->Paginator->numbers(['separator' => '']);
                echo $this->Paginator->next('次へ >', [], null, ['class' => 'next disabled']);
            ?>
        </div>
    </div>
</div>