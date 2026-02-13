<div class="container" style="color: white; padding: 20px;">
    <h2>Dashboard</h2>
    
    <a href="/trans/add" class="btn-add" style="color: #0ff; border: 1px solid #0ff; padding: 10px; text-decoration: none;">+  Add new amount</a>
    
    <br><br>
    
    <table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-color: #333;">
        <thead>
            <tr style="background: #1a1a1a; color: #0ff;">
                <th>Date</th>
                <th>Title</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $t): ?>
            <tr>
                <td><?= $t->created_at ?></td>
                <td><?= $t->title ?></td>
                <td>
                    <?= isset($t->category_name) ? $t -> category_name : $t -> category_id ?>
                </td>
                <td style="color: #ff6b6b; font-weight: bold;">
                    <?= number_format($t->amount) ?> VNĐ
                </td>
                <td>
                    <a href="/trans/delete?id=<?= $t->id ?>" 
                       onclick="return confirm('Confirm this deletion will be permanent and cannot be undone.')"
                       style="color: red;">[Delete]</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>