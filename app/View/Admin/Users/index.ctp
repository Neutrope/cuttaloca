<div class="users index">
    <h2><?php echo 'ユーザ一覧'; ?></h2>
    <table cellpadding="0" cellspacing="0">
    <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('name'); ?></th>
            <th><?php echo $this->Paginator->sort('prefecture'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>
    <?php
    foreach ($users as $user): ?>
    <tr>
        <td><?php echo h($user['User']['id']); ?>&nbsp;</td>
        <td><?php echo h($user['User']['name']); ?>&nbsp;</td>
        <td><?php echo h($user['User']['prefecture']); ?>&nbsp;</td>
        <td class="actions">
            <?php echo $this->Html->link('編集', array('action' => 'edit', $user['User']['id'])); ?>
            <?php echo $this->Form->postLink('削除', array('action' => 'delete', $user['Account']['id']), null, __('%sのユーザを削除してもよろしいですか？', $user['User']['id'])); ?>
        </td>
    </tr>
<?php endforeach; ?>
    </table>
    <p>
    <?php
    echo $this->Paginator->counter(array(
        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
    ));
    ?>    </p>

    <div class="paging">
    <?php
        echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
    ?>
    </div>
</div>
<div class="actions">
    <h3><?php echo 'Action'; ?></h3>
    <ul>
        <li><?php echo $this->Html->link("メニューへ戻る", array('controller' => 'admin_menu', action => 'index')); ?></li>
        <li><?php echo $this->Html->link("ユーザ作成", array('action' => 'add')); ?></li>
        <li><?php echo $this->Html->link("CSVテンプレートダウンロード", array('action' => 'template')); ?></li>
        <li>CSVアップロード</li>
        <li>
            <form action="/admin/user/upload/" enctype="multipart/form-data" id="QuestionAddForm" method="post" accept-charset="utf-8">
                <input type="file" name="data[csv]" id="csvUpload" /><br />
                <div class="submit">
                    <input type="submit" value="アップロード" />
                </div>
            </form>
        </li>
    </ul>
</div>
