<div class="container" style="color: white; padding: 20px;">
    <h3>New transaction</h3>
    
    <form action="/trans/add" method="POST">
        <div style="margin-bottom: 15px;">
            <label>Title (what to purchase)</label><br>
            <input type="text" name="title" required style="width: 100%; padding: 8px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Amount (price or budget)</label><br>
            <input type="number" name="amount" required style="width: 100%; padding: 8px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Category</label><br>
            <select name="category_id" style="width: 100%; padding: 8px;">
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat->id ?>"><?= $cat->title ?></option>
                <?php endforeach; ?>
                <option value="1">Dining</option> 
                <option value="2">Vehicle</option>
            </select>
        </div>
        
        <button type="submit" style="background: #0ff; color: #000; padding: 10px 20px; border: none; cursor: pointer;">Save</button>
        <a href="/dashboard" style="color: #ccc; margin-left: 10px;">Cancel</a>
    </form>
</div>