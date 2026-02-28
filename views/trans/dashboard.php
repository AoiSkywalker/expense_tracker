<div class="container" style="color: white; padding: 20px; width: 80vw; ">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Dashboard</h2>
        <a href="/trans/add" style="background: #0ff; color: #000; font-weight: bold; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Add transaction</a>
    </div>

    <div style="display: flex; gap: 20px; margin-bottom: 30px;">
        <div style="flex: 1; background: #1a1a1a; padding: 20px; border-radius: 10px; border-bottom: 4px solid #0ff;">
            <h4 style="margin: 0 0 10px 0; color: #aaa;">Current Balance</h4>
            <h2 style="margin: 0; color: <?= $balance >= 0 ? '#0ff' : '#ff6b6b' ?>;">
                <?= number_format($balance) ?> VND
            </h2>
        </div>
        
        <div style="flex: 1; background: #1a1a1a; padding: 20px; border-radius: 10px; border-bottom: 4px solid #4ecdc4;">
            <h4 style="margin: 0 0 10px 0; color: #aaa;">Total Income</h4>
            <h2 style="margin: 0; color: #4ecdc4;">+ <?= number_format($totalIncome) ?> VND</h2>
        </div>
        
        <div style="flex: 1; background: #1a1a1a; padding: 20px; border-radius: 10px; border-bottom: 4px solid #ff6b6b;">
            <h4 style="margin: 0 0 10px 0; color: #aaa;">Total Expense</h4>
            <h2 style="margin: 0; color: #ff6b6b;">- <?= number_format($totalExpense) ?> VND</h2>
        </div>
    </div>
    
    <div style="display: flex; gap: 20px;">
        
        <div style="width: 35%; background: #1a1a1a; padding: 20px; border-radius: 10px;">
            <h3 style="margin-top: 0; border-bottom: 1px solid #333; padding-bottom: 10px;">Expense Chart</h3>
            <div style="height: 300px;">
                <canvas id="expenseChart"></canvas>
            </div>
        </div>

        <div style="width: 65%; background: #1a1a1a; padding: 20px; border-radius: 10px;">
            <h3 style="margin-top: 0; border-bottom: 1px solid #333; padding-bottom: 10px;">History</h3>
            
            <div style="background: #222; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 15px; flex-wrap: wrap;">
                
                <div style="flex: 1; min-width: 120px;">
                    <label style="color: #0ff; font-size: 12px; font-weight: bold;">[ Group by ]</label><br>
                    <select id="groupBy" onchange="renderTable()" style="width: 100%; background: #111; color: white; border: 1px solid #444; padding: 6px; margin-top: 5px;">
                        <option value="none">None</option>
                        <option value="date">Date</option>
                        <option value="category">Category</option>
                    </select>
                </div>

                <div style="flex: 1; min-width: 120px;">
                    <label style="color: #0ff; font-size: 12px; font-weight: bold;">Type of transaction</label><br>
                    <select id="filterType" onchange="renderTable()" style="width: 100%; background: #111; color: white; border: 1px solid #444; padding: 6px; margin-top: 5px;">
                        <option value="all">All</option>
                        <option value="income">Income only</option>
                        <option value="expense">Expense only</option>
                    </select>
                </div>

                <div style="flex: 1; min-width: 120px;">
                    <label style="color: #0ff; font-size: 12px; font-weight: bold;">Amount by</label><br>
                    <select id="filterAmount" onchange="renderTable()" style="width: 100%; background: #111; color: white; border: 1px solid #444; padding: 6px; margin-top: 5px;">
                        <option value="0">All</option>
                        <option value="50000">> 50.000 VND</option>
                        <option value="100000">> 100.000 VND</option>
                        <option value="200000">> 200.000 VND</option>
                        <option value="500000">> 500.000 VND</option>
                    </select>
                </div>

                <div style="flex: 1; min-width: 120px;">
                    <label style="color: #0ff; font-size: 12px; font-weight: bold;">Category</label><br>
                    <select id="filterCategory" onchange="renderTable()" style="width: 100%; background: #111; color: white; border: 1px solid #444; padding: 6px; margin-top: 5px;">
                        <option value="all">All</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat->id ?>"><?= $cat->title ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <table width="100%" style="border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid #444; color: #888;">
                        <th style="padding: 10px 0;">Date</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="transactionBody"></tbody>
            </table>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const formatMoney = (v) => new Intl.NumberFormat('vi-VN').format(v) + ' VND';
    function formatDate(dateStr) {
        if (!dateStr) return 'N/A';
        let datePart = dateStr.split(' ')[0]; 
        let parts = datePart.split('-');
        if(parts.length === 3) return `${parts[2]}/${parts[1]}/${parts[0]}`;
        return dateStr;
    }

    let myChart = null;
    const rawTransactions = <?= $transactionsJson ?>;


    function updateChart(chartLabels, chartData) {
        const ctx = document.getElementById('expenseChart').getContext('2d');
        
        if (myChart) myChart.destroy();

        myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: chartLabels,
                datasets: [{
                    data: chartData,
                    backgroundColor: ['#4ecdc4','#ff6b6b',  '#ffe66d', '#1a535c', '#ff9f1c', '#2ec4b6', '#c92a2a', '#fcc419'],
                    borderWidth: 0
                }]
            },
            options: {
                animation: false,
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%', 
                plugins: {
                    legend: { position: 'bottom', labels: { color: '#ccc', padding: 20 } },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => ` ${ctx.label}: ${formatMoney(ctx.raw)}`
                        }
                    }
                }
            }
        });
    }



    function createRowHTML(t) {
        let catType = t.category_type || 'expense';
        let amountColor = catType === 'income' ? '#4ecdc4' : '#ff6b6b';
        let amountSign = catType === 'income' ? '+' : '-';
        let catName = t.category_name || 'Other';

        return `
        <tr style="border-bottom: 1px solid #333;">
            <td style="padding: 10px 0; color: #aaa;">${formatDate(t.created_at)}</td>
            <td>${t.title}</td>
            <td><span style="background: #333; padding: 3px 8px; border-radius: 4px; font-size: 12px;">${catName}</span></td>
            <td style="font-weight: bold; color: ${amountColor};">
                ${amountSign} ${formatMoney(t.amount)}
            </td>
            <td>
                <a href="/trans/delete?id=${t.id}" onclick="return confirm('Delete this transaction ?')" style="color: #ff6b6b; text-decoration: none;">[ Delete ]</a>
            </td>
        </tr>`;
    }

    function renderTable() {
        const groupBy = document.getElementById('groupBy').value;
        const filterType = document.getElementById('filterType').value;
        const filterAmount = parseFloat(document.getElementById('filterAmount').value);
        const filterCategory = document.getElementById('filterCategory').value;

        let filtered = rawTransactions.filter(t => {
            let catType = t.category_type || 'expense';
            let passType = (filterType === 'all') || (catType === filterType);
            let passAmount = parseFloat(t.amount) >= filterAmount;
            let passCategory = (filterCategory === 'all') || (t.category_id == filterCategory);
            return passType && passAmount && passCategory;
        });

        let chartMap = {};
        if (filterType === 'all' && filterCategory === 'all') {
            let totalIn = 0, totalOut = 0;
            filtered.forEach(t => {
                const type = (t.category_type || 'expense').toLowerCase().trim();
                if (type === 'income') totalIn += parseFloat(t.amount);
                else totalOut += parseFloat(t.amount);
            });
            chartMap = { 'Total Income': totalIn, 'Total Expense': totalOut };
        } else {
            filtered.forEach(t => {
                const name = t.category_name || 'Other';
                chartMap[name] = (chartMap[name] || 0) + parseFloat(t.amount);
            });
        }

        updateChart(Object.keys(chartMap), Object.values(chartMap));

        const tbody = document.getElementById('transactionBody');
        tbody.innerHTML = '';

        

        if (filtered.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 30px; color: #666;">No transaction available!</td></tr>';
            return;
        }

        if (groupBy === 'none') {
            filtered.forEach(t => tbody.innerHTML += createRowHTML(t));
        } else {
            let groupedData = {};
            filtered.forEach(t => {
                let key = (groupBy === 'date') ? formatDate(t.created_at) : (t.category_name || 'Other');
                if (!groupedData[key]) groupedData[key] = [];
                groupedData[key].push(t);
            });

            for (let groupName in groupedData) {
                let groupTotal = groupedData[groupName].reduce((sum, item) => {
                    return (item.category_type === 'income') ? sum + parseFloat(item.amount) : sum - parseFloat(item.amount);
                }, 0);
                
                let groupColor = groupTotal >= 0 ? '#4ecdc4' : '#ff6b6b';
                tbody.innerHTML += `
                    <tr style="background: #2a2a2a;">
                        <td colspan="5" style="padding: 10px; font-weight: bold; color: #0ff;">
                            ▾ ${groupName} 
                            <span style="float: right; color: ${groupColor}; font-size: 13px;">
                                Balance: ${formatMoney(Math.abs(groupTotal))}
                            </span>
                        </td>
                    </tr>`;
                groupedData[groupName].forEach(t => tbody.innerHTML += createRowHTML(t));
            }
        }
    }

    renderTable();
</script>