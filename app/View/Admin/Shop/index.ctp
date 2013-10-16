<div class="row">
    <div class="span2">
        <div class="well">
            <ul class="nav nav-list">
                <li><?php echo $this->Html->link("メニューへ戻る", ['controller' => 'admin_menu', action => 'index']); ?></li>
                <li class="divider"></li>
                <li class="active"><?php echo $this->Html->link('支店一覧', ['action' => 'index']); ?></li>
                <li><?php echo $this->Html->link("支店追加", ['action' => 'add']); ?></li>
            </ul>
        </div>
    </div>

    <div class="span10">
        <?php echo $this->Session->flash('flash', ['params' => ['class' => 'alert alert-success']]); ?>
        <h2>支社一覧</h2>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                        <th><?php echo $this->Paginator->sort('id', 'ID'); ?></th>
                        <th><?php echo $this->Paginator->sort('name', '支店名'); ?></th>
<!--
                        <th><?php echo $this->Paginator->sort('address', '住所'); ?></th>
                        <th><?php echo $this->Paginator->sort('tel', '電話番号'); ?></th>
                        <th><?php echo $this->Paginator->sort('email', 'メールアドレス'); ?></th>
-->
                        <th class="actions">コマンド</th>
                </tr>
            </thead>
            <tbody>
<?php $count = 1; foreach ($shops as $shop): ?>
                <tr>
                    <td><?php echo h($shop['Shop']['id']); ?>&nbsp;</td>
                    <td><?php echo h($shop['Shop']['name']); ?>&nbsp;</td>
<!--
                    <td><?php echo h($shop['Shop']['address']); ?>&nbsp;</td>
                    <td><?php echo h($shop['Shop']['tel']); ?>&nbsp;</td>
                    <td><?php echo h($shop['Shop']['email']); ?>&nbsp;</td>
-->
                    <td class="actions">
                        <?php echo $this->Html->link('編集', ['action' => 'edit', $shop['Shop']['id']], ['class' => 'btn btn-success btn-small']); ?>
                        <?php echo $this->Form->postLink('削除', ['action' => 'delete', $shop['Shop']['id']], ['class' => 'btn btn-danger btn-small'], __('%sの支社を削除してもよろしいですか？', $shop['Shop']['name'])); ?>
                    </td>
                </tr>
    <?php $count++; endforeach; ?>
            </tbody>
        </table>
        <p>
        <?php
        echo $this->Paginator->counter([
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ]);
        ?>    </p>

        <div class="paging">
        <?php
            echo $this->Paginator->prev('< 前へ', [], null, array('class' => 'prev disabled'));
            echo $this->Paginator->numbers(['separator' => '']);
            echo $this->Paginator->next('次へ >', [], null, array('class' => 'next disabled'));
        ?>
        </div>
    </div>
</div>
