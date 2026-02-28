<div class="container" style="color: white; padding: 20px; max-width: 500px; margin: auto;">
    <h3 style="color: #0ff;">New transaction</h3>
    
    <form action="/trans/add" method="POST" style="background: #1a1a1a; padding: 20px; border-radius: 10px;">
        <div style="margin-bottom: 15px;">
            <label>Title</label><br>
            <input type="text" name="title" required style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444;" placeholder="KFC with friends, bubble tea,...">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Amount</label><br>
            <!-- <input type="number" name="amount" required style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444;" placeholder="100000, 50000"> -->
            <div style="position: relative; width: 100%; margin-top: 5px;">
                <input type="text" id="display_amount" required oninput="formatAmount(this)" autocomplete="off"
                    style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444;" 
                    placeholder="100,000 VND">
                <span style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #aaa; pointer-events: none;">
                    VND
                </span>
            </div>
            <input type="hidden" name="amount" id="real_amount" required>
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Category</label><br>
            <select name="category_id" id="cat_select" onchange="toggleNewCat()" style="width: 100%; padding: 10px; margin-top: 5px; background: #222; color: #fff; border: 1px solid #444;">
                <option value="" disabled selected>-- Select category --</option>
                
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat->id ?>">
                        <?= $cat->title ?> (<?= $cat->type == 'income' ? 'income' : 'expense' ?>)
                    </option>
                <?php endforeach; ?>
                
                <option value="new" style="color: #0ff; font-weight: bold;">[ + ] Add new category...</option>
            </select>
        </div>
        
        <div id="new_cat_fields" style="display: none; background: #2a2a2a; padding: 15px; border-left: 3px solid #0ff; margin-bottom: 15px;">
            <p style="margin-top: 0; color: #0ff; font-size: 14px;">New category</p>
            <label>Name of category</label>
            <input type="text" name="new_cat_title" style="width: 100%; padding: 8px; margin-bottom: 10px; background: #111; color: white; border: 1px solid #555;" placeholder="Lunch, transportation fee, mortgage...">
            
            <label>Type</label>
            <select name="new_cat_type" style="width: 100%; padding: 8px; background: #111; color: white; border: 1px solid #555;">
                <option value="expense">Expense</option>
                <option value="income">Income</option>
            </select>
        </div>
        
        <button type="submit">Save the transaction</button>
        <div class="link">
            <a href="/dashboard" style="color: #888; text-decoration: none;">Back to Dashboard</a>
        </div>
    </form>
</div>

<script>
    function toggleNewCat() {
        var select = document.getElementById('cat_select');
        var newCatDiv = document.getElementById('new_cat_fields');
        var newTitleInput = document.getElementsByName('new_cat_title')[0];
        
        if (select.value === 'new') {
            newCatDiv.style.display = 'block';
            newTitleInput.setAttribute('required', 'required'); 
        } else {
            newCatDiv.style.display = 'none';
            newTitleInput.removeAttribute('required');
        }
    }

    function formatAmount(input) {
        let rawValue = input.value.replace(/\D/g, '');
        document.getElementById('real_amount').value = rawValue;
        if (rawValue !== '') {
            input.value = parseInt(rawValue, 10).toLocaleString('vi-VN'); 
        } else {
            input.value = '';
        }
    }
</script>